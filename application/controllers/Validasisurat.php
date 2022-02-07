<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validasisurat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_validasi_surat');
        $this->load->model('Mod_userlevel');
    }

    public function index()
    {
        $data['judul'] = 'Validasi Permohonan Surat';
        $data['modal_tambah_surat'] = show_my_modal('validasi_surat/modal_tambah_surat', $data);
        $data['modal_validasi_surat'] = show_my_modal('validasi_surat/modal_validasi_surat', $data);
        $js = $this->load->view('validasi_surat/validasi-surat-js', null, true);
        $this->template->views('validasi_surat/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $level = $this->_cek_status($this->session->userdata('id_level'));
        $list = $this->Mod_validasi_surat->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $surat) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $surat->pemohon;
            $row[] = $surat->perihal;
            $row[] = $this->fungsi->tanggalindo($surat->tanggal_berangkat) . ' ~ ' . $this->fungsi->tanggalindo($surat->tanggal_pulang);
            $row[] = $surat->lokasi;
            if ($level == 'Admin') {
                $row[] = $surat->status_sekretaris;
            } else if ($level == 'Kasenat') {
                $row[] = $surat->status_kasenat;
            } else if ($level == 'Kakorwa') {
                $row[] = $surat->status_kakorwa;
            }

            $row[] = $surat->id_permohonan_surat;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_validasi_surat->count_all(),
            "recordsFiltered" => $this->Mod_validasi_surat->count_filtered(),
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
        $level = $this->_cek_status($this->session->userdata('id_level'));
        $data = $this->Mod_validasi_surat->get_surat_by_id($id);
        $data->tanggal = $this->fungsi->tanggalindo($data->tanggal_berangkat) . ' ~ ' . $this->fungsi->tanggalindo($data->tanggal_pulang);
        $data->level = $level;

        echo json_encode($data);
    }

    public function validasi()
    {
        // $this->_validate();
        $id      = $this->input->post('id_permohonan_surat');

        // var_dump($this->input->post('id_permohonan_surat'));
        // var_dump($this->input->post('status_sekretaris'));
        // var_dump($this->input->post('keterangan_sekretaris'));

        $data  = array(
            'status_sekretaris' => $this->input->post('status_sekretaris'),
            'keterangan_sekretaris' => $this->input->post('keterangan_sekretaris'),
            'tgl_validasi_sekretaris' => date('Y-m-d H:i:s'),
        );

        // echo json_encode($data);
        $this->Mod_validasi_surat->update($id, $data);
        echo json_encode(array("status" => TRUE));
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

    private function _cek_status($id_level)
    {
        $nama_level = $this->Mod_userlevel->getUserlevel($id_level);
        return $nama_level->nama_level;
    }
}

/* End of file Validasisurat.php */