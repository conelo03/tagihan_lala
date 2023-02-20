<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-21COfhBodvWvqHj_WLrLm656', 'production' => false);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
		
    }

	public function index()
	{
		echo 'test notification handler';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);
		var_dump($result);

		if($result){
		$notif = $this->veritrans->status($result->order_id);
		}

		error_log(print_r($result,TRUE));
		
		$data_tarif	= [
			'order_id'		=> $result->order_id,
			'tgl_bayar'		=> $result->transaction_time,
			'status'		=> 'Transaksi berhasil',
		];
		$this->db->where('order_id', $result->order_id);
		$this->db->update('tb_tagihan', $data_tarif);

		$tagihan = $this->db->get_where('tb_tagihan', ['order_id' => $result->order_id])->row_array();
		$pelanggan = $this->db->get_where('tb_pelanggan', ['id_pelanggan' => $tagihan['id_pelanggan']])->row_array();
		$bulan = date('F', strtotime($tagihan['tgl_tagihan']));

// 		$config = [
//             'mailtype'  => 'html',
//             'charset'   => 'utf-8',
//             'protocol'  => 'smtp',
//             'smtp_host' => 'jargas.xyz',
//             'smtp_user' => 'admin@jargas.xyz',  // Email gmail
//             'smtp_pass'   => 'conelo031999',  // Password gmail
//             'smtp_crypto' => 'ssl',
//             'smtp_port'   => 465,
//             'crlf'    => "\r\n",
//             'newline' => "\r\n"
//         ];

//         // Load library email dan konfigurasinya
//         $this->load->library('email', $config);
        $config = array('protocol' => 'mail',
                    'wordwrap' => FALSE,
                    'mailtype' => 'html',
                    'charset'   => 'utf-8',
                    'crlf'      => "\r\n",
                    'newline'   => "\r\n",
                    'send_multipart' => FALSE
                    );
        $this->load->library('email', $config);
        $CompanyName = "Admin Jargas";
        $setmail = "admin@jargas.xyz";
        
        $this->email->from( $setmail, $CompanyName );

        // Email dan nama pengirim


        // Email penerima
        $this->email->to($pelanggan['email']); // Ganti dengan email tujuan

        // Subject email
        $this->email->subject('Notifikasi Pembayaran Tagihan');

        // Isi email
        $this->email->message("Pembayaran Tagihan pada bulan ".$bulan." sebesar Rp".$tagihan['tagihan']." telah berhasil");
		if($this->email->send()){
			echo "sukses";
			var_dump($this->email->print_debugger());
		} else {
			var_dump($this->email->print_debugger());
		}

		//$this->update_status($result->order_id, $result->transaction_time);

		//notification handler sample

		/*
		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'capture') {
		  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
		  if ($type == 'credit_card'){
		    if($fraud == 'challenge'){
		      // TODO set payment status in merchant's database to 'Challenge by FDS'
		      // TODO merchant should decide whether this transaction is authorized or not in MAP
		      echo "Transaction order_id: " . $order_id ." is challenged by FDS";
		      } 
		      else {
		      // TODO set payment status in merchant's database to 'Success'
		      echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
		      }
		    }
		  }
		else if ($transaction == 'settlement'){
		  // TODO set payment status in merchant's database to 'Settlement'
		  echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		  } 
		  else if($transaction == 'pending'){
		  // TODO set payment status in merchant's database to 'Pending'
		  echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		  } 
		  else if ($transaction == 'deny') {
		  // TODO set payment status in merchant's database to 'Denied'
		  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}*/

	}

	public function update_status($order_id, $date)
    {
    	$data_tarif	= [
			'order_id'		=> $order_id,
			'tgl_bayar'		=> $date,
			'status'		=> 'Transaksi berhasil',
		];
		$this->db->where('order_id', $order_id);
		$this->db->update('tb_tagihan', $data_tarif);

    }
}