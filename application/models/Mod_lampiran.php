<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_lampiran extends CI_Model
{
    var $table = 'tbl_lampiran';

    function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function get_lampiran_by_id($id)
    {
        $this->db->select('a.id_mhs,b.nama_mhs as nama_mhs, b.nim as nim, a.keterangan');
        $this->db->join('tbl_mahasiswa b', 'a.id_mhs=b.id_mhs');
        $this->db->from("{$this->table} a");
        $this->db->where('id_permohonan_surat', $id);
        return $this->db->get()->result();
    }
}

/* End of file Mod_kelas.php */
