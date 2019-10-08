<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ws extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        ob_start('ob_gzhandler');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
            header('Access-Control-Allow-Headers: token, Content-Type');
            header('Access-Control-Max-Age: 1728000');
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            die();
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        $this->load->model('Sms_model');

    }


    function productlist(){

        $data = json_decode(file_get_contents("php://input"), true);
        $headers = $this->Base_model->get_headers();

        $msg_list = array();

        if (count($msg_list) == 0) {

            header("HTTP/1.1 200 OK");

            $this->db->where('Fd_Prodt_status',1);
            $query = $this->db->get('Tb_Products');
            $list = array();
            foreach ($query->result() as $row){
                $list[] = array(
                    'id' => $row->Fk_Prodt_id,
                    'title' => $row->Fd_Prodt_title,
                    'product' => json_decode($row->Fd_Prodt_product),
                    'images' => json_decode($row->Fd_Prodt_images),
                );
            }

            $result['value']['list'] = $list;

        } else {

            header("HTTP/1.1 400 Bad Request");
        }

        $result['authorization'] = false;
        $result['message'] = ($msg_list) ? $msg_list : array();
        echo $this->Base_model->Json_Output_model($result);

    }


}
