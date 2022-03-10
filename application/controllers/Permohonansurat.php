<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permohonansurat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_permohonan_surat');
        $this->load->model('Mod_validasi_sekretaris');
        $this->load->model('Mod_validasi_kasenat');
        $this->load->model('Mod_validasi_kakorwa');
        $this->load->model('Mod_mahasiswa');
        $this->load->model('Mod_lampiran');
    }

    public function index()
    {
        $data['judul'] = 'Permohonan Surat';
        $data['mahasiswa'] = $this->Mod_mahasiswa->get_all();
        $data['modal_tambah_surat'] = show_my_modal('permohonan_surat/modal_tambah_surat', $data);
        $data['modal_detail_surat'] = show_my_modal('permohonan_surat/modal_detail_surat', $data);
        $js = $this->load->view('permohonan_surat/permohonan-surat-js', null, true);
        $this->template->views('permohonan_surat/home', $data, $js);
    }

    public function ajax_list()
    {
        $id_user = $this->session->userdata('id_user');
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_permohonan_surat->get_datatables($id_user);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $surat) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $surat->perihal;

            if ($surat->tanggal_berangkat == $surat->tanggal_pulang) {
                $row[] = $this->fungsi->tanggalindo($surat->tanggal_berangkat);
            } else {
                $row[] = $this->fungsi->tanggalindo($surat->tanggal_berangkat) . ' s/d ' . $this->fungsi->tanggalindo($surat->tanggal_pulang);
            }

            $row[] = $surat->lokasi;
            $row[] = $surat->status;
            $row[] = $surat->id_permohonan_surat;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_permohonan_surat->count_all(),
            "recordsFiltered" => $this->Mod_permohonan_surat->count_filtered($id_user),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data['surat'] = $this->Mod_permohonan_surat->get_surat_by_id($id);
        $data['lampiran'] = $this->Mod_lampiran->get_lampiran_by_id($id);

        // echo('<pre>');
        // print_r(json_encode($data['lampiran']));

        $total = count($data['lampiran']);
        $data['total'] = $total;

        // echo('<pre>');
        // print_r($data['total']);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();

        if ($this->input->post('isCheck') == 'true') {
            $save  = array(
                'id_pemohon'           => $this->session->userdata('id_user'),
                'perihal'              => $this->input->post('perihal'),
                'tanggal_berangkat'    => $this->input->post('tanggal_berangkat'),
                'tanggal_pulang'       => $this->input->post('tanggal_pulang'),
                'lokasi'               => $this->input->post('lokasi'),
                'isi_surat'            => $this->input->post('isi_surat'),
                'tembusan'             => $this->input->post('tembusan'),
                'judul_lampiran'       => $this->input->post('judul_lampiran')
            );
        } else {
            $save  = array(
                'id_pemohon'           => $this->session->userdata('id_user'),
                'perihal'              => $this->input->post('perihal'),
                'tanggal_berangkat'    => $this->input->post('tanggal_berangkat'),
                'tanggal_pulang'       => $this->input->post('tanggal_berangkat'),
                'lokasi'               => $this->input->post('lokasi'),
                'isi_surat'            => $this->input->post('isi_surat'),
                'tembusan'             => $this->input->post('tembusan'),
                'judul_lampiran'       => $this->input->post('judul_lampiran'),
            );
        }

        $get_id = $this->Mod_permohonan_surat->insert($save);

        if ($this->input->post('id_mahasiswa') != null) {
            $count = count($this->input->post('id_mahasiswa'));

            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $id_mhs = $this->input->post('id_mahasiswa');
                    $keterangan = $this->input->post('keterangan');
                    $data_mhs = array(
                        'id_permohonan_surat' => $get_id,
                        'id_mhs' => intval($id_mhs[$i]),
                        'keterangan' => $keterangan[$i]
                    );
                    $this->Mod_lampiran->insert($data_mhs);
                }
            }
        }

        $validasi = array(
            'id_permohonan_surat' => $get_id
        );

        $this->Mod_validasi_sekretaris->insert($validasi);

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $id = $this->input->post('id_permohonan_surat');
        $this->_validate();

        if ($this->input->post('isCheck') == 'true') {
            $save  = array(
                'id_pemohon'           => $this->session->userdata('id_user'),
                'perihal'              => $this->input->post('perihal'),
                'tanggal_berangkat'    => $this->input->post('tanggal_berangkat'),
                'tanggal_pulang'       => $this->input->post('tanggal_pulang'),
                'lokasi'               => $this->input->post('lokasi'),
                'isi_surat'            => $this->input->post('isi_surat'),
                'tembusan'             => $this->input->post('tembusan'),
                'judul_lampiran'       => $this->input->post('judul_lampiran'),
                'status'               => 'Diproses'
            );
        } else {
            $save  = array(
                'id_pemohon'           => $this->session->userdata('id_user'),
                'perihal'              => $this->input->post('perihal'),
                'tanggal_berangkat'    => $this->input->post('tanggal_berangkat'),
                'tanggal_pulang'       => $this->input->post('tanggal_berangkat'),
                'lokasi'               => $this->input->post('lokasi'),
                'isi_surat'            => $this->input->post('isi_surat'),
                'tembusan'             => $this->input->post('tembusan'),
                'judul_lampiran'       => $this->input->post('judul_lampiran'),
                'status'               => 'Diproses'
            );
        }
        $this->Mod_permohonan_surat->update($id, $save);

        $data_sekretaris = $this->Mod_validasi_sekretaris->get_surat_by_id($id);
        $data_kasenat = $this->Mod_validasi_kasenat->get_surat_by_id($id);
        $data_kakorwa = $this->Mod_validasi_kakorwa->get_surat_by_id($id);

        if ($data_sekretaris != null) {
            $status_sekretaris = $data_sekretaris->status_sekretaris;

            if ($status_sekretaris != 'Disetujui') {
                $validasi = array(
                    'status_sekretaris' => 'Diproses'
                );

                $this->Mod_validasi_sekretaris->update($id, $validasi);
            }
        }

        if ($data_kasenat != null) {
            $status_kasenat = $data_kasenat->status_kasenat;
            if ($status_kasenat != 'Disetujui') {
                $validasi = array(
                    'status_kasenat' => 'Diproses'
                );

                $this->Mod_validasi_kasenat->update($id, $validasi);
            }
        }

        if ($data_kakorwa != null) {
            $status_kakorwa = $data_kakorwa->status_kakorwa;
            if ($status_kakorwa != 'Disetujui') {
                $validasi = array(
                    'status_kakorwa' => 'Diproses'
                );

                $this->Mod_validasi_kakorwa->update($id, $validasi);
            }
        }

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

    public function print($id)
    {
        $data['surat'] = $this->Mod_permohonan_surat->get_surat_by_id($id);
        $data['lampiran'] = $this->Mod_lampiran->get_lampiran_by_id($id);
        // echo('<pre>');
        // print_r($data['lampiran']);

        $this->load->library('pdf');
        $paper = $this->pdf->setPaper('A4', 'potrait');
        $filename = $this->pdf->filename = "Nota Dinas.pdf";

        if ($data['lampiran'] != null) {
            $html = $this->load->view('permohonan_surat/template-nota-dinas-lampiran', $data, TRUE);
        } else {
            $html = $this->load->view('permohonan_surat/template-nota-dinas', $data, TRUE);
        }

        $this->fungsi->PdfGenerator($html, 'Draft - Nota Dinas.pdf', 'A4', 'potrait');
    }

    public function generate($id)
    {
        $data['surat'] = $this->Mod_permohonan_surat->get_surat_by_id($id);
        $data['lampiran'] = $this->Mod_lampiran->get_lampiran_by_id($id);
        $tanggal = $this->Mod_validasi_kasenat->get_surat_by_id($id);
        $data['surat']->tgl_diubah = $this->fungsi->tanggalindo(date('Y-m-d', strtotime($tanggal->tgl_diubah)));
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

        if ($this->input->post('perihal') == '') {
            $data['inputerror'][] = 'perihal';
            $data['error_string'][] = 'Perihal Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tanggal_berangkat') == '') {
            $data['inputerror'][] = 'tanggal_berangkat';
            $data['error_string'][] = 'Tanggal Mulai Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('isCheck') == 'true') {
            if ($this->input->post('tanggal_pulang') == '') {
                $data['inputerror'][] = 'tanggal_pulang';
                $data['error_string'][] = 'Tanggal Selesai Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('lokasi') == '') {
            $data['inputerror'][] = 'lokasi';
            $data['error_string'][] = 'Lokasi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('isi_surat') == '') {
            $data['inputerror'][] = 'isi_surat';
            $data['error_string'][] = 'Isi Surat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Permohonansurat.php */