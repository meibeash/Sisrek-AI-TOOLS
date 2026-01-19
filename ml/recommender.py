"""
AI Tools Recommender - Model-Based Collaborative Filtering dengan SVD
======================================================================

Algoritma: Singular Value Decomposition (SVD) dengan Matrix Factorization
Tipe: Model-Based Collaborative Filtering

Implementasi SVD menggunakan NumPy (tanpa perlu scikit-surprise)
SVD bekerja dengan cara:
1. Membuat user-item matrix dari data ratings
2. Melakukan matrix factorization untuk menemukan latent factors
3. Memprediksi rating untuk item yang belum di-rating user
4. Merekomendasikan item dengan predicted rating tertinggi
"""

import os
import pickle
import mysql.connector
import pandas as pd
import numpy as np
from flask import Flask, jsonify, request

app = Flask(__name__)

# Database Configuration
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'ai_tools'
}

# Model storage path
MODEL_PATH = os.path.join(os.path.dirname(__file__), 'svd_model.pkl')


class SVDRecommender:
    """
    SVD Matrix Factorization untuk Collaborative Filtering
    
    Menggunakan Gradient Descent untuk optimasi:
    R ≈ P × Q^T
    
    R = User-Item Rating Matrix
    P = User latent factors matrix
    Q = Item latent factors matrix
    """
    
    def __init__(self, n_factors=20, n_epochs=50, lr=0.005, reg=0.02):
        self.n_factors = n_factors  # Jumlah latent factors
        self.n_epochs = n_epochs    # Jumlah iterasi training
        self.lr = lr                # Learning rate
        self.reg = reg              # Regularization (lambda)
        
        # Model parameters
        self.P = None  # User factors
        self.Q = None  # Item factors
        self.bu = None # User bias
        self.bi = None # Item bias
        self.mu = 0    # Global mean
        
        # Mappings
        self.user_to_idx = {}
        self.idx_to_user = {}
        self.item_to_idx = {}
        self.idx_to_item = {}
    
    def fit(self, ratings_df):
        """
        Train model dengan Stochastic Gradient Descent
        
        Parameters:
        -----------
        ratings_df : DataFrame dengan kolom [user_id, tool_id, rating]
        """
        print("[*] Building user-item mappings...")
        
        # Build mappings
        users = ratings_df['user_id'].unique()
        items = ratings_df['tool_id'].unique()
        
        self.user_to_idx = {u: i for i, u in enumerate(users)}
        self.idx_to_user = {i: u for u, i in self.user_to_idx.items()}
        self.item_to_idx = {t: i for i, t in enumerate(items)}
        self.idx_to_item = {i: t for t, i in self.item_to_idx.items()}
        
        n_users = len(users)
        n_items = len(items)
        
        print(f"   Users: {n_users}, Items: {n_items}")
        
        # Global mean
        self.mu = ratings_df['rating'].mean()
        
        # Initialize factors dengan random kecil
        np.random.seed(42)
        self.P = np.random.normal(0, 0.1, (n_users, self.n_factors))
        self.Q = np.random.normal(0, 0.1, (n_items, self.n_factors))
        self.bu = np.zeros(n_users)
        self.bi = np.zeros(n_items)
        
        # Convert to list for faster iteration
        ratings_list = []
        for _, row in ratings_df.iterrows():
            u = self.user_to_idx[row['user_id']]
            i = self.item_to_idx[row['tool_id']]
            r = float(row['rating'])
            ratings_list.append((u, i, r))
        
        print(f"[*] Training SVD model ({self.n_epochs} epochs)...")
        
        # Training dengan SGD
        for epoch in range(self.n_epochs):
            np.random.shuffle(ratings_list)
            total_error = 0
            
            for u, i, r in ratings_list:
                # Prediksi
                pred = self.mu + self.bu[u] + self.bi[i] + np.dot(self.P[u], self.Q[i])
                
                # Error
                error = r - pred
                total_error += error ** 2
                
                # Update biases
                self.bu[u] += self.lr * (error - self.reg * self.bu[u])
                self.bi[i] += self.lr * (error - self.reg * self.bi[i])
                
                # Update factors
                P_u = self.P[u].copy()
                self.P[u] += self.lr * (error * self.Q[i] - self.reg * self.P[u])
                self.Q[i] += self.lr * (error * P_u - self.reg * self.Q[i])
            
            if (epoch + 1) % 10 == 0:
                rmse = np.sqrt(total_error / len(ratings_list))
                print(f"   Epoch {epoch + 1}/{self.n_epochs}, RMSE: {rmse:.4f}")
        
        print("[OK] Training completed!")
        
        return self
    
    def predict(self, user_id, item_id):
        """Prediksi rating untuk user dan item tertentu"""
        if user_id not in self.user_to_idx or item_id not in self.item_to_idx:
            return None
        
        u = self.user_to_idx[user_id]
        i = self.item_to_idx[item_id]
        
        pred = self.mu + self.bu[u] + self.bi[i] + np.dot(self.P[u], self.Q[i])
        
        # Clamp to 1-5
        return max(1.0, min(5.0, pred))
    
    def recommend(self, user_id, rated_items, n=8):
        """
        Generate rekomendasi untuk user
        
        Parameters:
        -----------
        user_id : ID user
        rated_items : set/list item yang sudah di-rating user
        n : jumlah rekomendasi
        """
        if user_id not in self.user_to_idx:
            return []
        
        predictions = []
        
        for item_id in self.item_to_idx:
            if item_id in rated_items:
                continue
            
            pred = self.predict(user_id, item_id)
            if pred is not None:
                predictions.append({
                    'tool_id': int(item_id),  # Convert numpy int64 to Python int
                    'predicted_rating': round(float(pred), 2)  # Convert to Python float
                })
        
        # Sort by predicted rating
        predictions.sort(key=lambda x: x['predicted_rating'], reverse=True)
        
        return predictions[:n]


