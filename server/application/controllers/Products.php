<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
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


    function set(){

        $data = json_decode(file_get_contents("php://input"), true);
        $headers = $this->Base_model->get_headers();

        $msg_list = array();
        //if (1==2) $msg_list[] = "...";

        if (count($msg_list) == 0) {

            header("HTTP/1.1 200 OK");


            $productList = array();
            foreach ($data['product'] as $v){

                if(strlen($v['code'])>=1) {
                    $productList[] = array(
                        'code' => $v['code'],
                        'clubPrices' => $v['clubPrices'],
                        'discountedPrices' => $v['discountedPrices'],
                        'price' => $v['price'],
                        'color' => $v['color'],
                    );
                }
            }


            $imagesList = array();
            foreach ($data['images'] as $v){

                if(strlen($v['id'])>=1) {
                    $imagesList[] = array(
                        'id' => $v['id'],
                        'img' => $v['img'],
                        'showFirst' => $v['showFirst'],
                    );
                }
            }

            $dbData = array(
                'Fd_Prodt_title' => trim($data['title']),
                'Fd_Prodt_description' => trim($data['description']),
                'Fd_Prodt_status' => trim($data['state']),
                'Fd_Prodt_stateClub' => trim($data['stateClub']),
                'Fd_Prodt_product' => json_encode($productList),
                'Fd_Prodt_images' => json_encode($imagesList),
                'Fd_Prodt_dateSave' => date('Y-m-d H:i:s'),
            );

            if($data['rowId']){

                $this->db->where('Fk_Prodt_id',$data['rowId']);
                $this->db->update('Tb_Products',$dbData);
                $insert_id = $data['rowId'];

            }else{

                $dbData['Fd_Prodt_dateSave'] = date('Y-m-d H:i:s');
                $this->db->insert('Tb_Products',$dbData);
                $insert_id = $this->db->insert_id();
            }

            $result['value']['insert_id'] = $insert_id;


        } else {

            header("HTTP/1.1 400 Bad Request");
        }

        $result['authorization'] = false;
        $result['message'] = ($msg_list) ? $msg_list : array();
        echo $this->Base_model->Json_Output_model($result);

    }

    public function remove()
    {

        $data = json_decode(file_get_contents("php://input"), true);
        $headers = $this->Base_model->get_headers();
        $msg_list = array();

        if (count($msg_list) == 0) {

            header("HTTP/1.1 200 Ok");

            $this->db->where('Fk_Prodt_id',$data['id']);
            $this->db->delete('Tb_Products');

            $result['value']['status'] = true;

        } else {
            header("HTTP/1.1 400 Bad Request");
        }


        $result['message'] = ($msg_list) ? $msg_list : array();
        echo $this->Base_model->Json_Output_model($result);

    }

    public function getone()
    {

        $data = json_decode(file_get_contents("php://input"), true);
        $headers = $this->Base_model->get_headers();
        $msg_list = array();

        if (count($msg_list) == 0) {

            header("HTTP/1.1 200 Ok");


            $this->db->where('Fk_Prodt_id',$data['id']);
            $query = $this->db->get('Tb_Products');
            $row = $query->row();

            $result['value']['row'] = array(
                'rowId' => $row->Fk_Prodt_id,
                'title' => $row->Fd_Prodt_title,
                'description' => $row->Fd_Prodt_description,
                'state' => ($row->Fd_Prodt_status)?true:false,
                'stateClub' => ($row->Fd_Prodt_stateClub)?true:false,
                'product' => json_decode($row->Fd_Prodt_product),
                'images' => json_decode($row->Fd_Prodt_images),

            );

        } else {
            header("HTTP/1.1 400 Bad Request");
        }


        $result['message'] = ($msg_list) ? $msg_list : array();
        echo $this->Base_model->Json_Output_model($result);

    }

    public function getlist()
    {

        $data = json_decode(file_get_contents("php://input"), true);
        $headers = $this->Base_model->get_headers();
        $msg_list = array();

        if (count($msg_list) == 0) {

            header("HTTP/1.1 200 Ok");


            $this->db->select('Fk_Prodt_id');
            $queryBase = $this->db->get('Tb_Products');

            $data['page'] = ($data['page']-1);
            $page = (intval($data['page']) * $data['pageSize']);


            $this->db->select('*');
            $this->db->limit($data['pageSize'],$page);
            $this->db->order_by('Fk_Prodt_id', 'desc');
            $query = $this->db->get('Tb_Products');
            $list = array();
            foreach ($query->result() as $row) {

                $list[] = array(
                    'rowId' => $row->Fk_Prodt_id,
                    'title' => $row->Fd_Prodt_title,
                    'state' => ($row->Fd_Prodt_status)?"فعال":"غیرفعال",
                    'stateClub' => ($row->Fd_Prodt_stateClub)?"فعال":"غیرفعال",
                    'productTotal' => count(json_decode($row->Fd_Prodt_product)),
                    'imagesTotal' => count(json_decode($row->Fd_Prodt_images)),
                );
            }

            $result['value']['num_rows'] = $queryBase->num_rows();
            $result['value']['list'] = $list;

        } else {
            header("HTTP/1.1 400 Bad Request");
        }


        $result['message'] = ($msg_list) ? $msg_list : array();
        echo $this->Base_model->Json_Output_model($result);

    }



}
