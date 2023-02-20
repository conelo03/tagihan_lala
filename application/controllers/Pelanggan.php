<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('login') != TRUE)
		{
			set_pesan('Silahkan login terlebih dahulu', false);
			redirect('');
		}
		date_default_timezone_set("Asia/Jakarta");
	}

	public function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$this->db->like('id_pel', $_GET['term'] , 'both');
	        $this->db->order_by('id_pel', 'ASC');
	        $this->db->limit(10);
	        $result = $this->db->get('tb_pelanggan')->result();
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->id_pel .' - '.$row->nama;
                echo json_encode($arr_result);
            }

        }
	}

	public function index()
	{
        $data['title']		= 'Kelola Pelanggan';
		$data['pelanggan']	= $this->M_pelanggan->get_data()->result_array();
		$this->load->view('pelanggan/data', $data);
	}

	public function tambah()
	{
		$this->validation();
		if (!$this->form_validation->run()) {
			$data['title']		= 'Tambah Pelanggan';
			$this->load->view('pelanggan/tambah', $data);
		} else {
			$data		= $this->input->post(null, true);
			$data_tarif	= [
				'id_pel'		=> $data['id_pel'],
				'tanggal_masuk' => date('Y-m-d'),
				'no_ktp'		=> $data['no_ktp'],
				'nama'		=> $data['nama'],
				'alamat'	=> $data['alamat'],
				'no_hp'		=> $data['no_hp'],
				'email'		=> $data['email'],
				'username'		=> $data['username'],
				'password'	=> password_hash($data['password'], PASSWORD_DEFAULT),
				//'level'		=> $data['level'],
				'status'	=> '1',	
			];
			if ($this->M_pelanggan->insert($data_tarif)) {
				$this->session->set_flashdata('msg', 'error');
				redirect('tambah-pelanggan');
			} else {
				$this->session->set_flashdata('msg', 'success');
				redirect('pelanggan');
			}
		}
	}

	public function edit($id_pelanggan)
	{
		$this->validation($id_pelanggan);
		if (!$this->form_validation->run()) {
			$data['title']		= 'Edit Pelanggan';
			
			$data['pelanggan']	= $this->M_pelanggan->get_by_id($id_pelanggan);
			$this->load->view('pelanggan/edit', $data);
		} else {
			$data		= $this->input->post(null, true);
			if(!empty($data['password'])){
				$data_tarif	= [
					'id_pelanggan'	=> $id_pelanggan,
					'id_pel'		=> $data['id_pel'],
					'no_ktp'		=> $data['no_ktp'],
					'nama'		=> $data['nama'],
					'alamat'	=> $data['alamat'],
					'no_hp'		=> $data['no_hp'],
					'email'		=> $data['email'],
					'username'		=> $data['username'],
					'password'	=> password_hash($data['password'], PASSWORD_DEFAULT),
				];
			} else {
				$data_tarif	= [
					'id_pelanggan'	=> $id_pelanggan,
					'id_pel'		=> $data['id_pel'],
					'no_ktp'		=> $data['no_ktp'],
					'nama'		=> $data['nama'],
					'alamat'	=> $data['alamat'],
					'no_hp'		=> $data['no_hp'],
					'email'		=> $data['email'],
					'username'		=> $data['username'],
				];
			}
			
			if ($this->M_pelanggan->update($data_tarif)) {
				$this->session->set_flashdata('msg', 'error');
				redirect('edit-pelanggan/'.$id_pelanggan);
			} else {
				$this->session->set_flashdata('msg', 'edit');
				redirect('pelanggan');
			}
		}
	}

	private function validation($id_pelanggan = null)
	{
		if(is_null($id_pelanggan)){
			$this->form_validation->set_rules('id_pel', 'ID Pelanggan', 'required|trim');
			$this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required|trim');
			$this->form_validation->set_rules('alamat', 'Nama Pelanggan', 'required|trim');
			$this->form_validation->set_rules('no_hp', 'Nama Pelanggan', 'required|trim');
			$this->form_validation->set_rules('email', 'Email Pelanggan', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'matches[password]|required');
			
		} else {
			$this->form_validation->set_rules('id_pel', 'ID Pelanggan', 'required|trim');
			$this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required|trim');
			$this->form_validation->set_rules('alamat', 'Nama Pelanggan', 'required|trim');
			$this->form_validation->set_rules('no_hp', 'Nama Pelanggan', 'required|trim');
			$this->form_validation->set_rules('email', 'Email Pelanggan', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim');
			$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'matches[password]');
			
		}
		
	}

	public function hapus($id_pelanggan)
	{
		$this->M_pelanggan->delete($id_pelanggan);
		$this->session->set_flashdata('msg', 'hapus');
		redirect('pelanggan');
	}

	public function status($id_pelanggan, $status)
	{
		$data_tarif	= [
			'id_pelanggan'	=> $id_pelanggan,
			'status'		=> $status,
		];
			
		$this->M_pelanggan->update($data_tarif);
		$this->session->set_flashdata('msg', 'edit');
		redirect('pelanggan');
	}

	public function setting()
	{
		$this->validation_setting();
		if (!$this->form_validation->run()) {
			$data['title']		= 'Edit Akun';
			$id_pelanggan 		= $this->session->userdata('id_pelanggan');
			$data['pelanggan']	= $this->M_pelanggan->get_by_id($id_pelanggan);
			$this->load->view('pelanggan/setting', $data);
		} else {
			$id_pelanggan 		= $this->session->userdata('id_pelanggan');
			$data	= $this->input->post(null, true);
			$pelanggan = $this->M_pelanggan->get_by_id($id_pelanggan);
			if(!password_verify($this->input->post('password_lama'), $pelanggan['password']))
			{
				$this->session->set_flashdata('msg', 'password-salah');
				redirect('setting');
			}

			$data_pengguna = [
				'id_pelanggan'		=> $id_pelanggan,
				'username'	=> $data['username'],
				'password'	=> password_hash($data['password_baru'], PASSWORD_DEFAULT),
			];

			
			
			if ($this->M_pelanggan->update($data_pengguna)) {
				$this->session->set_flashdata('msg', 'error');
				redirect('setting-pelanggan');
			} else {
				$this->session->set_flashdata('msg', 'edit');
				redirect('setting-pelanggan');
			}
		}
	}

	private function validation_setting()
	{
		$username		= $this->session->userdata('username');
		$username_baru 	= $this->input->post('username');
		if($username == $username_baru){
			$this->form_validation->set_rules('username', 'username', 'required');	
		} else {
			$this->form_validation->set_rules('username', 'username', 'required|is_unique[tb_pelanggan.username]', ['is_unique'	=> 'Username Sudah Ada']);
		}
		
		$this->form_validation->set_rules('password_lama', 'Password Lama', 'required');	
		$this->form_validation->set_rules('password_baru', 'Password Baru', 'required');		
		$this->form_validation->set_rules('konfirmasi_password_baru', 'Konfirmasi Password Baru', 'required|matches[password_baru]');
	}

}