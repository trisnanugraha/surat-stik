<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datapkm extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_data_pkm');
        $this->load->model('Mod_priode');
        $this->load->model('Mod_skema_pkm');
        $this->load->model('Mod_user');
    }

    public function index()
    {
        $reviewer = 8;
        $data['judul'] = "Data PKM";
        $data['priode'] = $this->Mod_priode->get_all();
        $data['skema'] = $this->Mod_skema_pkm->get_all();
        $data['user'] = $this->Mod_user->get_all();
        $data['reviewer'] = $this->Mod_user->get_all($reviewer);

        $data['modal_detail_data_pkm'] = show_my_modal('data_pkm/modal_detail_data_pkm', $data);
        $data['modal_print_data_pkm'] = show_my_modal('data_pkm/modal_print_data_pkm', $data['priode']);
        $js = $this->load->view('data_pkm/data-pkm-js', null, true);
        $this->template->views('data_pkm/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_data_pkm->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ajuan) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ajuan->full_name;
            $row[] = $ajuan->judul_pkm;
            $row[] = $ajuan->nama_skema;
            $row[] = $ajuan->status;
            $row[] = $ajuan->status_reviewer;
            $row[] = $ajuan->id_ajuan_pkm;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_data_pkm->count_all(),
            "recordsFiltered" => $this->Mod_data_pkm->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $idReviewer = $this->Mod_data_pkm->check_reviewer($id);

        $list_anggota = array();
        for ($i = 1; $i <= 5; $i++) {
            $get_value = $this->Mod_data_pkm->get_anggota($id, $i);

            if ($get_value == null || $get_value == '') {
                $list_anggota["anggota{$i}"] = null;
            } else {
                $list_anggota["anggota{$i}"] = $get_value->full_name;
            }
        }

        if ($idReviewer->id_reviewer == '' || $idReviewer->id_reviewer == null) {
            $data = $this->Mod_data_pkm->get_new_data($id);
        } else {
            $data = $this->Mod_data_pkm->get_data($id);
        }
        $data->anggaran =  'Rp ' . rupiah($data->anggaran);
        $data->anggota1 = $list_anggota['anggota1'];
        $data->anggota2 = $list_anggota['anggota2'];
        $data->anggota3 = $list_anggota['anggota3'];
        $data->anggota4 = $list_anggota['anggota4'];
        $data->anggota5 = $list_anggota['anggota5'];
        // $data = $this->Mod_data_pkm->get_data($id);
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_ajuan_pkm');
        $save  = array(
            'status' => $this->input->post('status'),
            'komentar_lppm' => $this->input->post('komentar_lppm'),
            'id_reviewer' => $this->input->post('reviewer'),
        );
        $this->Mod_data_pkm->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_ajuan_pkm');
        $this->Mod_data_pkm->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('status') == '') {
            $data['inputerror'][] = 'status';
            $data['error_string'][] = 'Status Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function print()
    {
        $id = $this->input->post('priode');
        $tipe = $this->input->post('tipeFile');
        if ($id != "all") {
            $dataPkm = $this->Mod_data_pkm->get_by_priode($id)->result();
            $count = $this->Mod_data_pkm->count_by_priode($id);
        } else {
            $dataPkm = $this->Mod_data_pkm->getAll()->result();
            $count = $this->Mod_data_pkm->count_all();
        }

        if ($count > 0) {
            if ($tipe == "PDF") {
                $this->_pdf($dataPkm);
            } else if ($tipe == "Excel") {
                $this->_excel($dataPkm);
            }
        } else {
            echo "Data Masih Kosong";
        }
    }

    private function _pdf($records)
    {
        foreach ($records as $data) {
            $row = array();
            $ketua = $this->Mod_user->getUser($data->id_ketua);
            $skema = $this->Mod_skema_pkm->get_skema($data->id_skema);
            if ($data->id_anggota_1 != null) {
                $anggota1 = $this->Mod_user->getUser($data->id_anggota_1);
                $anggota1 = $anggota1->full_name;
            } else {
                $anggota1 = '';
            }
            if ($data->id_anggota_2 != null) {
                $anggota2 = $this->Mod_user->getUser($data->id_anggota_2);
                $anggota2 = $anggota2->full_name;
            } else {
                $anggota2 = '';
            }
            if ($data->id_anggota_3 != null) {
                $anggota3 = $this->Mod_user->getUser($data->id_anggota_3);
                $anggota3 = $anggota3->full_name;
            } else {
                $anggota3 = '';
            }
            if ($data->id_anggota_4 != null) {
                $anggota4 = $this->Mod_user->getUser($data->id_anggota_4);
                $anggota4 = $anggota4->full_name;
            } else {
                $anggota4 = '';
            }
            if ($data->id_anggota_5 != null) {
                $anggota5 = $this->Mod_user->getUser($data->id_anggota_5);
                $anggota5 = $anggota5->full_name;
            } else {
                $anggota5 = '';
            }

            $row = [
                'ketua' => $ketua->full_name,
                'skema' => $skema->nama_skema,
                'judul_pkm' => $data->judul_pkm,
                'anggota1' => $anggota1,
                'anggota2' => $anggota2,
                'anggota3' => $anggota3,
                'anggota4' => $anggota4,
                'anggota5' => $anggota5,
                'komentar_lppm' => $data->komentar_lppm,
                'komentar_reviewer' => $data->komentar_reviewer,
            ];
            $record['pkm'][] = $row;
        }
        $format = "%Y-%M-%d--%H-%i";
        $this->load->library('pdf');
        $this->pdf->setPaper('legal', 'landscape');
        $this->pdf->filename = "Laporan Data PKM -- " . mdate($format) . ".pdf";
        $this->pdf->load_view('data_pkm/print-layout', $record);
    }

    private function _excel($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'font' => [
                'bold'  =>  true,
                'size'  =>  10,
                'name'  =>  'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $styleData = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('N')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('Q')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('T')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('Y')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('Z')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('A')->setWidth(10);
        foreach (range('B', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getDefaultRowDimension($col)->setRowHeight(25);
        }
        $sheet->getStyle('A1:Z1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('bfb8b8');
        $sheet->getStyle('A1:Z1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:Z1')->applyFromArray($styleArray);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Priode');
        $sheet->setCellValue('C1', 'Judul PKM');
        $sheet->setCellValue('D1', 'Skema');
        $sheet->setCellValue('E1', 'Ketua Peneliti');
        $sheet->setCellValue('F1', 'Anggota 1');
        $sheet->setCellValue('G1', 'Anggota 2');
        $sheet->setCellValue('H1', 'Anggota 3');
        $sheet->setCellValue('I1', 'Anggota 4');
        $sheet->setCellValue('J1', 'Anggota 5');
        $sheet->setCellValue('K1', 'Anggaran');
        $sheet->setCellValue('L1', 'Lokasi');
        $sheet->setCellValue('M1', 'Nama Jurnal');
        $sheet->setCellValue('N1', 'Peringkat Jurnal');
        $sheet->setCellValue('O1', 'Link Jurnal');
        $sheet->setCellValue('P1', 'E-ISSN');
        $sheet->setCellValue('Q1', 'Status LPPM');
        $sheet->setCellValue('R1', 'Komentar LPPM');
        $sheet->setCellValue('S1', 'Reviewer');
        $sheet->setCellValue('T1', 'Status Reviewer');
        $sheet->setCellValue('U1', 'Komentar Reviewer');
        $sheet->setCellValue('V1', 'Berkas Laporan');
        $sheet->setCellValue('W1', 'Berkas Jurnal');
        $sheet->setCellValue('X1', 'Berkas Reviewer');
        $sheet->setCellValue('Y1', 'Tanggal Dibuat');
        $sheet->setCellValue('Z1', 'Terakhir Diubah');

        $records = $data;
        $no = 1;
        $x = 2;
        foreach ($records as $row) {
            $sheet->getStyle("A{$x}:Z{$x}")->applyFromArray($styleData);
            $priode = $this->Mod_priode->get_priode($row->id_priode);
            $skema = $this->Mod_skema_pkm->get_skema($row->id_skema);
            $ketua = $this->Mod_user->getUser($row->id_ketua);
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $priode->judul);
            $sheet->setCellValue('C' . $x, $row->judul_pkm);
            $sheet->setCellValue('D' . $x, $skema->nama_skema);
            $sheet->setCellValue('E' . $x, $ketua->full_name);
            if ($row->id_anggota_1 != null) {
                $anggota1 = $this->Mod_user->getUser($row->id_anggota_1);
                $sheet->setCellValue('F' . $x, $anggota1->full_name);
            }
            if ($row->id_anggota_2 != null) {
                $anggota2 = $this->Mod_user->getUser($row->id_anggota_2);
                $sheet->setCellValue('G' . $x, $anggota2->full_name);
            }
            if ($row->id_anggota_3 != null) {
                $anggota3 = $this->Mod_user->getUser($row->id_anggota_3);
                $sheet->setCellValue('H' . $x, $anggota3->full_name);
            }
            if ($row->id_anggota_4 != null) {
                $anggota4 = $this->Mod_user->getUser($row->id_anggota_4);
                $sheet->setCellValue('I' . $x, $anggota4->full_name);
            }
            if ($row->id_anggota_5 != null) {
                $anggota5 = $this->Mod_user->getUser($row->id_anggota_5);
                $sheet->setCellValue('J' . $x, $anggota5->full_name);
            }
            $sheet->setCellValue('K' . $x, 'Rp. ' . rupiah($row->anggaran));
            $sheet->setCellValue('L' . $x, $row->lokasi);
            $sheet->setCellValue('M' . $x, $row->nama_jurnal);
            $sheet->setCellValue('N' . $x, $row->peringkat_jurnal);
            $sheet->setCellValue('O' . $x, $row->link_jurnal);
            $sheet->getCell('O' . $x)->getHyperlink()->setUrl($row->link_jurnal);
            $sheet->setCellValue('P' . $x, $row->e_issn);
            $sheet->setCellValue('Q' . $x, $row->status);
            $sheet->setCellValue('R' . $x, $row->komentar_lppm);
            if ($row->id_reviewer != null) {
                $reviewer = $this->Mod_user->getUser($row->id_reviewer);
                $sheet->setCellValue('S' . $x, $reviewer->full_name);
            }
            $sheet->setCellValue('T' . $x, $row->status_reviewer);
            $sheet->setCellValue('U' . $x, $row->komentar_reviewer);
            if ($row->berkas_laporan != null) {
                $sheet->setCellValue('V' . $x, base_url('upload/pkm/laporan/') . $row->berkas_laporan);
                $sheet->getCell('V' . $x)->getHyperlink()->setUrl(base_url('upload/pkm/laporan/') . $row->berkas_laporan);
            }
            if ($row->berkas_jurnal != null) {
                $sheet->setCellValue('W' . $x, base_url('upload/pkm/jurnal/') . $row->berkas_jurnal);
                $sheet->getCell('W' . $x)->getHyperlink()->setUrl(base_url('upload/pkm/jurnal/') . $row->berkas_jurnal);
            }
            if ($row->berkas_review != null) {
                $sheet->setCellValue('X' . $x, base_url('upload/review/pkm/') . $row->berkas_review);
                $sheet->getCell('X' . $x)->getHyperlink()->setUrl(base_url('upload/review/pkm/') . $row->berkas_review);
            }
            $sheet->setCellValue('Y' . $x, tgl_indonesia($row->tgl_dibuat));
            if ($row->tgl_diubah != null) {
                $sheet->setCellValue('Z' . $x, tgl_indonesia($row->tgl_diubah));
            }
            $x++;
        }
        $format = "%Y-%M-%d--%H-%i";
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data-PKM' . ' -- ' . mdate($format);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

/* End of file DataPKM.php */