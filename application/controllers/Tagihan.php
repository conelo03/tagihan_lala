<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: * ');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Tagihan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login') != TRUE)
		{
			set_pesan('Silahkan login terlebih dahulu', false);
			redirect('');
		}
		$params = array('server_key' => 'SB-Mid-server-21COfhBodvWvqHj_WLrLm656', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
		date_default_timezone_set("Asia/Jakarta");
		$this->load->library('upload');
	}

	public function index()
	{
        $data['title']		= 'Data Tagihan';
        if(is_admin()){
			$data['tagihan']	= $this->M_tagihan->get_data('BL')->result_array();
			$this->load->view('tagihan/data_all', $data);
        } elseif(is_teknisi()){
			$data['tagihan']	= $this->M_tagihan->get_data('BL')->result_array();
			$this->load->view('tagihan/data_all', $data);
        } else{
        	$id_pelanggan = $this->session->userdata('id_pelanggan');
			$data['tagihan']	= $this->M_tagihan->get_data_by_pelanggan($id_pelanggan, 'BL')->result_array();
			$this->load->view('tagihan/data', $data);
        }
        
	}

	public function riwayat()
	{
        $data['title']		= 'Riwayat Tagihan';
        if(is_admin()){
			$data['tagihan']	= $this->M_tagihan->get_data('Transaksi berhasil')->result_array();
			$this->load->view('tagihan/riwayat_all', $data);
        } elseif(is_teknisi()){
			$data['tagihan']	= $this->M_tagihan->get_data('Transaksi berhasil')->result_array();
			$this->load->view('tagihan/riwayat_all', $data);
        } else{
        	$id_pelanggan = $this->session->userdata('id_pelanggan');
			$data['tagihan']	= $this->M_tagihan->get_data_by_pelanggan($id_pelanggan, 'Transaksi berhasil')->result_array();
			$this->load->view('tagihan/riwayat', $data);
        }
		
	}

	public function laporan($tgl_tagihan = null)
	{
        $this->validation_laporan();
		if (!$this->form_validation->run()) {
			$data['title']		= 'Laporan Tagihan';
			$data['bulan'] = $this->db->select('*')->from('tb_tagihan')->group_by('DATE_FORMAT("tgl_tagihan", "%Y-%m")')->get()->result_array();
			$tagihan = $this->db->select_sum('tagihan')->select('tgl_tagihan')->from('tb_tagihan')->group_by('DATE_FORMAT("tgl_tagihan", "%Y-%m")')->like('tgl_tagihan', date('Y'), 'both')->get()->result_array();
			$arr_jml_tagihan = [];
			$arr_bulan = [];
			foreach ($tagihan as $key) {
				array_push($arr_jml_tagihan, $key['tagihan']);
				array_push($arr_bulan, date('F Y', strtotime($key['tgl_tagihan'])));	
			}
			$data['arr_bulan'] = json_encode($arr_bulan);
			$data['arr_jml_tagihan'] = json_encode($arr_jml_tagihan);
			$data['tagihan']	= $this->M_tagihan->get_data()->result_array();
			$this->load->view('tagihan/laporan', $data);
		} else {
			$data['title']		= 'Laporan Tagihan';
			$bulan = $this->input->post('tgl_tagihan');
			$data['tagihan'] = $this->db->select('*, tb_tagihan.status as status')->from('tb_tagihan')->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan=tb_tagihan.id_pelanggan')->like('tgl_tagihan', $bulan, 'both')->get()->result_array();
			
			$this->load->view('tagihan/cetak_laporan', $data);
		}
	}

	public function tambah()
	{
		$this->validation();
		if (!$this->form_validation->run()) {
			$data['title']		= 'Tambah Tagihan';
			$data['pelanggan']  = $this->M_pelanggan->get_data()->result_array();
			$this->load->view('tagihan/tambah', $data);
		} else {
			$data		= $this->input->post(null, true);
			$pch_pel = explode(' - ', $data['id_pel']);
			$get_pelanggan = $this->db->get_where('tb_pelanggan', ['id_pelanggan' => $pch_pel[0]])->row_array();
			$id_pelanggan = $get_pelanggan['id_pelanggan'];
			$get_tarif = $this->db->get_where('tb_tarif', ['status' => 1])->row_array();
			$no_meter = $data['no_meter'];
			$get_last_meter = $this->db->select('*')->from('tb_tagihan')->where('id_pelanggan', $id_pelanggan)->order_by('id_tagihan', 'DESC')->get()->row_array();
			$meter = $no_meter-$get_last_meter['no_meter'];
			$meter_bulan_kemarin = $get_last_meter['jml_meter_bulan_ini'];
			$tarif = $get_tarif['tarif'];
			$tagihan = $tarif * $meter;
			$bulan = date('F', strtotime(data['tgl_tagihan']));

			$bukti_meter = $this->upload_bukti();
			
			$data_tarif	= [
				'tgl_tagihan'		=> $data['tgl_tagihan'],
				'id_pelanggan'		=> $id_pelanggan,
				'no_meter'		=> $data['no_meter'],
				'jml_meter_bulan_kemarin'		=> $meter_bulan_kemarin,
				'jml_meter_bulan_ini'		=> $meter,
				'tagihan'		=> $tagihan,
				'status'		=> 'BL',
				'bukti_meter'	=> $bukti_meter,
				'teknisi'		=> $this->session->userdata('nama_pengguna')
			];
			if ($this->M_tagihan->insert($data_tarif)) {
				die();
				$this->session->set_flashdata('msg', 'error');
				redirect('tambah-tagihan');
			} else {
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
                $this->email->to($get_pelanggan['email']); // Ganti dengan email tujuan
        
                // Subject email
                $this->email->subject('Notifikasi Pembayaran Tagihan');
        
                // Isi email
                $this->email->message("Pelanggan Yth. Diharapkan untuk membayar tagihan pada bulan ".$bulan." sebesar Rp".$tagihan." Terima Kasih");
        		$this->email->send();
				$this->session->set_flashdata('msg', 'success');
				redirect('tagihan');
			}
		}
	}

	private function upload_bukti()
	{
	    $config['upload_path'] = './assets/upload_bukti_meter';
	    $config['allowed_types'] = 'jpg|png|jpeg|docx|pptx|pdf|xlsx|xls';
	    $config['max_size'] = 100100;
	    $this->upload->initialize($config);
	    $this->load->library('upload', $config);

	    if(! $this->upload->do_upload('bukti_meter'))
	    {
	    	//$error = array('error' => $this->upload->display_errors());
	    	return '';
	    }

	    return $this->upload->data('file_name');
	}

	public function token()
    {
    	$id_tagihan = $this->input->post('id_tagihan');
    	$tagihan = $this->M_tagihan->get_by_id($id_tagihan);
    	$tarif = $this->M_tarif->get_by_status('1');
    	$pelanggan = $this->M_pelanggan->get_by_id($tagihan['id_pelanggan']);
    	$tanggal = new DateTime(date('Y-m-d'));
    	$tanggal_tagihan = new DateTime(date('Y-m-d', strtotime($tagihan['tgl_tagihan'])));
    	$bulan = date('F', strtotime($tagihan['tgl_tagihan']));
		$diff  = $tanggal->diff($tanggal_tagihan);
		$hari = $diff->d;
		//var_dump($hari);
		
		if($hari > 5){
		    $transaction_details = array(
    		  'order_id' => rand(),
    		  'gross_amount' => $tagihan['tagihan']+5000, // no decimal allowed for creditcard
    		);
    
    		// Optional
    		$item1_details = array(
    		  'id' => 'a1',
    		  'price' => $tagihan['jml_meter_bulan_ini'],
    		  'quantity' => $tarif['tarif'],
    		  'name' => 'Pemakaian bulan '.$bulan
    		);
    		
    		$item2_details = array(
    		  'id' => 'a2',
    		  'price' => 5000,
    		  'quantity' => 1,
    		  'name' => 'Denda bulan '.$bulan
    		);
    		
			$item_details = array ($item1_details, $item2_details);
		} else {
		    $transaction_details = array(
    		  'order_id' => rand(),
    		  'gross_amount' => $tagihan['tagihan'], // no decimal allowed for creditcard
    		);
    
    		// Optional
    		$item1_details = array(
    		  'id' => 'a1',
    		  'price' => $tagihan['jml_meter_bulan_ini'],
    		  'quantity' => $tarif['tarif'],
    		  'name' => 'Pemakaian bulan '.$bulan
    		);
    		
		    $item_details = array ($item1_details);
		}


		// Optional
		// $billing_address = array(
		//   'first_name'    => "Andri",
		//   'last_name'     => "Litani",
		//   'address'       => "Mangga 20",
		//   'city'          => "Jakarta",
		//   'postal_code'   => "16602",
		//   'phone'         => "081122334455",
		//   'country_code'  => 'IDN'
		// );

		// // Optional
		// $shipping_address = array(
		//   'first_name'    => "Obet",
		//   'last_name'     => "Supriadi",
		//   'address'       => "Manggis 90",
		//   'city'          => "Jakarta",
		//   'postal_code'   => "16601",
		//   'phone'         => "08113366345",
		//   'country_code'  => 'IDN'
		// );

		// Optional
		$customer_details = array(
		  'first_name'    => $pelanggan['id_pelanggan'].' - '.$pelanggan['nama'],
		  'last_name'     => " ",
		  'email'         => $pelanggan['username'].'@gmail.com',
		  'phone'         => $pelanggan['no_hp'],
		  'billing_address'  => 'none',
		  'shipping_address' => 'none'
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 1440
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish()
    {
    	$id_tagihan = $this->input->post('id_tagihan');
    	$result = json_decode($this->input->post('result_data'));
    	$tagihan = $this->M_tagihan->get_by_id($id_tagihan);
    	$tanggal = new DateTime(date('Y-m-d'));
    	$tanggal_tagihan = new DateTime(date('Y-m-d', strtotime($tagihan['tgl_tagihan'])));
    	$bulan = date('F', strtotime($tagihan['tgl_tagihan']));
		$diff  = $tanggal->diff($tanggal_tagihan);
		$hari = $diff->d;
    	$order_id = $result->order_id;
    	$status = $result->status_message;
    	$date = $result->transaction_time;

    	if ($hari > 5) {
    		$data_tarif	= [
				'id_tagihan'	=> $id_tagihan,
				'order_id'		=> $order_id,
				'tgl_bayar'		=> $date,
				'status'		=> $status,
			];
    	} else {
    		$data_tarif	= [
				'id_tagihan'	=> $id_tagihan,
				'order_id'		=> $order_id,
				'tgl_bayar'		=> $date,
				'status'		=> $status,
			];
    	}
    	
		$this->M_tagihan->update($data_tarif);
    	
    	$this->session->set_flashdata('msg', 'success');
		redirect('tagihan');
    }

    public function get_notification($order_id, $date)
    {
    	$data_tarif	= [
			'order_id'		=> $order_id,
			'tgl_bayar'		=> $date,
			'status'		=> 'Transaksi berhasil',
		];
		$this->db->where('order_id', $order_id);
		$this->db->update($this->table, $data_tarif);

    }

	public function konfirmasi()
	{
		$data		= $this->input->post(null, true);
		$data = [
			'id_tagihan' => $data['id_tagihan'],
			'status' => 'LS',
		];

		$this->M_tagihan->update($data);
		$this->session->set_flashdata('msg', 'pembayaran-success');
		redirect('tagihan');
	}

	public function cetak($id_tagihan)
	{
		$data['get_tagihan'] = $this->M_tagihan->get_by_id($id_tagihan);
		$data['get_pelanggan'] = $this->M_pelanggan->get_by_id($data['get_tagihan']['id_pelanggan']);
		$tarif = $this->M_tarif->get_by_status('1');
		$data['nama'] = $data['get_pelanggan']['nama'];
		$data['no_hp'] = $data['get_pelanggan']['no_hp'];
		$data['tarif'] = $tarif['tarif'];
		$data['qty'] = $data['get_tagihan']['jml_meter_bulan_ini'];
		$data['bulan'] = date('F', strtotime($data['get_tagihan']['tgl_tagihan']));
		$data['tagihan'] = 'Rp '.number_format($data['get_tagihan']['tagihan'], 2, ',', '.');
		$this->load->view('tagihan/cetak', $data);
	}


	private function validation()
	{
		$this->form_validation->set_rules('id_pel', 'Pelanggan', 'required|trim');
		$this->form_validation->set_rules('tgl_tagihan', 'Tanggal Tagihan', 'required|trim');
		$this->form_validation->set_rules('no_meter', 'No. Meter', 'required|trim');
		
	}

	private function validation_laporan()
	{
		$this->form_validation->set_rules('tgl_tagihan', 'Bulan Tagihan', 'required|trim');
	}

	public function hapus($id_paket)
	{
		$this->M_paket->delete($id_paket);
		$this->session->set_flashdata('msg', 'hapus');
		redirect('paket');
	}
}