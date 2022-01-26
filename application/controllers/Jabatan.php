<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_jabatan');
    }

    public function index()
    {
        $data['judul'] = 'Jabatan';
        $data['modal_tambah_jabatan'] = show_my_modal('jabatan/modal_tambah_jabatan', $data);
        $js = $this->load->view('jabatan/jabatan-js', null, true);
        $this->template->views('jabatan/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_jabatan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jabatan) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jabatan->nama_jabatan;
            $row[] = $jabatan->id_jabatan;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_jabatan->count_all(),
            "recordsFiltered" => $this->Mod_jabatan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_jabatan->get_jabatan($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'nama_jabatan'    => $this->input->post('nama_jabatan'),
        );
        $this->Mod_jabatan->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_jabatan');
        $data  = array(
            'nama_jabatan' => $this->input->post('nama_jabatan'),
        );
        $this->Mod_jabatan->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_jabatan');
        $this->Mod_jabatan->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_jabatan') == '') {
            $data['inputerror'][] = 'nama_jabatan';
            $data['error_string'][] = 'Nama Jabatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Jabatan.php */