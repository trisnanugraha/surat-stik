<?php

use SebastianBergmann\Diff\Diff;

defined('BASEPATH') or exit('No direct script access allowed');

class Ibl extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_ibl');
        $this->load->model('Mod_angkatan');
        $this->load->model('Mod_mahasiswa');
        $this->load->library('ciqrcode');
    }

    public function index()
    {
        $data['judul'] = 'IBL / Cuti';
        $data['angkatan'] = $this->Mod_angkatan->get_all();
        $data['modal_tambah_ibl'] = show_my_modal('ibl/modal_tambah_ibl', $data);
        $js = $this->load->view('ibl/ibl-js', null, true);
        $this->template->views('ibl/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_ibl->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ibl) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ibl->no_surat;
            $row[] = $ibl->id_ibl;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_ibl->count_all(),
            "recordsFiltered" => $this->Mod_ibl->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_ibl->get_ibl($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'no_surat'      => $this->input->post('no_surat'),
            'id_angkatan'   => $this->input->post('id_angkatan'),
            'tgl_berangkat' => $this->input->post('tgl_berangkat'),
            'tgl_kembali'   => $this->input->post('tgl_kembali'),
            'keperluan'     => $this->input->post('keperluan'),
        );

        $get_id = $this->Mod_ibl->insert($save);

        $qr = $get_id . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = 'Surat ini telah disahkan dan divalidasi a/n KETUA SEKOLAH TINGGI ILMU KEPOLISIAN WAKET BIDMINWA u.b. KAKORWA oleh NOVIAR, S.I.K. (KOMISARIS BESAR POLISI NRP 6903039) pada ' . tgl_indonesia(date('Y-m-d H:i:s')) . ' melalui Sistem E-Nota Dinas'; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . './assets/qr-code-ibl/' . $qr; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params);

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_ibl');
        $data  = array(
            'no_surat'      => $this->input->post('no_surat'),
            'id_angkatan'   => $this->input->post('id_angkatan'),
            'tgl_berangkat' => $this->input->post('tgl_berangkat'),
            'tgl_kembali'   => $this->input->post('tgl_kembali'),
            'keperluan'     => $this->input->post('keperluan'),
        );
        $this->Mod_ibl->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_ibl');
        $this->Mod_ibl->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function print($id)
    {
        $angkatan = $this->Mod_ibl->get_id_angkatan($id);
        $data['surat'] = $this->Mod_ibl->get_ibl($id);
        $data['surat']->tgl_dibuat = $this->fungsi->tanggalindo(date('Y-m-d', strtotime($data['surat']->tgl_dibuat)));
        $tgl_berangkat = new DateTime($data['surat']->tgl_berangkat);
        $tgl_kembali = new DateTime($data['surat']->tgl_kembali);
        $total_cuti = date_diff($tgl_berangkat, $tgl_kembali);
        $data['surat']->total_cuti = $total_cuti->days;
        $data['surat']->terbilang = Num_to_text($total_cuti->days);
        $data['mahasiswa'] = $this->Mod_mahasiswa->get_all_by_angkatan($angkatan->id_angkatan);

        $this->load->library('pdf');
        $paper = $this->pdf->setPaper('A4', 'potrait');
        $filename = $this->pdf->filename = "Cuti / IBL.pdf";
        $html = $this->load->view('ibl/template-cuti-ibl', $data, TRUE);

        $this->fungsi->PdfGenerator($html, 'Draft - Cuti - IBL.pdf', 'A4', 'potrait');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('no_surat') == '') {
            $data['inputerror'][] = 'no_surat';
            $data['error_string'][] = 'Nomor Surat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('id_angkatan') == '') {
            $data['inputerror'][] = 'angkatan';
            $data['error_string'][] = 'Angkatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        // if ($this->input->post('tgl_cuti') == '') {
        //     $data['inputerror'][] = 'tgl_cuti';
        //     $data['error_string'][] = 'Tanggal Cuti Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        if ($this->input->post('keperluan') == '') {
            $data['inputerror'][] = 'keperluan';
            $data['error_string'][] = 'Keperluan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Ibl.php */