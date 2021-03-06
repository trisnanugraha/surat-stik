<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kotaksurat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_validasi_surat');
        $this->load->model('Mod_surat_perintah');
        $this->load->model('Mod_lampiran');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_surat_keluar');
    }

    public function index()
    {
        // $checklevel = $this->_cek_status($this->session->userdata('id_level'));
        $data['judul'] = 'Kotak Surat';
        // $data['level'] = $checklevel;
        // $data['modal_kotak_surat'] = show_my_modal('validasi_surat/modal_validasi_surat', $data);
        $js = $this->load->view('kotak_surat/kotak-surat-js', null, true);
        $this->template->views('kotak_surat/home', $data, $js);
    }

    public function ajax_list()
    {
        $nama_level = $this->Mod_userlevel->getUserlevel($this->session->userdata('id_level'));
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        // $level = $this->_cek_status($this->session->userdata('id_level'));
        if ($nama_level->nama_level == 'Mahasiswa') {
            $id_user = $this->session->userdata('id_user');
            $list = $this->Mod_surat_keluar->get_datatables($id_user);
        } else {
            $list = $this->Mod_surat_keluar->get_datatables();
        }

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $surat) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $surat->nomor_surat;
            $row[] = $surat->id_surat_perintah;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        if ($nama_level->nama_level == 'Mahasiswa') {
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Mod_surat_keluar->count_all(),
                "recordsFiltered" => $this->Mod_surat_keluar->count_filtered($id_user),
                "data" => $data,
            );
        } else {
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->Mod_surat_keluar->count_all(),
                "recordsFiltered" => $this->Mod_surat_keluar->count_filtered(),
                "data" => $data,
            );
        }


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
        $id      = $this->input->post('id_permohonan_surat');
        $checklevel = $this->_cek_status($this->session->userdata('id_level'));

        if ($checklevel == 'Admin') {
            $data  = array(
                'status_sekretaris' => $this->input->post('status_sekretaris'),
                'keterangan_sekretaris' => $this->input->post('keterangan_sekretaris'),
                'tgl_validasi_sekretaris' => date('Y-m-d H:i:s'),
            );
        } else if ($checklevel == 'Kasenat') {
            $data  = array(
                'status_kasenat' => $this->input->post('status_kasenat'),
                'keterangan_kasenat' => $this->input->post('keterangan_kasenat'),
                'tgl_validasi_kasenat' => date('Y-m-d H:i:s'),
            );
        } else if ($checklevel == 'Kakorwa') {
            $data  = array(
                'status_kakorwa' => $this->input->post('status_kakorwa'),
                'keterangan_kakorwa' => $this->input->post('keterangan_kakorwa'),
                'tgl_validasi_kakorwa' => date('Y-m-d H:i:s'),
            );
        }

        // echo json_encode($data);
        $this->Mod_validasi_surat->update($id, $data);

        $checkdata = $this->Mod_validasi_surat->get_surat_by_id($id);
        // echo json_encode($checkdata);

        if ($checkdata->status_sekretaris == 'Disetujui' && $checkdata->status_kasenat == 'Disetujui' && $checkdata->status_kakorwa == 'Disetujui') {
            $save  = array(
                'id_permohonan_surat' => $id
            );
            $this->Mod_surat_keluar->insert($save);
        }

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

    public function print($id)
    {
        $id_permohonan_surat = $this->Mod_surat_perintah->get_id_surat_permohonan($id);
        $data['surat'] = $this->Mod_surat_perintah->get_surat_by_id($id_permohonan_surat);
        $data['surat']->tanggal_terbit = $this->fungsi->tanggalindo(date('Y-m-d', strtotime($data['surat']->tanggal_terbit)));
        $data['lampiran'] = $this->Mod_lampiran->get_lampiran_by_id($id_permohonan_surat);
        // echo('<pre>');
        // print_r($data['lampiran']);

        $this->load->library('pdf');
        $paper = $this->pdf->setPaper('A4', 'potrait');
        $filename = $this->pdf->filename = "Nota Dinas.pdf";

        if ($data['lampiran'] != null) {
            $html = $this->load->view('surat_perintah/template-surat-perintah-lampiran', $data, TRUE);
        } else {
            $html = $this->load->view('surat_perintah/template-nota-dinas', $data, TRUE);
        }

        $this->fungsi->PdfGenerator($html, 'Draft - Surat Perintah.pdf', 'A4', 'potrait');
    }
}

/* End of file Validasisurat.php */