<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cliente_model extends CI_Model{

    public function cadastraCliente($dados){
        if (!empty($dados)) {
            $this->db->set($dados);
            $this->db->insert('Cliente');                
        }
    }
}