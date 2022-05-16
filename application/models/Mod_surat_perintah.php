<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_surat_perintah extends CI_Model
{

    var $table = 'tbl_surat_perintah';
    var $column_order = array('', 'nomor_nota', 'status');
    var $column_search = array('nomor_nota', 'status');
    var $order = array('b.id_permohonan_surat' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query($id)
    {
        $this->db->select('a.id_surat_perintah, a.status, a.tgl_diubah, b.nomor_nota, b.id_permohonan_surat');
        $this->db->join('tbl_permohonan_surat b', 'a.id_permohonan_surat = b.id_permohonan_surat');
        $this->db->from("{$this->table} a");
        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_all()
    {
        return $this->db->get($this->table)
            ->result();
    }

    function get_surat_perintah_by_id($id)
    {
        $this->db->where('id_surat_perintah', $id);
        return $this->db->get($this->table)->row();
    }

    function get_pemohon($id)
    {
        $this->db->select('b.id_pemohon');
        $this->db->join('tbl_permohonan_surat b', 'a.id_permohonan_surat = b.id_permohonan_surat');
        $this->db->where('id_surat_perintah', $id);
        $query = $this->db->get("{$this->table} a")->row();
        return $query->id_pemohon;
    }

    function get_id_surat_permohonan($id)
    {
        $this->db->select('id_permohonan_surat');
        $this->db->where('id_surat_perintah', $id);
        $query = $this->db->get("{$this->table} a")->row();
        return $query->id_permohonan_surat;
    }

    function get_surat_by_id($id)
    {
        $this->db->where('id_permohonan_surat', $id);
        return $this->db->get($this->table)->row();
    }

    function get_sindikat($id)
    {
        $this->db->where('id_sindikat', $id);
        return $this->db->get($this->table)->row();
    }

    function getuser($id_prodi)
    {
        $this->db->where('id_prodi', $id_prodi);
        $this->db->where('is_active', 'Y');
        $this->db->from('tbl_user');
        return $this->db->count_all_results();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($id, $data)
    {
        $this->db->where('id_surat_perintah', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where('id_permohonan_surat', $id);
        $this->db->delete($this->table);
    }

    function total_rows()
    {
        $data = $this->db->get($this->table);
        return $data->num_rows();
    }
}

/* End of file Mod_permohonan_surat.php */
