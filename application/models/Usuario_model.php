<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model{
   public function getUsers($dados)
   {
      if ($dados) {
         return $this->db->select("*")
            ->where("Login", $dados['login'])
            ->where("Senha", $dados['senha'])
            ->get("Usuario")->result_array();
      }
   }
}