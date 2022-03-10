<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['aktivasi-user'] = 'Aktivasiuser/index';
$route['permohonan-surat'] = 'Permohonansurat/index';
$route['validasi-surat'] = 'Validasisurat/index';
$route['daftar-mahasiswa'] = 'Mahasiswa/index';
$route['daftar-mahasiswa/import'] = 'Mahasiswa/import';
$route['kotak-surat'] = 'Kotaksurat/index';
$route['surat-perintah'] = 'Suratperintah/index';

