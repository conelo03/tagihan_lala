<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif extends CI_Controller {

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

	public function index()
	{
        $data['title']		= 'Kelola Tarif';
		$data['tarif']		= $this->M_tarif->get_data()->result_array();
		$this->load->view('tarif/data', $data);
	}

	public function tambah()
	{
		$this->validation();
		if (!$this->form_validation->run()) {
			$data['title']		= 'Tambah Tarif';
			$this->load->view('tarif/tambah', $data);
		} else {
			$data		= $this->input->post(null, true);
			$data_tarif	= [
				'tarif'		=> $data['tarif'],
			];
			if ($this->M_tarif->insert($data_tarif)) {
				$this->session->set_flashdata('msg', 'error');
				redirect('tambah-tarif');
			} else {
				$this->session->set_flashdata('msg', 'success');
				redirect('tarif');
			}
		}
	}

	public function edit($id_tarif)
	{
		$this->validation($id_tarif);
		if (!$this->form_validation->run()) {
			$data['title']		= 'Edit Tarif';
			$data['tarif']	= $this->M_tarif->get_by_id($id_tarif);
			$this->load->view('tarif/edit', $data);
		} else {
			$data		= $this->input->post(null, true);
			$data_tarif	= [
				'id_tarif'	=> $id_tarif,
				'tarif'		=> $data['tarif'],
			];
			
			if ($this->M_tarif->update($data_tarif)) {
				$this->session->set_flashdata('msg', 'error');
				redirect('edit-tarif/'.$id_tarif);
			} else {
				$this->session->set_flashdata('msg', 'edit');
				redirect('tarif');
			}
		}
	}

	private function validation($id_tarif = null)
	{
		$this->form_validation->set_rules('tarif', 'tarif', 'required|trim');
		
	}

	public function hapus($id_tarif)
	{
		$this->M_tarif->delete($id_tarif);
		$this->session->set_flashdata('msg', 'hapus');
		redirect('tarif');
	}

	public function status($id_tarif, $status)
	{
		$data_tarif	= [
			'id_tarif'	=> $id_tarif,
			'status'		=> $status,
		];
			
		$this->M_tarif->update($data_tarif);
		$this->session->set_flashdata('msg', 'edit');
		redirect('tarif');
	}
}
