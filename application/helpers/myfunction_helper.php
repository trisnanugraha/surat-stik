<?php
date_default_timezone_set('Asia/Jakarta');

function tgl_indonesia($date)
{
	/* array hari dan bulan */
	$nama_hari  = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");

	$nama_bulan = array(
		"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
		"November", "Desember"
	);

	/*  Memisahkan format tanggal, bulan, tahun dengan substring */
	$tahun   = substr($date, 0, 4);
	$bulan   = substr($date, 5, 2);
	$tanggal = substr($date, 8, 2);
	$waktu   = substr($date, 11, 5);

	//w Urutan hari dalam seminggu
	$hari    = date("w", strtotime($date));

	$result  = $nama_hari[$hari] . ", " . $tanggal . " " . $nama_bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu . " WIB";
	//keterangan (int)$bulan-1 karena array dimulai dari index ke 0 maka bulan-1
	return $result;
}

function anti_injection($data)
{
	$filter = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
	return $filter;
}

function slug($s)
{
	$c = array(' ');
	$d = array('-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']', '{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+');

	$s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d

	$s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	return $s;
}


function rupiah($nominal)
{
	return number_format($nominal, 0, ',', '.');
}

/** login codeIgniter menggunakan bycrypt **/

if (!function_exists('get_hash')) {
	function get_hash($PlainPassword)
	{
		$option = [
			'cost' => 5, // proses hash sebanyak: 2^5 = 32x
		];
		return password_hash($PlainPassword, PASSWORD_DEFAULT, $option);
	}
}

if (!function_exists('hash_verified')) {
	function hash_verified($PlainPassword, $HashPassword)
	{
		return password_verify($PlainPassword, $HashPassword) ? true : false;
	}
}

/** login codeIgniter menggunakan bycrypt **/

function show_my_modal($content = '', $data = '')
{
	$_ci = &get_instance();
	if ($content != '') {
		$view_content = $_ci->load->view($content, $data, TRUE);
		return $view_content;
	}
}

function helper_log($tipe = "", $str = "", $id = "", $ip = "")
{
	$CI = &get_instance();

	if (strtolower($tipe) == "login") {
		$log_tipe   = 0;
	} elseif (strtolower($tipe) == "logout") {
		$log_tipe   = 1;
	} elseif (strtolower($tipe) == "add") {
		$log_tipe   = 2;
	} elseif (strtolower($tipe) == "edit") {
		$log_tipe  = 3;
	} elseif (strtolower($tipe) == "delete") {
		$log_tipe  = 4;
	} elseif (strtolower($tipe) == "export") {
		$log_tipe  = 5;
	} elseif (strtolower($tipe) == "import") {
		$log_tipe  = 6;
	} else {
		$log_tipe  = 7;
	}

	// parameter
	$param['log_username']  = $CI->session->userdata('username');
	$param['log_type']      = $log_tipe;
	$param['log_desc']      = $str;
	$param['log_id_act']	= $id;
	$param['log_ip']		= $ip;
	$CI->load->library('user_agent');

	$data['browser'] = $CI->agent->browser();

	$data['browser_version'] = $CI->agent->version();

	$data['os'] = $CI->agent->platform();

	$data['ip_address'] = $CI->input->ip_address();

	//load model log
	$CI->load->model('m_log');

	//save to database
	$CI->m_log->save_log($param);
}
