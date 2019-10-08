<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        ob_start('ob_gzhandler');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
            header('Access-Control-Allow-Headers: token,category, Content-Type');
            header('Access-Control-Max-Age: 1728000');
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            die();
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        $this->load->model('Sms_model');

    }


    function getColors(){

        $data = json_decode(file_get_contents("php://input"), true);
        $headers = $this->Base_model->get_headers();

        $msg_list = array();
        //if (1==2) $msg_list[] = "...";

        if (count($msg_list) == 0) {

            header("HTTP/1.1 200 OK");


            $list = array();
            $query = $this->db->get('Tb_Colors');
            foreach ($query->result() as $row){
                $list[] = array(
                    'id' => $row->Fk_Color_id,
                    'title' => $row->Fd_Color_title,
                    'code' => $row->Fd_Color_code,
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


    public function uploadFile()
    {

        $headers = $this->Base_model->get_headers();
        $msg_list = array();

        //if (!$user = $this->Niroman_model->getuser($headers['token'])) $msg_list[] = "توکن معتبر نیست";

        if (!file_exists('./uploads/'.date('Ymd')).date('h').'/') {
            mkdir('./uploads/'.date('Ymd').'/'.date('h').'/', 0755, true);
        }

        $config['upload_path'] = './uploads/'.date('Ymd').'/'.date('h').'/';
        $config['allowed_types'] = 'jpg';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 100024;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) $msg_list[] = $this->upload->display_errors();

        if (count($msg_list) == 0) {

            header("HTTP/1.1 201 Insert");

            $uploadedImage = $this->upload->data();

            $this->db->insert('Tb_Files', array(
                'Fk_File_category' => ($headers['category']),
                //'Fk_File_saveUserId' => $user->user_id,
                'Fd_File_dateSave' => date('Y-m-d H:i:s'),
                'Fd_File_name' => date('Ymd').'/'.date('h').'/'.$uploadedImage['file_name'],
            ));

            $result['value']['message'] = "فایل با موفقیت آپلود شد";

            $result['value']['value']['img'] = array(
                'id' => $this->db->insert_id(),
                'file' => 'http://charmekeyhan.com/server/uploads/'.date('Ymd').'/'.date('h').'/' . $uploadedImage['file_name'],
            );

        } else {

            header("HTTP/1.1 400 Bad Request");
        }


        $result['message'] = ($msg_list) ? $msg_list : array();
        echo $this->Base_model->Json_Output_model($result);

    }


}
