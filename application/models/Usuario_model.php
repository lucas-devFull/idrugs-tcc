<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model{
   public function getUsers($dados){
      if ($dados) {
         $this->db->select("*");
         $this->db->where("Login", $dados['login']);
         $this->db->where("Senha", md5($dados['senha']));
         if ($dados['tipo'] == "2") {
            $this->db->join("Cliente", "Cliente.UsuarioId = Usuario.Id", "left");
         }else{
            $this->db->join("Vendedor", "Vendedor.UsuarioId = Usuario.Id", "left");
         }
         return $this->db->get("Usuario")->result_array();
      }
   }

   public function cadastraUsuario($dados){
       if (!empty($dados)) {
          if (!empty($this->validaNickUsuario($dados))) {
             return "ja existe um login com esse nome " . $dados['login'];
          }

         $this->db->set("Login", $dados['login']);
         $this->db->set("Senha", md5($dados['senha']));
         $this->db->set("Tipo", $dados['tipo']);
         $this->db->insert('Usuario');
         $id_usuario = $this->db->insert_id();
         unset($dados['login']);
         unset($dados['senha']);

         $dados = array_merge($dados, array("UsuarioId" => $id_usuario));
         if ($dados['tipo'] == "2") {
            unset($dados['tipo']);
            $this->cliente_model->cadastraCliente($dados);
         }else{
            unset($dados['tipo']);
            $this->vendedor_model->cadastraVendedor($dados);
         }
         return true;
      }else{
         return false;
      }
   }

   public function validaNickUsuario($string){
      $this->db->like("Login", $string['login'], "both");
      return $this->db->get("Usuario")->result_array();
   }
}