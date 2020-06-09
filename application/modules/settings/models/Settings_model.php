<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    private $settings_table;

	public function __construct()
	{
		$this->settings_table = 'settings';
    }
    
    public function get_settings(){
        $this->db->select('*');
        $this->db->from($this->settings_table);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function update($data = array()){
        return $this->db->update_batch($this->settings_table, $data, 'key_name');
    }
    
}
