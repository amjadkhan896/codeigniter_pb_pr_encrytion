<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pincode_model extends CI_Model {

    protected $table = 'pincodes';


    public function get_count() {
        return $this->db->count_all($this->table);
    }

    public function get_pincodes($limit, $start) {
        $this->db->limit($limit, $start);
        if($this->input->get('search_input')!=''){
            $this->db->where('serial_no',$this->input->get('search_input'));

        }
        $query = $this->db->get($this->table);
       // echo $this->db->last_query();exit;

        return $query->result();
    }



}