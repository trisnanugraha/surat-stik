<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_kelas');
    }

    public function index()
    {
        $data['judul'] = 'Kelas';
        $data['modal_tambah_kelas'] = show_my_modal('kelas/modal_tambah_kelas', $data);
        $js = $this->load->view('kelas/kelas-js', null, true);
        $this->template->views('kelas/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_kelas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $kelas) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $kelas->nama_kelas;
            $row[] = $kelas->id_kelas;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_kelas->count_all(),
            "recordsFiltered" => $this->Mod_kelas->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_kelas->get_kelas($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'nama_kelas'    => $this->input->post('nama_kelas'),
        );
        $this->Mod_kelas->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_kelas');
        $data  = array(
            'nama_kelas' => $this->input->post('nama_kelas'),
        );
        $this->Mod_kelas->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_kelas');
        $this->Mod_kelas->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_kelas') == '') {
            $data['inputerror'][] = 'nama_kelas';
            $data['error_string'][] = 'Nama Kelas Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Kelas.php */