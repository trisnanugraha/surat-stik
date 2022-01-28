<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permohonansurat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_permohonan_surat');
    }

    public function index()
    {
        $data['judul'] = 'Permohonan Surat';
        $data['modal_tambah_surat'] = show_my_modal('permohonan_surat/modal_tambah_surat', $data);
        $data['modal_detail_surat'] = show_my_modal('permohonan_surat/modal_detail_surat', $data);
        $js = $this->load->view('permohonan_surat/permohonan-surat-js', null, true);
        $this->template->views('permohonan_surat/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_permohonan_surat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $surat) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $surat->perihal;
            $row[] = $this->fungsi->tanggalindo($surat->tanggal_berangkat) . ' ~ ' . $this->fungsi->tanggalindo($surat->tanggal_pulang);
            $row[] = $surat->lokasi;
            $row[] = $surat->id_permohonan_surat;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_permohonan_surat->count_all(),
            "recordsFiltered" => $this->Mod_permohonan_surat->count_filtered(),
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
            'id_pemohon'           => $this->session->userdata('id_user'),
            'perihal'              => $this->input->post('perihal'),
            'tanggal_berangkat'    => $this->input->post('tanggal_berangkat'),
            'tanggal_pulang'       => $this->input->post('tanggal_pulang'),
            'lokasi'               => $this->input->post('lokasi'),
        );
        $this->Mod_permohonan_surat->insert($save);
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
        $id = $this->input->post('id_permohonan_surat');
        $this->Mod_permohonan_surat->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function detail($id)
    {
        $data = $this->Mod_permohonan_surat->get_surat_by_id($id);
        $data->tanggal = $this->fungsi->tanggalindo($data->tanggal_berangkat) . ' ~ ' . $this->fungsi->tanggalindo($data->tanggal_pulang);

        echo json_encode($data);
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('perihal') == '') {
            $data['inputerror'][] = 'perihal';
            $data['error_string'][] = 'Perihal Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tanggal_berangkat') == '') {
            $data['inputerror'][] = 'tanggal_berangkat';
            $data['error_string'][] = 'Tanggal Berangkat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tanggal_pulang') == '') {
            $data['inputerror'][] = 'tanggal_pulang';
            $data['error_string'][] = 'Tanggal Pulang Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('lokasi') == '') {
            $data['inputerror'][] = 'lokasi';
            $data['error_string'][] = 'Lokasi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Permohonansurat.php */