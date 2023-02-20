<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login') != TRUE)
		{
			set_pesan('Silahkan login terlebih dahulu', false);
			redirect('');
		}
		$params = array('server_key' => 'SB-Mid-server-21COfhBodvWvqHj_WLrLm656', 'production' => false);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
	}

    public function index()
    {
    	$json_result = file_get_contents('php://input');
    	$result = json_decode($json_result, "true");
    	$order_id = $result->order_id;
    	if($result->status_code == "200"){
    		$status = 'Transaksi berhasil';
    	}
    	$date = $result->transaction_time;

    	$data_tarif	= [
			'order_id'		=> $order_id,
			'tgl_bayar'		=> $date,
			'status'		=> 'Transaksi berhasil',
		];
		$this->db->where('order_id', $order_id);
		$this->db->update($this->table, $data_tarif);

    }

}
