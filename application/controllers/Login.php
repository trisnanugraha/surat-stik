<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_login', 'Mod_userlevel'));
    }

    public function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in == TRUE) {
            if ($this->session->userdata('id_level') == 1) {
                redirect('dashboard');
            } elseif ($this->session->userdata('id_level') == 15) {
                redirect('suratperintah');
            } else {
                redirect('permohonansurat');
            }
        } else {
            $aplikasi['aplikasi'] = $this->Mod_login->Aplikasi()->row();
            $this->load->view('admin/login_data', $aplikasi);
        }
    } //end function index

    function login()
    {

        $this->_validate();
        //cek username database
        $username = anti_injection($this->input->post('username'));
        $status = $this->Mod_login->check_status($username);

        if ($this->Mod_login->check_db($username)->num_rows() == 1) {
            if ($status->is_active != 'N') {
                $db = $this->Mod_login->check_db($username)->row();
                $apl = $this->Mod_login->Aplikasi()->row();

                if (hash_verified(anti_injection($this->input->post('password')), $db->password)) {
                    //cek username dan password yg ada di database
                    $userdata = array(
                        'id_user'  => $db->id_user,
                        'username'    => ucfirst($db->username),
                        'user_name'    => $db->username,
                        'full_name'   => ucfirst($db->full_name),
                        'password'    => $db->password,
                        'id_level'    => $db->id_level,
                        'aplikasi'    => $apl->nama_aplikasi,
                        'title'       => $apl->title,
                        'logo'        => $apl->logo,
                        'nama_owner'     => $apl->nama_owner,
                        'logged_in'    => TRUE
                    );

                    $this->session->set_userdata($userdata);

                    $checklevel = $this->_cek_status($userdata['id_level']);

                    if ($checklevel == 'Admin') {
                        $data['url'] = 'dashboard';
                    } else if ($checklevel == 'Mahasiswa') {
                        $data['url'] = 'permohonan-surat';
                    } else if ($checklevel == 'Staff Korwa') {
                        $data['url'] = 'surat-perintah';
                    } else {
                        $data['url'] = 'validasi-surat';
                    }

                    $data['status'] = TRUE;
                    echo json_encode($data);
                } else {

                    $data['pesan'] = "Username atau Password Salah!";
                    $data['error'] = TRUE;
                    echo json_encode($data);
                }
            } else {
                $data['pesan'] = "Akun Anda belum aktif, silakan hubungi Administrator";
                $data['error'] = TRUE;
                echo json_encode($data);
            }
        } else {
            $data['pesan'] = "Username atau Password belum terdaftar!";
            $data['error'] = TRUE;
            echo json_encode($data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->load->driver('cache');
        $this->cache->clean();
        ob_clean();
        redirect('login');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password Tidak Boleh Kosong';
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

/* End of file Login.php */
