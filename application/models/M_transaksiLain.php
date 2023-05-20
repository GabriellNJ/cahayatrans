<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_TransaksiLain extends CI_Model
{


	public function get()
	{
		$this->db->order_by('id_mutasi', 'desc');
		$data = $this->db->get('tb_transaksilain')->result();
		$result = array();
		foreach ($data as $key) {
			$row = array();
			$row['id_mutasi'] = $key->id_mutasi;
			$row['pendapatan_mutasi'] = $key->pendapatan_mutasi;
			$row['nota'] = $key->nota;
			$row['tanggal_mutasi'] = $key->tanggal_mutasi;
			$row['keterangan_mutasi'] = $key->keterangan_mutasi;
			$row['total_mutasi'] = $key->total_mutasi;
			$result[] = $row;
		}
		return $result;
	}

	public function getTL()
	{
		return $this->db->get('tb_transaksilain');
	}
	public function getId($id)
    {
        return $this->db->get_where('tb_transaksilain',['id_mutasi' => (int)$id])->row();
    }
	public function tampil() {
		
		$this->db->order_by('id_mutasi', 'desc')->limit(1);
		$result = $this->db->get('tb_transaksilain');
		return $result->result();
   
	}
	public function updateTransaksi($data, $id)
    {
        $this->db->update('tb_transaksilain', $data, ['id_mutasi' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->pendapatan_mutasi    = $post['pendapatan_mutasi']; 
		    $this->nota    = $post['nota']; 
			$this->tanggal_mutasi  = $post['tanggal_mutasi'];
			$this->keterangan_mutasi  = $post['keterangan_mutasi'];
			$this->total_mutasi  = $post['total_mutasi'];

			$this->db->update('tb_transaksilain', $this, array('id_mutasi' => $post['id_mutasi']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function delete($id)
    {
        $this->db->delete('tb_transaksilain', ['id_mutasi' => $id]);
        return $this->db->affected_rows();
    }


	
}