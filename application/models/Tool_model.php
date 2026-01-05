<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tool_model extends CI_Model {

    public function popular($limit = 8)
    {
        $tools = $this->db->order_by('votes','DESC')
                        ->limit($limit)
                        ->get('ai_tools')
                        ->result();
        
        return $this->attach_ratings($tools);
    }

    public function all()
    {
        $tools = $this->db->get('ai_tools')->result();
        return $this->attach_ratings($tools);
    }

    public function find($id)
    {
        $tool = $this->db->where('tool_id',$id)->get('ai_tools')->row();
        if ($tool) {
            $stats = $this->get_rating_stats($id);
            $tool->avg_rating = $stats['avg'];
            $tool->rating_count = $stats['count'];
        }
        return $tool;
    }

    public function find_many($ids)
    {
        if (empty($ids)) {
            return [];
        }
        
        // Ambil data dari database
        $tools = $this->db->where_in('tool_id', $ids)->get('ai_tools')->result();
        
        // Urutkan sesuai order dari $ids (penting untuk rekomendasi)
        $ordered = [];
        $tool_map = [];
        foreach ($tools as $tool) {
            $tool_map[$tool->tool_id] = $tool;
        }
        foreach ($ids as $id) {
            if (isset($tool_map[$id])) {
                $ordered[] = $tool_map[$id];
            }
        }
        
        return $this->attach_ratings($ordered);
    }
    
    /**
     * Ambil statistik rating untuk satu tool
     */
    public function get_rating_stats($tool_id)
    {
        $result = $this->db->select('AVG(rating) as avg_rating, COUNT(*) as rating_count')
                           ->where('tool_id', $tool_id)
                           ->get('ratings')
                           ->row();
        
        return [
            'avg' => $result && $result->avg_rating ? round($result->avg_rating, 1) : 0,
            'count' => $result ? (int) $result->rating_count : 0
        ];
    }
    
    /**
     * Attach rating stats ke array of tools
     */
    private function attach_ratings($tools)
    {
        if (empty($tools)) {
            return $tools;
        }
        
        // Ambil semua tool_ids
        $tool_ids = array_column($tools, 'tool_id');
        
        // Query semua rating stats sekaligus (optimize)
        $this->db->select('tool_id, AVG(rating) as avg_rating, COUNT(*) as rating_count');
        $this->db->where_in('tool_id', $tool_ids);
        $this->db->group_by('tool_id');
        $ratings = $this->db->get('ratings')->result();
        
        // Build lookup map
        $rating_map = [];
        foreach ($ratings as $r) {
            $rating_map[$r->tool_id] = [
                'avg' => round($r->avg_rating, 1),
                'count' => (int) $r->rating_count
            ];
        }
        
        // Attach ke tools
        foreach ($tools as &$tool) {
            if (isset($rating_map[$tool->tool_id])) {
                $tool->avg_rating = $rating_map[$tool->tool_id]['avg'];
                $tool->rating_count = $rating_map[$tool->tool_id]['count'];
            } else {
                $tool->avg_rating = 0;
                $tool->rating_count = 0;
            }
        }
        
        return $tools;
    }
    
    /**
     * Search tools by name/category with filters
     */
    public function search($keyword = null, $category = null)
    {
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('company_name', $keyword);
            $this->db->or_like('category', $keyword);
            $this->db->or_like('clean_text', $keyword);
            $this->db->group_end();
        }
        
        if ($category) {
            $this->db->where('category', $category);
        }
        
        $this->db->order_by('votes', 'DESC');
        $tools = $this->db->get('ai_tools')->result();
        
        return $this->attach_ratings($tools);
    }
    
    /**
     * Get all unique categories
     */
    public function get_categories()
    {
        $this->db->distinct();
        $this->db->select('category');
        $this->db->where('category IS NOT NULL');
        $this->db->where('category !=', '');
        $this->db->order_by('category', 'ASC');
        $result = $this->db->get('ai_tools')->result();
        
        return array_column($result, 'category');
    }
}
