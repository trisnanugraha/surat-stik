<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suratperintah extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_surat_perintah');
        $this->load->model('Mod_surat_keluar');
        $this->load->model('Mod_validasi_sekretaris');
        $this->load->model('Mod_validasi_kasenat');
        $this->load->model('Mod_validasi_kakorwa');
        $this->load->model('Mod_mahasiswa');
        $this->load->model('Mod_lampiran');
        $this->load->library('ciqrcode');
    }

    public function index()
    {
        $data['judul'] = 'Surat Perintah';
        $data['mahasiswa'] = $this->Mod_mahasiswa->get_all();
        $data['modal_tambah_surat'] = show_my_modal('surat_perintah/modal_tambah_surat', $data);
        $data['modal_detail_surat'] = show_my_modal('surat_perintah/modal_detail_surat', $data);
        $js = $this->load->view('surat_perintah/surat-perintah-js', null, true);
        $this->template->views('surat_perintah/home', $data, $js);
    }

    public function ajax_list()
    {
        $id_user = $this->session->userdata('id_user');
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_surat_perintah->get_datatables($id_user);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $surat) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $surat->nomor_nota;
            // $row[] = $surat->perihal;

            // if ($surat->tanggal_berangkat == $surat->tanggal_pulang) {
            //     $row[] = $this->fungsi->tanggalindo($surat->tanggal_berangkat);
            // } else {
            //     $row[] = $this->fungsi->tanggalindo($surat->tanggal_berangkat) . ' s/d ' . $this->fungsi->tanggalindo($surat->tanggal_pulang);
            // }

            $row[] = $surat->status;
            $row[] = $surat->id_surat_perintah;
            $row[] = $surat->id_permohonan_surat;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_surat_perintah->count_all(),
            "recordsFiltered" => $this->Mod_surat_perintah->count_filtered($id_user),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_surat_perintah->get_surat_perintah_by_id($id);

        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id_surat_perintah');
        $this->_validate();

        $save  = array(
            'nomor_surat'       => $this->input->post('nomor_surat'),
            'pertimbangan'      => $this->input->post('pertimbangan'),
            'dasar'             => $this->input->post('dasar'),
            'kepada'            => $this->input->post('kepada'),
            'untuk'             => $this->input->post('untuk'),
            'tempat_terbit'     => $this->input->post('tempat_terbit'),
            'tanggal_terbit'    => $this->input->post('tanggal_terbit'),
            'atas_nama'         => $this->input->post('atas_nama'),
            'nama_lengkap'      => $this->input->post('nama_lengkap'),
            'pangkat'           => $this->input->post('pangkat'),
            'tembusan'          => $this->input->post('tembusan'),
            'judul_lampiran'    => $this->input->post('judul_lampiran'),
            'status'            => 'Diproses'
        );

        $this->Mod_surat_perintah->update($id, $save);

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

        $status_sekretaris = $this->Mod_validasi_sekretaris->get_status_surat($id);
        $data->status_sekretaris =  $status_sekretaris->status_sekretaris;
        $data->keterangan_sekretaris =  $status_sekretaris->catatan_sekretaris;

        $status_kasenat = $this->Mod_validasi_kasenat->get_status_surat($id);
        if ($status_kasenat != null) {
            $data->status_kasenat =  $status_kasenat->status_kasenat;
            $data->keterangan_kasenat =  $status_kasenat->catatan_kasenat;
        }

        $status_kakorwa = $this->Mod_validasi_kakorwa->get_status_surat($id);
        if ($status_kakorwa != null) {
            $data->status_kakorwa =  $status_kakorwa->status_kakorwa;
            $data->keterangan_kakorwa =  $status_kakorwa->catatan_kakorwa;
        }

        if ($data->tanggal_berangkat == $data->tanggal_pulang) {
            $data->tanggal = $this->fungsi->tanggalindo($data->tanggal_berangkat);
        } else {
            $data->tanggal = $this->fungsi->tanggalindo($data->tanggal_berangkat) . ' ~ ' . $this->fungsi->tanggalindo($data->tanggal_pulang);
        }

        echo json_encode($data);
    }

    public function send()
    {
        $id = $this->input->post('id_surat_perintah');
        $id_pengirim = $this->session->userdata('id_user');
        $id_tujuan = $this->Mod_surat_perintah->get_pemohon($id);
        $data_surat = $this->Mod_surat_perintah->get_surat_perintah_by_id($id);

        $save = array(
            'id_surat_perintah' => $id,
            'id_pengirim' => $id_pengirim,
            'id_tujuan' => $id_tujuan
        );

        $qr_surat = $id . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = 'Surat ini telah disahkan dan divalidasi a/n ' . $data_surat->atas_nama . ' oleh ' . $data_surat->nama_lengkap . ' (' . $data_surat->pangkat . ') pada ' . tgl_indonesia(date('Y-m-d H:i:s')) . ' melalui Sistem E-Nota Dinas'; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . './assets/qr-code-sprin/' . $id . ".png"; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params);

        $status = array(
            'status' => 'Selesai',
            'qr_surat' => $qr_surat
        );

        $this->Mod_surat_keluar->insert($save);
        $this->Mod_surat_perintah->update($id, $status);
        echo json_encode(array("status" => TRUE));
    }

    public function print($id)
    {
        $data['surat'] = $this->Mod_surat_perintah->get_surat_by_id($id);
        $data['surat']->tanggal_terbit = $this->fungsi->tanggalindo(date('Y-m-d', strtotime($data['surat']->tanggal_terbit)));
        $data['lampiran'] = $this->Mod_lampiran->get_lampiran_by_id($id);
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

    public function generate($id)
    {
        $data['surat'] = $this->Mod_permohonan_surat->get_surat_by_id($id);
        $data['lampiran'] = $this->Mod_lampiran->get_lampiran_by_id($id);
        $data['surat']->tgl_diubah = $this->fungsi->tanggalindo(date('Y-m-d', strtotime($data['surat']->tgl_diubah)));
        // $this->load->library('pdf');
        // $paper = $this->pdf->setPaper('A4', 'potrait');
        // $filename = $this->pdf->filename = "Nota Dinas.pdf";

        if ($data['lampiran'] != null) {
            $html = $this->load->view('permohonan_surat/cetak-nota-dinas-lampiran', $data, TRUE);
        } else {
            $html = $this->load->view('permohonan_surat/cetak-nota-dinas', $data, TRUE);
        }

        $this->fungsi->PdfGenerator($html, 'E-Nota Dinas -- ' . date('d:m:Y', strtotime($data['surat']->tgl_diubah)) . '.pdf', 'A4', 'potrait');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nomor_surat') == '') {
            $data['inputerror'][] = 'nomor_surat';
            $data['error_string'][] = 'Nomor Surat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        // if ($this->input->post('pertimbangan') == '') {
        //     $data['inputerror'][] = 'pertimbangan';
        //     $data['error_string'][] = 'Bagian Pertimbangan Surat Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        // if ($this->input->post('dasar') == '') {
        //     $data['inputerror'][] = 'dasar';
        //     $data['error_string'][] = 'Bagian Dasar Surat Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        // if ($this->input->post('kepada') == '') {
        //     $data['inputerror'][] = 'kepada';
        //     $data['error_string'][] = 'Bagian Kepada Surat Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        // if ($this->input->post('untuk') == '') {
        //     $data['inputerror'][] = 'untuk';
        //     $data['error_string'][] = 'Bagian Untuk Surat Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        if ($this->input->post('tempat_terbit') == '') {
            $data['inputerror'][] = 'tempat_terbit';
            $data['error_string'][] = 'Tempat Terbit Surat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tanggal_terbit') == '') {
            $data['inputerror'][] = 'tanggal_terbit';
            $data['error_string'][] = 'Tanggal Terbit Surat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('atas_nama') == '') {
            $data['inputerror'][] = 'atas_nama';
            $data['error_string'][] = 'Atas Nama Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nama_lengkap') == '') {
            $data['inputerror'][] = 'nama_lengkap';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('pangkat') == '') {
            $data['inputerror'][] = 'pangkat';
            $data['error_string'][] = 'Pangkat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Suratperintah.php */