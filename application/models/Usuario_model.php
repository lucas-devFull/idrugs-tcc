<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends MY_Model{
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
         return $this->db->get("Usuario")->row_array();
      }
   }

   public function cadastraUsuario($dados){
       if (!empty($dados)) {
         $validacaoLogin = $this->validaNickUsuario($dados);
         if (is_string($validacaoLogin)) {
            echo json_encode(array("status" => false, "msg" => $validacaoLogin));
            exit;
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
            $dados['DataNascimento'] = date("Y-m-d");
            $this->cliente_model->cadastraCliente($dados);
         }else{
            unset($dados['tipo']);
            $this->vendedor_model->cadastraVendedor($dados);
         }
         return array("status" => true, "msg" => "Usuário Cadastrado com sucesso");
      }else{
         return array("status" => false);
      }
   }
}