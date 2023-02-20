<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tagihan extends CI_Model {

	public $table	= 'tb_tagihan';

	public function get_data($status = null)
	{
		$this->db->select('*, tb_tagihan.status as status_tagihan');
		$this->db->from($this->table);
		$this->db->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan=tb_tagihan.id_pelanggan');
		if(!is_null($status)){
			if($status == 'BL'){
				$this->db->where('tb_tagihan.status', $status);
				$this->db->or_where('tb_tagihan.status', 'Transaksi sedang diproses');
			} else {
				$this->db->where('tb_tagihan.status', $status);
			}
		}
        return $this->db->get();
	}

	public function get_data_by_pelanggan($id_pelanggan, $status = null)
	{
		$this->db->select('*, tb_tagihan.status as status_tagihan');
		$this->db->from($this->table);
		$this->db->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan=tb_tagihan.id_pelanggan');
		$this->db->where('tb_tagihan.id_pelanggan', $id_pelanggan);
		if(!is_null($status)){
			if($status == 'BL'){
				$this->db->group_start();
				$this->db->where('tb_tagihan.status', $status);
				$this->db->or_where('tb_tagihan.status', 'Transaksi sedang diproses');
				$this->db->group_end();
			} else {
				$this->db->where('tb_tagihan.status', $status);
			}
			
		}
        return $this->db->get();
  //       if(!is_null($status)){
		// 	if($status == 'BL'){
		// 		return $this->db->query("SELECT *, tb_tagihan.status as status_tagihan FROM tb_tagihan join tb_pelanggan on tb_pelanggan.id_pelanggan=tb_tagihan.id_pelanggan");
		// 	} else {
		// 		return $this->db->get();
		// 	}
			
		// }
	}

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function get_by_id($id_tagihan)
	{
		return $this->db->get_where($this->table, ['id_tagihan' => $id_tagihan])->row_array();
	}

	public function get_by_role($role)
	{
		return $this->db->get_where($this->table, ['role' => $role])->result_array();
	}

	public function update($data)
	{
		$this->db->where('id_tagihan', $data['id_tagihan']);
		$this->db->update($this->table, $data);
	}

	public function delete($id_pelanggan)
	{
		$this->db->delete($this->table, ['id_tagihan' => $id_tagihan]);
	}
}
