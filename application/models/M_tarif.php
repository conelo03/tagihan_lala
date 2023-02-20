<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tarif extends CI_Model {

	public $table	= 'tb_tarif';

	public function get_data()
	{
		$this->db->select('*');
		$this->db->from($this->table);
        return $this->db->get();
	}

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function get_by_id($id_tarif)
	{
		return $this->db->get_where($this->table, ['id_tarif' => $id_tarif])->row_array();
	}

	public function get_by_status($status)
	{
		return $this->db->get_where($this->table, ['status' => $status])->row_array();
	}

	public function get_by_role($role)
	{
		return $this->db->get_where($this->table, ['role' => $role])->result_array();
	}

	public function update($data)
	{
		$this->db->where('id_tarif', $data['id_tarif']);
		$this->db->update($this->table, $data);
	}

	public function delete($id_tarif)
	{
		$this->db->delete($this->table, ['id_tarif' => $id_tarif]);
	}
}
