<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');  

class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library("Authorization_Token");
        $validacao = $this->authorization_token->validateToken();

        if($validacao['status'] == false){
            echo json_encode($validacao);
            exit;
        }
    }

    function getContent($parametro = false) {
        $contents = null;
        switch (strtolower($_SERVER['REQUEST_METHOD'])) {
            case 'delete':
            case 'get':
                $contents = $_GET;  
                break;
    
            case 'post':
            case 'patch':
            case 'put':
                $contents = $_POST;
                if (!is_array($contents) || count($contents) <= 0) {
                    parse_str(file_get_contents("php://input"), $contents);
                }
                break;
        }
    
        if ($contents && is_array($contents) && count($contents) > 0) {
    
            if ($parametro && strlen($parametro) > 0) {
                if (isset($contents[$parametro])) {
                    return $contents[$parametro];
                } else {
                    return false;
                }
            }
            return $contents;
        }
        return false;
    }
}