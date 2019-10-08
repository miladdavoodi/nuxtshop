<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	function mc(){

	    $queryAd = $this->db->get('Tb_Advertising');
        foreach ($queryAd->result() as $RwAd){
            $Ad[$RwAd->Fk_Adver_id] = $RwAd->Fd_Adver_title;
        }

	    $query = $this->db->get('Tb_AdvertisingLog');
	    $list = array();
	    foreach ($query->result() as $row){
	        $list[jdate('Y/m/d',strtotime($row->Fk_AdverLog_DateplayTime))][$Ad[$row->Fk_AdverLog_advId]] += 1;
        }

	    unset($list['-0001-11-30']);
	    unset($list['-621/0-37/0-26']);

	    print_r($list);

    }

}
