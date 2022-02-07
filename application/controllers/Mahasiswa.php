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
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_import');
    }

    public function index()
    {
        $data['judul'] = 'Daftar Mahasiswa';
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
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 2; $row <= $highestRow; $row++) {
					$nama_mhs = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$nim = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$sindikat = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$temp_data[] = array(
						'nama_mhs'		=> $nama_mhs,
						'nim'	        => $nim,
						'id_sindikat'	=> $sindikat,
					);
				}
			}
			$insert = $this->Mod_import->insert($temp_data, 'tbl_mahasiswa');
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

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Mahasiswa.php */