<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Mahasiswa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_mahasiswa');
        $this->load->model('Mod_angkatan');
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_import');
    }

    public function index()
    {
        $data['judul'] = 'Daftar Mahasiswa';
        $data['angkatan'] = $this->Mod_angkatan->get_all();
        $data['sindikat'] = $this->Mod_sindikat->get_all();
        $data['modal_tambah_mahasiswa'] = show_my_modal('mahasiswa/modal_tambah_mahasiswa', $data);
        $js = $this->load->view('mahasiswa/mahasiswa-js', null, true);
        $this->template->views('mahasiswa/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_mahasiswa->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mhs) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mhs->nama_mhs;
            $row[] = $mhs->nama_angkatan;
            $row[] = $mhs->nim;
            $row[] = $mhs->sindikat;
            $row[] = $mhs->id_mhs;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_mahasiswa->count_all(),
            "recordsFiltered" => $this->Mod_mahasiswa->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_mahasiswa->get_mhs($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'nama_mhs'       => $this->input->post('nama_mhs'),
            'nim'            => $this->input->post('nim'),
            'id_sindikat'    => $this->input->post('sindikat'),
            'id_angkatan'    => $this->input->post('angkatan'),
            'alamat'         => $this->input->post('alamat'),
            'no_hp'          => $this->input->post('telepon'),
        );
        $this->Mod_mahasiswa->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_mhs');
        $data  = array(
            'nama_mhs'       => $this->input->post('nama_mhs'),
            'nim'            => $this->input->post('nim'),
            'id_sindikat'    => $this->input->post('sindikat'),
            'id_angkatan'    => $this->input->post('angkatan'),
            'alamat'         => $this->input->post('alamat'),
            'no_hp'          => $this->input->post('telepon'),
        );
        $this->Mod_mahasiswa->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_mhs');
        $this->Mod_mahasiswa->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function import()
    {
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);

            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ($extension == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }

            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $sheetcount = count($sheetData);
            if ($sheetcount > 1) {
                for ($i = 1; $i < $sheetcount; $i++) {
                    $nama_mhs = $sheetData[$i]['0'];
                    $nim = $sheetData[$i]['1'];
                    $nama_sindikat = $sheetData[$i]['2'];

                    $sindikat = $this->Mod_sindikat->get_id_sindikat($nama_sindikat);

                    $alamat = $sheetData[$i]['3'];
                    $telepon = $sheetData[$i]['4'];
                    $nama_angkatan = $sheetData[$i]['5'];

                    $angkatan = $this->Mod_angkatan->get_id_angkatan($nama_angkatan);

                    $temp_data[] = array(
                        'nama_mhs' => $nama_mhs,
                        'nim' => $nim,
                        'id_sindikat' => $sindikat->id_sindikat,
                        'id_angkatan' => $angkatan->id_angkatan,
                        'alamat' => $alamat,
                        'no_hp' => $telepon,
                    );
                }

                $insert = $this->Mod_import->insert($temp_data, 'tbl_mahasiswa');

                if ($insert) {
                    redirect('daftar-mahasiswa');
                }
            }
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_mhs') == '') {
            $data['inputerror'][] = 'nama_mhs';
            $data['error_string'][] = 'Nama Mahasiswa Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nim') == '') {
            $data['inputerror'][] = 'nim';
            $data['error_string'][] = 'NIM Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('sindikat') == '') {
            $data['inputerror'][] = 'sindikat';
            $data['error_string'][] = 'Sindikat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('angkatan') == '') {
            $data['inputerror'][] = 'angkatan';
            $data['error_string'][] = 'Angkatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('alamat') == '') {
            $data['inputerror'][] = 'alamat';
            $data['error_string'][] = 'Alamat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('telepon') == '') {
            $data['inputerror'][] = 'telepon';
            $data['error_string'][] = 'No. HP Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Mahasiswa.php */