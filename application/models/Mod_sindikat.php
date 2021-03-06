<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_sindikat extends CI_Model
{

    var $table = 'tbl_sindikat';
    var $column_order = array('', 'nama_sindikat');
    var $column_search = array('nama_sindikat');
    var $order = array('id_sindikat' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query()
    {
        $this->db->from($this->table);
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
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

    function get_all_sindikat()
    {
        $this->db->where('nama_sindikat !=', '-');
        return $this->db->get($this->table)
            ->result();
    }

    function get_id_sindikat($nama_sindikat)
    {
        $this->db->where('nama_sindikat', $nama_sindikat);
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
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function update($id, $data)
    {
        $this->db->where('id_sindikat', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where('id_sindikat', $id);
        $this->db->delete($this->table);
    }
}

/* End of file Mod_sindikat.php */
