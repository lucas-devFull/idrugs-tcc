<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->library("Authorization_Token");
	}
	
    public function index()
    {
        switch ($this->input->method()) {
            case 'get':
                $data = [
                    'login' => $_GET['login'],
                    'time' => time(),
                ];
                $resultado = $this->usuario_model->getUsers($_GET);
                if($resultado != false || !empty($resultado)){
                    $data['id'] = $resultado["Id"];
                    $data['nome'] = $resultado["Nome"];
                    $token = $this->authorization_token->generateToken($data);
                    $data['tipo'] = $resultado["Tipo"];
                    $data['token'] = $token;
                    echo json_encode(array('status' => true, 'dados' => $data));
                }else{
                    echo json_encode(array('status' => false));
                }
            break;
            case 'post':
                $this->load->model("cliente_model");
                $this->load->model("vendedor_model");
                echo json_encode($this->usuario_model->cadastraUsuario($_POST));
            break;
        }
    }

    public function validaLoginUsuario(){
        $string = $this->getContent();
        if (!empty($this->usuario_model->validaNickUsuario($string))) {
            echo json_encode(array("status" => true));
        }else{
            echo json_encode(array("status" => false));
        }
    }
}
