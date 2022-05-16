<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Angkatan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_angkatan');
    }

    public function index()
    {
        $data['judul'] = 'Angkatan';
        $data['modal_tambah_angkatan'] = show_my_modal('angkatan/modal_tambah_angkatan', $data);
        $js = $this->load->view('angkatan/angkatan-js', null, true);
        $this->template->views('angkatan/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_angkatan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $angkatan) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $angkatan->nama_angkatan;
            $row[] = $angkatan->id_angkatan;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_angkatan->count_all(),
            "recordsFiltered" => $this->Mod_angkatan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_angkatan->get_angkatan($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'nama_angkatan'    => $this->input->post('nama_angkatan'),
        );
        $this->Mod_angkatan->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_angkatan');
        $data  = array(
            'nama_angkatan' => $this->input->post('nama_angkatan'),
        );
        $this->Mod_angkatan->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_angkatan');
        $this->Mod_angkatan->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_angkatan') == '') {
            $data['inputerror'][] = 'nama_angkatan';
            $data['error_string'][] = 'Nama Angkatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Kelas.php */