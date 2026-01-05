<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating_model extends CI_Model {

    public function save($data)
    {
        return $this->db->replace('ratings',$data);
    }

    public function has_rating($user_id)
    {
        return $this->db->where('user_id',$user_id)
                        ->count_all_results('ratings') > 0;
    }

    public function my_ratings($user_id)
    {
        return $this->db->select('a.company_name, r.rating, r.created_at')
                        ->from('ratings r')
                        ->join('ai_tools a','a.tool_id=r.tool_id')
                        ->where('r.user_id',$user_id)
                        ->get()->result();
    }

    /**
     * Content-Based Filtering dengan Cosine Similarity
     * Menghitung kemiripan antara User Profile Vector dan Tool Feature Vector
     */
    public function get_recommendations($user_id, $limit = 8)
    {
        // Ambil ratings user ini
        $user_ratings = $this->db->where('user_id', $user_id)->get('ratings')->result();
        
        if (empty($user_ratings)) {
            return [];
        }

        // Tool yang sudah di-rating user
        $rated_tool_ids = array_column($user_ratings, 'tool_id');
        
        // Ambil semua tools
        $all_tools = $this->db->get('ai_tools')->result();
        
        // Kumpulkan semua unique categories dan subscription
        $all_categories = [];
        $all_subscriptions = [];
        foreach ($all_tools as $tool) {
            $all_categories[$tool->category ?? 'Unknown'] = true;
            $all_subscriptions[$tool->subscription ?? 'Unknown'] = true;
        }
        $all_categories = array_keys($all_categories);
        $all_subscriptions = array_keys($all_subscriptions);
        
        // ========================================
        // STEP 1: Bangun User Profile Vector
        // ========================================
        $rating_weights = [];
        foreach ($user_ratings as $r) {
            $rating_weights[$r->tool_id] = (float) $r->rating;
        }
        
        $this->db->where_in('tool_id', array_keys($rating_weights));
        $rated_tools_data = $this->db->get('ai_tools')->result();
        
        // Inisialisasi user vector
        $user_vector = [];
        foreach ($all_categories as $cat) {
            $user_vector['cat_' . $cat] = 0;
        }
        foreach ($all_subscriptions as $sub) {
            $user_vector['sub_' . $sub] = 0;
        }
        
        // Akumulasi preferensi berdasarkan rating
        $total_weight = 0;
        foreach ($rated_tools_data as $tool) {
            $weight = ($rating_weights[$tool->tool_id] - 1) / 4; // Normalize 1-5 ke 0-1
            $total_weight += $weight;
            
            $cat = $tool->category ?? 'Unknown';
            $sub = $tool->subscription ?? 'Unknown';
            
            $user_vector['cat_' . $cat] += $weight;
            $user_vector['sub_' . $sub] += $weight;
        }
        
        // Normalisasi user vector
        if ($total_weight > 0) {
            foreach ($user_vector as $key => $val) {
                $user_vector[$key] = $val / $total_weight;
            }
        }
        
        // ========================================
        // STEP 2: Hitung Cosine Similarity dengan setiap Tool
        // ========================================
        $scores = [];
        
        foreach ($all_tools as $tool) {
            if (in_array($tool->tool_id, $rated_tool_ids)) continue;
            
            // Tool feature vector (one-hot encoding)
            $tool_vector = [];
            foreach ($all_categories as $cat) {
                $tool_vector['cat_' . $cat] = ($tool->category == $cat) ? 1 : 0;
            }
            foreach ($all_subscriptions as $sub) {
                $tool_vector['sub_' . $sub] = ($tool->subscription == $sub) ? 1 : 0;
            }
            
            // Hitung Cosine Similarity
            $similarity = $this->cosine_similarity($user_vector, $tool_vector);
            
            // Boost sedikit dari popularitas (max 5%)
            $votes = $tool->votes ?? 0;
            $popularity_boost = 1 + (log10(max($votes, 1)) / 100);
            
            $scores[$tool->tool_id] = $similarity * $popularity_boost;
        }
        
        // ========================================
        // STEP 3: Sort dan Return Top N
        // ========================================
        arsort($scores);
        $recommended_ids = array_slice(array_keys($scores), 0, $limit);
        
        // Fallback ke popular jika tidak ada rekomendasi
        if (empty($recommended_ids)) {
            $this->db->select('tool_id');
            $this->db->where_not_in('tool_id', $rated_tool_ids);
            $this->db->order_by('votes', 'DESC');
            $this->db->limit($limit);
            $result = $this->db->get('ai_tools')->result();
            return array_column($result, 'tool_id');
        }
        
        return $recommended_ids;
    }
    
    /**
     * Cosine Similarity antara 2 vectors
     * cos(θ) = (A · B) / (||A|| × ||B||)
     */
    private function cosine_similarity($vec1, $vec2)
    {
        $dot_product = 0;
        $norm1 = 0;
        $norm2 = 0;
        
        foreach ($vec1 as $key => $v1) {
            $v2 = $vec2[$key] ?? 0;
            
            $dot_product += $v1 * $v2;
            $norm1 += $v1 * $v1;
            $norm2 += $v2 * $v2;
        }
        
        if ($norm1 == 0 || $norm2 == 0) {
            return 0;
        }
        
        return $dot_product / (sqrt($norm1) * sqrt($norm2));
    }
}