# Global model instance
model = None


def get_db_connection():
    """Membuat koneksi ke database MySQL"""
    return mysql.connector.connect(**DB_CONFIG)


def load_ratings_from_db():
    """Load data ratings dari database"""
    conn = get_db_connection()
    query = "SELECT user_id, tool_id, rating FROM ratings"
    df = pd.read_sql(query, conn)
    conn.close()
    return df


def train_model():
    """Train model dengan data dari database"""
    global model
    
    print("[*] Loading ratings data from database...")
    df = load_ratings_from_db()
    
    if df.empty:
        print("[ERR] No ratings data found!")
        return None, {'error': 'No ratings data available'}
    
    print(f"[OK] Loaded {len(df)} ratings from {df['user_id'].nunique()} users")
    
    # Train model
    model = SVDRecommender(
        n_factors=20,
        n_epochs=50,
        lr=0.005,
        reg=0.02
    )
    model.fit(df)
    
    # Save model
    with open(MODEL_PATH, 'wb') as f:
        pickle.dump(model, f)
    
    print(f"[OK] Model saved to {MODEL_PATH}")
    
    metrics = {
        'n_users': df['user_id'].nunique(),
        'n_items': df['tool_id'].nunique(),
        'n_ratings': len(df),
        'n_factors': model.n_factors,
        'n_epochs': model.n_epochs
    }
    
    return model, metrics


def load_model():
    """Load model dari file"""
    global model
    
    if model is not None:
        return model
    
    if os.path.exists(MODEL_PATH):
        with open(MODEL_PATH, 'rb') as f:
            model = pickle.load(f)
        return model
    
    return None


def get_recommendations(user_id, n=8):
    """Generate rekomendasi untuk user"""
    global model
    
    if model is None:
        model = load_model()
    
    if model is None:
        return {'error': 'Model not trained. Call /train first.'}
    
    # Get rated items
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute("SELECT tool_id FROM ratings WHERE user_id = %s", (user_id,))
    rated_items = set(row[0] for row in cursor.fetchall())
    cursor.close()
    conn.close()
    
    # Get recommendations
    recommendations = model.recommend(user_id, rated_items, n)
    
    return {
        'user_id': user_id,
        'recommendations': recommendations,
        'algorithm': 'SVD Model-Based Collaborative Filtering',
        'n_rated': len(rated_items)
    }


# ============================================
# Flask API Endpoints
# ============================================

@app.route('/')
def index():
    """Health check dan info endpoint"""
    return jsonify({
        'service': 'AI Tools Recommender',
        'algorithm': 'SVD (Model-Based Collaborative Filtering)',
        'version': '1.0',
        'endpoints': {
            '/train': 'GET/POST - Train the SVD model',
            '/recommend/<user_id>': 'GET - Get recommendations for a user',
            '/model-info': 'GET - Get model information'
        }
    })


@app.route('/train', methods=['GET', 'POST'])
def train():
    """Endpoint untuk train model"""
    _, metrics = train_model()
    
    if metrics.get('error'):
        return jsonify({'success': False, 'error': metrics['error']}), 400
    
    return jsonify({
        'success': True,
        'message': 'Model trained successfully',
        'metrics': metrics
    })


@app.route('/recommend/<int:user_id>')
def recommend(user_id):
    """Endpoint untuk rekomendasi"""
    n = request.args.get('n', 8, type=int)
    result = get_recommendations(user_id, n)
    
    if 'error' in result:
        return jsonify(result), 400
    
    return jsonify(result)


@app.route('/model-info')
def model_info():
    """Endpoint untuk info model"""
    m = load_model()
    
    if m is None:
        return jsonify({
            'trained': False,
            'message': 'Model not trained. Call /train first.'
        })
    
    return jsonify({
        'trained': True,
        'n_users': len(m.user_to_idx),
        'n_items': len(m.item_to_idx),
        'n_factors': m.n_factors
    })


if __name__ == '__main__':
    print("[*] Starting AI Tools Recommender Service...")
    print("[*] Algorithm: SVD (Model-Based Collaborative Filtering)")
    print("=" * 50)
    
    # Auto-train jika model belum ada
    if not os.path.exists(MODEL_PATH):
        print("[!] No trained model found. Training now...")
        train_model()
    else:
        print("[OK] Loading existing model from:", MODEL_PATH)
        load_model()
    
    print("\n[*] Server running at http://localhost:5000")
    app.run(host='0.0.0.0', port=5000, debug=True)
