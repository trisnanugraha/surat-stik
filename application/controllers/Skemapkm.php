<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skemapkm extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_skema_pkm');
    }

    public function index()
    {
        $data['judul'] = "Skema PKM";
        $data['modal_tambah_skema_pkm'] = show_my_modal('skema_pkm/modal_tambah_skema_pkm', $data);

        $js = $this->load->view('skema_pkm/skema-pkm-js', null, true);
        $this->template->views('skema_pkm/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_skema_pkm->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $skema) {
            $cekdata = $this->Mod_skema_pkm->get_data($skema->id_skema_pkm);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $skema->nama_skema;
            $row[] = $skema->id_skema_pkm;
            $row[] = $cekdata;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_skema_pkm->count_all(),
            "recordsFiltered" => $this->Mod_skema_pkm->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_skema_pkm->get_skema($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'nama_skema'    => $this->input->post('nama_skema'),
        );
        $this->Mod_skema_pkm->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_skema_pkm');
        $save  = array(
            'nama_skema' => $this->input->post('nama_skema'),
        );
        $this->Mod_skema_pkm->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_skema_pkm');
        $this->Mod_skema_pkm->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_skema') == '') {
            $data['inputerror'][] = 'nama_skema';
            $data['error_string'][] = 'Nama Skema Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file SkemaPKM.php */