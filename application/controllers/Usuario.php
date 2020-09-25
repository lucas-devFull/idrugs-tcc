<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
	}
	
    public function index()
    {
        switch ($this->input->method()) {
            case 'get':
                echo json_encode($this->usuario_model->getUsers($this->getContent()));
            break;
            case 'post':
                $this->load->model("cliente_model");
                $this->load->model("vendedor_model");
                echo json_encode($this->usuario_model->cadastraUsuario($this->getContent()));
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
