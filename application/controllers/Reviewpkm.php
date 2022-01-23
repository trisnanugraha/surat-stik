<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reviewpkm extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_review_pkm');
        $this->load->model('Mod_priode');
        $this->load->model('Mod_skema_pkm');
        $this->load->model('Mod_user');
    }

    public function index()
    {
        $data['judul'] = "Review PKM";
        $data['priode'] = $this->Mod_priode->get_all();
        $data['skema'] = $this->Mod_skema_pkm->get_all();
        $data['user'] = $this->Mod_user->get_all();
        $data['link'] = 'assets/template/Template Review.docx';
        $data['filename'] = 'Template Review.docx';

        $data['modal_detail_review_pkm'] = show_my_modal('review_pkm/modal_detail_review_pkm', $data);

        $js = $this->load->view('review_pkm/review-pkm-js', null, true);
        $this->template->views('review_pkm/home', $data, $js);
    }

    public function ajax_list()
    {
        $id = $this->session->userdata['id_user'];
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_review_pkm->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $review) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $review->full_name;
            $row[] = $review->judul_pkm;
            $row[] = $review->nama_skema;
            $row[] = $review->status;
            $row[] = $review->status_reviewer;
            $row[] = $review->id_ajuan_pkm;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_review_pkm->count_all($id),
            "recordsFiltered" => $this->Mod_review_pkm->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_review_pkm->get_data($id);
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_ajuan_pkm');

        if (!empty($_FILES['berkasreview']['name'])) {
            $file = $this->_uploadPdf('pkm', 'berkasreview');
        } else {
            $file = $this->input->post('filereview');
        }

        $save  = array(
            'status_reviewer' => $this->input->post('status_reviewer'),
            'komentar_reviewer' => $this->input->post('komentar_reviewer'),
            'berkas_review' => $file,
        );
        $this->Mod_review_pkm->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_ajuan_pkm');
        $this->Mod_review_pkm->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('status_reviewer') == '') {
            $data['inputerror'][] = 'status_reviewer';
            $data['error_string'][] = 'Status Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _uploadPdf($folder, $target)
    {
        $user = $this->session->userdata['full_name'];
        $format = "%Y-%M-%d--%H-%i";
        $config['upload_path']          = './upload/review/' . $folder . '/';
        $config['allowed_types']        = 'pdf|doc|docx';
        $config['overwrite']            = true;
        $config['file_name']            = mdate($format) . "_Hasil_Review_{$user}";

        $this->upload->initialize($config);

        if ($this->upload->do_upload($target)) {
            return $this->upload->data('file_name');
        }
    }
}

/* End of file Reviewpkm.php */