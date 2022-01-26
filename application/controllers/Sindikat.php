<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sindikat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_sindikat');
    }

    public function index()
    {
        $data['judul'] = 'Sindikat';
        $data['modal_tambah_sindikat'] = show_my_modal('sindikat/modal_tambah_sindikat', $data);
        $js = $this->load->view('sindikat/sindikat-js', null, true);
        $this->template->views('sindikat/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_sindikat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sindikat) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $sindikat->nama_sindikat;
            $row[] = $sindikat->id_sindikat;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_sindikat->count_all(),
            "recordsFiltered" => $this->Mod_sindikat->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_sindikat->get_sindikat($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'nama_sindikat'    => $this->input->post('nama_sindikat'),
        );
        $this->Mod_sindikat->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_sindikat');
        $data  = array(
            'nama_sindikat' => $this->input->post('nama_sindikat'),
        );
        $this->Mod_sindikat->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_sindikat');
        $this->Mod_sindikat->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_sindikat') == '') {
            $data['inputerror'][] = 'nama_sindikat';
            $data['error_string'][] = 'Nama Sindikat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Sindikat.php */