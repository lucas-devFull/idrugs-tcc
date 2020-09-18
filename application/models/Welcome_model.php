<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome_model extends CI_Model{
   public function teste()
   {
       return $this->db->select("*")->get("feed_post")->result_array();
      //  return "teste end point";
   }
}