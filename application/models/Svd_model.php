<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SVD Model-Based Collaborative Filtering
 * ========================================
 * 
 * Implementasi algoritma SVD (Singular Value Decomposition) untuk
 * sistem rekomendasi berbasis Model-Based Collaborative Filtering.
 * 
 * Algoritma ini bekerja dengan cara:
 * 1. Membuat user-item rating matrix
 * 2. Melakukan matrix factorization dengan gradient descent
 * 3. Memprediksi rating untuk item yang belum di-rating
 * 4. Merekomendasikan item dengan predicted rating tertinggi
 */
class Svd_model extends CI_Model {

    // Hyperparameters
    private $n_factors = 20;      // Jumlah latent factors
    private $n_epochs = 50;       // Jumlah iterasi training
    private $lr = 0.005;          // Learning rate
    private $reg = 0.02;          // Regularization
    
    // Model parameters (akan di-train)
    private $user_factors = [];   // Matrix U (users x factors)
    private $item_factors = [];   // Matrix V (items x factors)
    private $user_bias = [];      // Bias per user
    private $item_bias = [];      // Bias per item
    private $global_mean = 0;     // Rata-rata global rating
    
    // Data
    private $ratings = [];
    private $user_ids = [];
    private $item_ids = [];
    private $user_map = [];       // user_id -> index
    private $item_map = [];       // item_id -> index

    /**
     * Load ratings dari database dan train model
     */
    public function train()
    {
        // Ambil semua ratings dari database
        $this->ratings = $this->db->get('ratings')->result_array();
        
        if (empty($this->ratings)) {
            return ['success' => false, 'error' => 'No ratings data'];
        }
        
        // Build user dan item mappings
        $this->build_mappings();
        
        // Hitung global mean
        $total = 0;
        foreach ($this->ratings as $r) {
            $total += $r['rating'];
        }
        $this->global_mean = $total / count($this->ratings);
        
        // Initialize factors dengan random values
        $this->initialize_factors();
        
        // Train dengan Stochastic Gradient Descent
        $this->train_sgd();
        
        // Simpan model ke cache
        $this->save_model();
        
        return [
            'success' => true,
            'n_users' => count($this->user_ids),
            'n_items' => count($this->item_ids),
            'n_ratings' => count($this->ratings),
            'n_factors' => $this->n_factors,
            'n_epochs' => $this->n_epochs
        ];
    }

    /**
     * Build mapping dari user_id/item_id ke index
     */
    private function build_mappings()
    {
        $users = [];
        $items = [];
        
        foreach ($this->ratings as $r) {
            $users[$r['user_id']] = true;
            $items[$r['tool_id']] = true;
        }
        
        $this->user_ids = array_keys($users);
        $this->item_ids = array_keys($items);
        
        foreach ($this->user_ids as $idx => $uid) {
            $this->user_map[$uid] = $idx;
        }
        foreach ($this->item_ids as $idx => $iid) {
            $this->item_map[$iid] = $idx;
        }
    }

    /**
     * Initialize factors dengan random kecil
     */
    private function initialize_factors()
    {
        $n_users = count($this->user_ids);
        $n_items = count($this->item_ids);
        
        // Initialize user factors
        for ($u = 0; $u < $n_users; $u++) {
            $this->user_factors[$u] = [];
            for ($f = 0; $f < $this->n_factors; $f++) {
                $this->user_factors[$u][$f] = (mt_rand() / mt_getrandmax() - 0.5) * 0.1;
            }
            $this->user_bias[$u] = 0;
        }
        
        // Initialize item factors
        for ($i = 0; $i < $n_items; $i++) {
            $this->item_factors[$i] = [];
            for ($f = 0; $f < $this->n_factors; $f++) {
                $this->item_factors[$i][$f] = (mt_rand() / mt_getrandmax() - 0.5) * 0.1;
            }
            $this->item_bias[$i] = 0;
        }
    }

    /**
     * Training dengan Stochastic Gradient Descent
     * 
     * Formula prediksi:
     * r_ui = μ + b_u + b_i + q_i · p_u
     * 
     * Update rules:
     * b_u = b_u + lr * (e_ui - reg * b_u)
     * b_i = b_i + lr * (e_ui - reg * b_i)
     * p_u = p_u + lr * (e_ui * q_i - reg * p_u)
     * q_i = q_i + lr * (e_ui * p_u - reg * q_i)
     */
    private function train_sgd()
    {
        for ($epoch = 0; $epoch < $this->n_epochs; $epoch++) {
            // Shuffle ratings untuk setiap epoch
            shuffle($this->ratings);
            
            foreach ($this->ratings as $r) {
                $u = $this->user_map[$r['user_id']];
                $i = $this->item_map[$r['tool_id']];
                $rating = (float) $r['rating'];
                
                // Prediksi rating
                $pred = $this->predict_single($u, $i);
                
                // Error
                $error = $rating - $pred;
                
                // Update biases
                $this->user_bias[$u] += $this->lr * ($error - $this->reg * $this->user_bias[$u]);
                $this->item_bias[$i] += $this->lr * ($error - $this->reg * $this->item_bias[$i]);
                
                // Update factors
                for ($f = 0; $f < $this->n_factors; $f++) {
                    $pu = $this->user_factors[$u][$f];
                    $qi = $this->item_factors[$i][$f];
                    
                    $this->user_factors[$u][$f] += $this->lr * ($error * $qi - $this->reg * $pu);
                    $this->item_factors[$i][$f] += $this->lr * ($error * $pu - $this->reg * $qi);
                }
            }
        }
    }

