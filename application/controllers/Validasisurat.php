<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validasisurat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_validasi_surat');
        $this->load->model('Mod_validasi_sekretaris');
        $this->load->model('Mod_validasi_kasenat');
        $this->load->model('Mod_validasi_kakorwa');
        $this->load->model('Mod_permohonan_surat');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_user');
        $this->load->model('Mod_surat_keluar');
        $this->load->model('Mod_surat_perintah');
        $this->load->model('Mod_lampiran');
        $this->load->library('ciqrcode');
    }

    public function index()
    {
        $checklevel = $this->_cek_status($this->session->userdata('id_level'));
        $data['judul'] = 'Validasi Permohonan Surat';
        $data['level'] = $checklevel;
        $data['staffkorwa'] = $this->Mod_user->get_all(15);
        // $data['modal_tambah_surat'] = show_my_modal('validasi_surat/modal_tambah_surat', $data);
        $data['modal_validasi_surat'] = show_my_modal('validasi_surat/modal_validasi_surat', $data);
        $js = $this->load->view('validasi_surat/validasi-surat-js', null, true);
        $this->template->views('validasi_surat/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $level = $this->_cek_status($this->session->userdata('id_level'));
        if ($level == 'Sekretaris') {
            $list = $this->Mod_validasi_sekretaris->get_datatables();
            $recordTotal = $this->Mod_validasi_sekretaris->count_all();
            $recordFiltered = $this->Mod_validasi_sekretaris->count_filtered();
        } elseif ($level == 'Kasenat') {
            $list = $this->Mod_validasi_kasenat->get_datatables();
            $recordTotal = $this->Mod_validasi_kasenat->count_all();
            $recordFiltered = $this->Mod_validasi_kasenat->count_filtered();
        } elseif ($level == 'Kakorwa') {
            $list = $this->Mod_validasi_kakorwa->get_datatables();
            $recordTotal = $this->Mod_validasi_kakorwa->count_all();
            $recordFiltered = $this->Mod_validasi_kakorwa->count_filtered();
        }
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $surat) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $surat->pemohon;
            $row[] = $surat->perihal;
            $row[] = $this->fungsi->tanggalindo($surat->tanggal_berangkat) . '<br>s/d<br>' . $this->fungsi->tanggalindo($surat->tanggal_pulang);
            $row[] = $surat->lokasi;
            if ($level == 'Sekretaris') {
                $row[] = $surat->status_sekretaris;
                $row[] = $surat->id_validasi_sekretaris;
            } else if ($level == 'Kasenat') {
                $row[] = $surat->status_kasenat;
                $row[] = $surat->id_validasi_kasenat;
            } else if ($level == 'Kakorwa') {
                $row[] = $surat->status_kakorwa;
                $row[] = $surat->id_validasi_kakorwa;
            }
            $row[] = $surat->id_permohonan_surat;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $recordTotal,
            "recordsFiltered" => $recordFiltered,
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

        if ($level == 'Sekretaris') {
            $data = $this->Mod_validasi_sekretaris->get_surat_by_id($id);
        } else if ($level == 'Kasenat') {
            $data = $this->Mod_validasi_kasenat->get_surat_by_id($id);
        } else if ($level == 'Kakorwa') {
            $data = $this->Mod_validasi_kakorwa->get_surat_by_id($id);
        }

        // $data->tanggal = $this->fungsi->tanggalindo($data->tanggal_berangkat) . ' ~ ' . $this->fungsi->tanggalindo($data->tanggal_pulang);
        $data->level = $level;

        echo json_encode($data);
    }

    public function validasi()
    {
        $qr_nota = null;
        $id = $this->input->post('id_permohonan_surat');
        $checklevel = $this->_cek_status($this->session->userdata('id_level'));

        if ($checklevel == 'Sekretaris') {
            $data  = array(
                'status_sekretaris' => $this->input->post('status_sekretaris'),
                'catatan_sekretaris' => $this->input->post('catatan_sekretaris'),
            );

            if ($this->input->post('status_sekretaris') == 'Diproses') {
                $status = 'Diproses';
                $nota_dinas = '';
            } else if ($this->input->post('status_sekretaris') == 'Ditolak') {
                $status = 'Ditolak';
                $nota_dinas = '';
            } else if ($this->input->post('status_sekretaris') == 'Butuh Perbaikan') {
                $status = 'Butuh Perbaikan';
                $nota_dinas = '';
            } else if ($this->input->post('status_sekretaris') == 'Disetujui') {
                $status = 'Diproses';
                $nota_dinas = $this->input->post('nomor_nota');
            }

            $data_surat = array(
                'status' => $status,
                'nomor_nota' => $nota_dinas
            );

            $this->Mod_validasi_sekretaris->update($id, $data);
            $this->Mod_permohonan_surat->update($id, $data_surat);
        } else if ($checklevel == 'Kasenat') {
            $data  = array(
                'status_kasenat' => $this->input->post('status_kasenat'),
                'catatan_kasenat' => $this->input->post('catatan_kasenat'),
            );

            if ($this->input->post('status_kasenat') == 'Diproses') {
                $status = 'Diproses';
            } else if ($this->input->post('status_kasenat') == 'Ditolak') {
                $status = 'Ditolak';
            } else if ($this->input->post('status_kasenat') == 'Butuh Perbaikan') {
                $status = 'Butuh Perbaikan';
            } else if ($this->input->post('status_kasenat') == 'Disetujui') {
                $status = 'Disetujui';
                $qr_nota = $id . '.png'; //buat name dari qr code sesuai dengan nim

                $params['data'] = 'Surat ini telah disahkan dan divalidasi oleh Kasenat pada ' . tgl_indonesia(date('Y-m-d H:i:s')) . ' melalui Sistem E-Nota Dinas'; //data yang akan di jadikan QR CODE
                $params['level'] = 'H'; //H=High
                $params['size'] = 10;
                $params['savename'] = FCPATH . './assets/qr-code/' . $id . ".png"; //simpan image QR CODE ke folder assets/images/
                $this->ciqrcode->generate($params);
            }

            $data_surat = array(
                'status' => $status,
                'qr_nota' => $qr_nota
            );

            $this->Mod_validasi_kasenat->update($id, $data);
            $this->Mod_permohonan_surat->update($id, $data_surat);
        } else if ($checklevel == 'Kakorwa') {
            $data  = array(
                'status_kakorwa' => $this->input->post('status_kakorwa'),
                'catatan_kakorwa' => $this->input->post('catatan_kakorwa'),
            );

            if ($this->input->post('status_kakorwa') == 'Diproses') {
                $status = 'Diproses';
            } else if ($this->input->post('status_kakorwa') == 'Ditolak') {
                $status = 'Ditolak';
            } else if ($this->input->post('status_kakorwa') == 'Butuh Perbaikan') {
                $status = 'Butuh Perbaikan';
            } elseif ($this->input->post('status_kakorwa') == 'Disetujui') {
                $status = 'Disetujui';
                $staffkorwa = $this->input->post('kirim_ke');

                // $qr_nota = $id . '.png'; //buat name dari qr code sesuai dengan nim

                // $params['data'] = 'Surat ini telah disahkan dan divalidasi oleh Kakorwa pada ' . date('d-m-Y H:i:s') . ' Melalui Sistem E-Nota Dinas'; //data yang akan di jadikan QR CODE
                // $params['level'] = 'H'; //H=High
                // $params['size'] = 10;
                // $params['savename'] = FCPATH . './assets/qr-code/' . $id . ".png"; //simpan image QR CODE ke folder assets/images/
                // $this->ciqrcode->generate($params);
            }

            $data_surat = array(
                'status' => $status,
                // 'qr_nota' => $qr_nota
            );

            $this->Mod_validasi_kakorwa->update($id, $data);
            $this->Mod_permohonan_surat->update($id, $data_surat);
        }

        if ($this->input->post('status_sekretaris') == 'Disetujui') {
            $kasenat = array(
                'id_permohonan_surat' => $id,
                'id_validasi_sekretaris' => $this->input->post('id_validasi_sekretaris'),
                'status_kasenat' => 'Diproses'
            );

            $this->Mod_validasi_kasenat->insert($kasenat);
        };

        if ($this->input->post('status_kasenat') == 'Disetujui') {
            $kasenat = array(
                'id_permohonan_surat' => $id,
                'id_validasi_kasenat' => $this->input->post('id_validasi_kasenat'),
                'status_kakorwa' => 'Diproses'
            );

            $this->Mod_validasi_kakorwa->insert($kasenat);
        };

        if ($this->input->post('status_kakorwa') == 'Disetujui') {
            $data_staff = array(
                'id_user' => $staffkorwa,
                'id_permohonan_surat' => $id
            );

            $this->Mod_surat_perintah->insert($data_staff);
        };

        // echo json_encode($data);

        // $checkdata = $this->Mod_validasi_sekretaris->get_surat_by_id($id);
        // echo json_encode($checkdata);

        // if ($checkdata->status_sekretaris == 'Disetujui' && $checkdata->status_kasenat == 'Disetujui' && $checkdata->status_kakorwa == 'Disetujui') {
        //     $save  = array(
        //         'id_permohonan_surat' => $id,
        //         'qr_nota' => $qr_nota
        //     );
        //     $this->Mod_surat_keluar->insert($save);
        // }

        echo json_encode(array("status" => TRUE));
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