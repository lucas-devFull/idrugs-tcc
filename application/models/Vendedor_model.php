<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendedor_model extends CI_Model{
    public function cadastraVendedor($dados){
        if (!empty($dados)) {
            $this->db->set($dados);
            $this->db->insert('Vendedor');                
        }
    }

    public function editaVendedor($dados){
        
    }
}