    /**
     * Prediksi rating untuk user u dan item i (menggunakan index)
     */
    private function predict_single($u, $i)
    {
        $pred = $this->global_mean + $this->user_bias[$u] + $this->item_bias[$i];
        
        // Dot product of user and item factors
        for ($f = 0; $f < $this->n_factors; $f++) {
            $pred += $this->user_factors[$u][$f] * $this->item_factors[$i][$f];
        }
        
        // Clamp ke range 1-5
        return max(1, min(5, $pred));
    }

    /**
     * Prediksi rating untuk user_id dan tool_id tertentu
     */
    public function predict($user_id, $tool_id)
    {
        if (!$this->load_model()) {
            return null;
        }
        
        // Cek apakah user dan item ada di training data
        if (!isset($this->user_map[$user_id]) || !isset($this->item_map[$tool_id])) {
            return null;
        }
        
        $u = $this->user_map[$user_id];
        $i = $this->item_map[$tool_id];
        
        return round($this->predict_single($u, $i), 2);
    }

    /**
     * Generate rekomendasi untuk user
     */
    public function get_recommendations($user_id, $limit = 8)
    {
        // Load model
        if (!$this->load_model()) {
            // Model belum di-train, train dulu
            $this->train();
        }
        
        // Cek apakah user ada di training data
        if (!isset($this->user_map[$user_id])) {
            // User baru, return empty (akan fallback ke popular)
            return [
                'tool_ids' => [],
                'predictions' => [],
                'algorithm' => 'SVD Model-Based (New User - No Data)',
                'success' => false
            ];
        }
        
        $u = $this->user_map[$user_id];
        
        // Ambil tools yang sudah di-rating user
        $rated = $this->db->where('user_id', $user_id)
                          ->get('ratings')
                          ->result_array();
        $rated_items = array_column($rated, 'tool_id');
        
        // Ambil semua tools
        $all_tools = $this->db->select('tool_id')
                              ->get('ai_tools')
                              ->result_array();
        
        // Prediksi rating untuk semua tools yang belum di-rating
        $predictions = [];
        foreach ($all_tools as $tool) {
            $tool_id = $tool['tool_id'];
            
            // Skip jika sudah di-rating
            if (in_array($tool_id, $rated_items)) continue;
            
            // Skip jika tool tidak ada di training data
            if (!isset($this->item_map[$tool_id])) continue;
            
            $i = $this->item_map[$tool_id];
            $pred_rating = $this->predict_single($u, $i);
            
            $predictions[] = [
                'tool_id' => $tool_id,
                'predicted_rating' => round($pred_rating, 2)
            ];
        }
        
        // Sort by predicted rating (descending)
        usort($predictions, function($a, $b) {
            return $b['predicted_rating'] <=> $a['predicted_rating'];
        });
        
        // Ambil top N
        $top_n = array_slice($predictions, 0, $limit);
        
        // Format output
        $tool_ids = array_column($top_n, 'tool_id');
        $pred_map = [];
        foreach ($top_n as $p) {
            $pred_map[$p['tool_id']] = $p['predicted_rating'];
        }
        
        return [
            'tool_ids' => $tool_ids,
            'predictions' => $pred_map,
            'algorithm' => 'SVD Model-Based Collaborative Filtering',
            'success' => true
        ];
    }

    /**
     * Simpan model ke file cache
     */
    private function save_model()
    {
        $model_data = [
            'user_factors' => $this->user_factors,
            'item_factors' => $this->item_factors,
            'user_bias' => $this->user_bias,
            'item_bias' => $this->item_bias,
            'global_mean' => $this->global_mean,
            'user_map' => $this->user_map,
            'item_map' => $this->item_map,
            'n_factors' => $this->n_factors,
            'trained_at' => date('Y-m-d H:i:s')
        ];
        
        $cache_path = APPPATH . 'cache/svd_model.json';
        file_put_contents($cache_path, json_encode($model_data));
        
        return true;
    }

    /**
     * Load model dari file cache
     */
    private function load_model()
    {
        $cache_path = APPPATH . 'cache/svd_model.json';
        
        if (!file_exists($cache_path)) {
            return false;
        }
        
        $model_data = json_decode(file_get_contents($cache_path), true);
        
        if (!$model_data) {
            return false;
        }
        
        $this->user_factors = $model_data['user_factors'];
        $this->item_factors = $model_data['item_factors'];
        $this->user_bias = $model_data['user_bias'];
        $this->item_bias = $model_data['item_bias'];
        $this->global_mean = $model_data['global_mean'];
        $this->user_map = $model_data['user_map'];
        $this->item_map = $model_data['item_map'];
        $this->n_factors = $model_data['n_factors'];
        
        return true;
    }

    /**
     * Get model info
     */
    public function get_model_info()
    {
        $cache_path = APPPATH . 'cache/svd_model.json';
        
        if (!file_exists($cache_path)) {
            return ['trained' => false];
        }
        
        $model_data = json_decode(file_get_contents($cache_path), true);
        
        return [
            'trained' => true,
            'n_users' => count($model_data['user_map']),
            'n_items' => count($model_data['item_map']),
            'n_factors' => $model_data['n_factors'],
            'trained_at' => $model_data['trained_at']
        ];
    }

    /**
     * Hapus model cache (untuk retrain)
     */
    public function clear_model()
    {
        $cache_path = APPPATH . 'cache/svd_model.json';
        if (file_exists($cache_path)) {
            unlink($cache_path);
        }
        return true;
    }
}
