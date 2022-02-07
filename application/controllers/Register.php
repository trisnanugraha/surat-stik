<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_kelas');
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_jabatan');
        $this->load->model('Mod_user');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_aktivasi_user');
        $this->load->model(array('Mod_login'));
    }

    public function index()
    {
        $data['aplikasi'] = $this->Mod_login->Aplikasi()->row();
        $data['user_level'] = $this->Mod_user->userlevelRegister();
        $data['kelas'] = $this->Mod_kelas->get_all_kelas();
        $data['sindikat'] = $this->Mod_sindikat->get_all_sindikat();
        $data['jabatan'] = $this->Mod_jabatan->get_all_jabatan();
        $this->load->view('admin/register', $data);
    }

    function signup()
    {
        if ($this->input->post('level') == '') {
            $this->_validateFirst();
        } else {
            $checklevel = $this->Mod_userlevel->getUserlevel($this->input->post('level'));
            $this->_validate($checklevel);
        }

        $username = $this->input->post('username');
        $cek = $this->Mod_user->cekUsername($username);
        if ($cek->num_rows() > 0) {
            $data['pesan'] = "Mohon Maaf Username Tidak Tersedia";
            $data['error'] = TRUE;
            echo json_encode($data);
        } else {
            if ($checklevel->nama_level != 'Mahasiswa') {
                $save  = array(
                    'username' => $this->input->post('username'),
                    'full_name' => $this->input->post('fullname'),
                    'password'  => get_hash($this->input->post('password')),
                    'id_kelas'  => 4,
                    'id_sindikat'  => 8,
                    'id_jabatan'  => $this->input->post('jabatan'),
                    'id_level'  => $this->input->post('level'),
                    'is_active' => 'N'
                );
            } else {
                $save  = array(
                    'username' => $this->input->post('username'),
                    'full_name' => $this->input->post('fullname'),
                    'password'  => get_hash($this->input->post('password')),
                    'id_kelas'  => $this->input->post('kelas'),
                    'id_sindikat'  => $this->input->post('sindikat'),
                    'id_jabatan'  => 8,
                    'id_level'  => $this->input->post('level'),
                    'is_active' => 'N'
                );
            }


            $id = $this->Mod_user->insert_new_user($save);

            $pending = array(
                'id_user' => $id
            );

            $this->Mod_aktivasi_user->insert($pending);
            echo json_encode(array("status" => TRUE));
        }
    }

    private function _validate($level)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('fullname') == '') {
            $data['inputerror'][] = 'fullname';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('verifypassword') == '') {
            $data['inputerror'][] = 'verifypassword';
            $data['error_string'][] = 'Verifikasi Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') != '' && $this->input->post('verifypassword') != '' && $this->input->post('password') != $this->input->post('verifypassword')) {
            $data['inputerror'][] = 'verifypassword';
            $data['error_string'][] = 'Verifikasi Password Tidak Cocok Dengan Password';
            $data['status'] = FALSE;
        }

        if ($this->input->post('level') == '') {
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'Hak Akses Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($level != '' && $level->nama_level != 'Mahasiswa') {
            if ($this->input->post('jabatan') == '') {
                $data['inputerror'][] = 'jabatan';
                $data['error_string'][] = 'Jabatan Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if ($level->nama_level == 'Mahasiswa') {
            if ($this->input->post('kelas') == '') {
                $data['inputerror'][] = 'kelas';
                $data['error_string'][] = 'Kelas Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if ($this->input->post('sindikat') == '') {
                $data['inputerror'][] = 'sindikat';
                $data['error_string'][] = 'Sindikat Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validateFirst()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('fullname') == '') {
            $data['inputerror'][] = 'fullname';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('verifypassword') == '') {
            $data['inputerror'][] = 'verifypassword';
            $data['error_string'][] = 'Verifikasi Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') != '' && $this->input->post('verifypassword') != '' && $this->input->post('password') != $this->input->post('verifypassword')) {
            $data['inputerror'][] = 'verifypassword';
            $data['error_string'][] = 'Verifikasi Password Tidak Cocok Dengan Password';
            $data['status'] = FALSE;
        }

        if ($this->input->post('level') == '') {
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'Hak Akses Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        // if ($this->input->post('jabatan') == '') {
        //     $data['inputerror'][] = 'jabatan';
        //     $data['error_string'][] = 'Jabatan Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        // if ($this->input->post('kelas') == '') {
        //     $data['inputerror'][] = 'kelas';
        //     $data['error_string'][] = 'Kelas Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        // if ($this->input->post('sindikat') == '') {
        //     $data['inputerror'][] = 'sindikat';
        //     $data['error_string'][] = 'Sindikat Tidak Boleh Kosong';
        //     $data['status'] = FALSE;
        // }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Register.php */
