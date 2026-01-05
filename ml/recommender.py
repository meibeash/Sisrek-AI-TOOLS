import sys, json
import pandas as pd
import mysql.connector
from sklearn.neighbors import NearestNeighbors

# ==== ambil user_id dari CI3 ====
if len(sys.argv) < 2:
    print(json.dumps([]))
    sys.exit()

user_id = int(sys.argv[1])

# ==== koneksi DB ====
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="ai_tools"
)

df = pd.read_sql(
    "SELECT user_id, tool_id, rating FROM ratings",
    conn
)

# ==== safety check ====
if df.empty:
    print(json.dumps([]))
    sys.exit()

# ==== user-item matrix ====
matrix = df.pivot_table(
    index="user_id",
    columns="tool_id",
    values="rating"
).fillna(0)

if user_id not in matrix.index:
    print(json.dumps([]))
    sys.exit()

# ==== KNN ====
n_neighbors = min(3, len(matrix))
knn = NearestNeighbors(metric="cosine", algorithm="brute")
knn.fit(matrix)

_, idx = knn.kneighbors(
    matrix.loc[user_id].values.reshape(1, -1),
    n_neighbors=n_neighbors
)

# ==== similar users ====
similar_users = matrix.index[idx.flatten()[1:]]

# ==== scoring ====
scores = {}
for u in similar_users:
    for tool, r in matrix.loc[u].items():
        if matrix.loc[user_id, tool] == 0 and r > 0:
            scores[tool] = scores.get(tool, 0) + r

# ==== output ====
if not scores:
    print(json.dumps([]))
else:
    recommended = sorted(scores, key=scores.get, reverse=True)[:5]
    print(json.dumps(recommended))
