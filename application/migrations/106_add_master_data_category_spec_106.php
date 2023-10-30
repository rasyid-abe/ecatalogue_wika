<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_master_data_category_spec_106 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $category_help2 = array(
  	array(
  		"kode" => "FA",
  		"name" => "PEMASARAN",
  	),
  	array(
  		"kode" => "FB",
  		"name" => "BEBAN SEKRETARIAT",
  	),
  	array(
  		"kode" => "FC",
  		"name" => "FAS. PENG. KANTOR",
  	),
  	array(
  		"kode" => "FD",
  		"name" => "BEBAN PERSONALIA",
  	),
  	array(
  		"kode" => "FE",
  		"name" => "BEBAN KEUANGAN",
  	),
  	array(
  		"kode" => "FF",
  		"name" => "BEBAN KENDARAAN",
  	),
  	array(
  		"kode" => "FG",
  		"name" => "PENGUJIAN",
  	),
  	array(
  		"kode" => "FH",
  		"name" => "BEBAN UMUM",
  	),
  	array(
  		"kode" => "FI",
  		"name" => "PEMBEBANAN BIAYA DIVISI",
  	),
  	array(
  		"kode" => "Z3",
  		"name" => "BIAYA RISIKO",
  	),
  	array(
  		"kode" => "C1",
  		"name" => "UPAH-PEKERJAAN TANAH",
  	),
  	array(
  		"kode" => "C2",
  		"name" => "PEKERJAAN STRUCTURE",
  	),
  	array(
  		"kode" => "C3",
  		"name" => "ARSITEKTUR",
  	),
  	array(
  		"kode" => "C4",
  		"name" => "MEKANIKAL",
  	),
  	array(
  		"kode" => "C5",
  		"name" => "ELEKTRIKAL",
  	),
  	array(
  		"kode" => "C6",
  		"name" => "PEKERJAAN LUAR (LANDSCAPE)",
  	),
  	array(
  		"kode" => "C7",
  		"name" => "UPAH HARIAN",
  	),
  	array(
  		"kode" => "C8",
  		"name" => "UPAH PEKERJAAN PERSIAPAN",
  	),
  	array(
  		"kode" => "C9",
  		"name" => "LOOSE FURNITURE",
  	),
  	array(
  		"kode" => "C10",
  		"name" => "Angkutan",
  	),
  	array(
  		"kode" => "D1",
  		"name" => "OPERASI",
  	),
  	array(
  		"kode" => "D2",
  		"name" => "R/ M (REPAIR & MAINTENANCE)",
  	),
  	array(
  		"kode" => "D3",
  		"name" => "PEMAKAIAN ALAT/MILIK SENDIRI",
  	),
  	array(
  		"kode" => "D4",
  		"name" => "PEMAKAIAN ALAT SEWA/RENTAL",
  	),
  	array(
  		"kode" => "E1",
  		"name" => "FASILITAS DAN UTILITAS PROYEK (SITE FACILITY)",
  	),
  	array(
  		"kode" => "E2",
  		"name" => "PEKERJAAN SUB STRUCTURE",
  	),
  	array(
  		"kode" => "E3",
  		"name" => "PEKERJAAN STRUKTUR",
  	),
  	array(
  		"kode" => "E4",
  		"name" => "PEKERJAAN ARSITEKTUR",
  	),
  	array(
  		"kode" => "E5",
  		"name" => "PEKERJAAN INTERIOR",
  	),
  	array(
  		"kode" => "E6",
  		"name" => "PEKERJAAN TELEKOMUNIKASI & KOMUNIKASI",
  	),
  	array(
  		"kode" => "E7",
  		"name" => "PEKERJAAN INTSRUMENTASI DAN CONTROL SYSTEM",
  	),
  	array(
  		"kode" => "E8",
  		"name" => "PEKERJAAN FIRE FIGHTING SYSTEM / FIRE SUPPRESION SYSTEM",
  	),
  	array(
  		"kode" => "E9",
  		"name" => "PEKERJAAN ELEKTRIKAL",
  	),
  	array(
  		"kode" => "EA",
  		"name" => "PEKERJAAN MEKANIKAL",
  	),
  	array(
  		"kode" => "EB",
  		"name" => "JASA LOGISTIK",
  	),
  	array(
  		"kode" => "EC",
  		"name" => "JASA PERSEWAAN",
  	),
  	array(
  		"kode" => "ED",
  		"name" => "JASA PERBAIKAN PERALATAN",
  	),
  	array(
  		"kode" => "EE",
  		"name" => "JASA KONSULTAN",
  	),
  	array(
  		"kode" => "EF",
  		"name" => "ARSITEKTUR PERTAMANAN DAN LANDSCAPE",
  	),
  	array(
  		"kode" => "EG",
  		"name" => "ASURANSI",
  	),
  	array(
  		"kode" => "F1",
  		"name" => "SEWA LAHAN",
  	),
  	array(
  		"kode" => "F2",
  		"name" => "PEMBELIAN LAHAN",
  	),
  );



        $this->db->trans_start();
        foreach ($category_help2 as $v)
        {
            $data = [
                'code' => $v['kode'],
                'name' => $v['name'],
                'is_margis' => 1,
                'created_by' => 1,
            ];
            $this->db->insert('category', $data);
            $insert_id = $this->db->insert_id();
            $category_pk[$v['kode']] = $insert_id;
        }

        $specification_helper2 = array(
  	array(
  		"cat_code" => "FA",
  		"spec_code" => "1",
  		"name" => "BEBAN PEMASARAN",
  	),
  	array(
  		"cat_code" => "FB",
  		"spec_code" => "1",
  		"name" => "BIAYA SEKRETARIAT",
  	),
  	array(
  		"cat_code" => "FC",
  		"spec_code" => "1",
  		"name" => "PERBAIKAN & PEMELIHARAAN FAS. KANTOR/BANGUNAN",
  	),
  	array(
  		"cat_code" => "FC",
  		"spec_code" => "2",
  		"name" => "FASILITAS PENUNJANG KANTOR/BANGUNAN",
  	),
  	array(
  		"cat_code" => "FC",
  		"spec_code" => "3",
  		"name" => "PENYUSUTAN FASILITAS KANTOR/BANGUNAN",
  	),
  	array(
  		"cat_code" => "FC",
  		"spec_code" => "4",
  		"name" => "LAIN-LAIN BIAYA FASILITAS KANTOR/BANGUNAN",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "1",
  		"name" => "GAJI/TUNJANGAN/PDP - BTL",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "2",
  		"name" => "UANG LEMBUR & MAKAN LEMBUR - BTL",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "3",
  		"name" => "PREMI DETASIR -BTL",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "4",
  		"name" => "TUNJANGAN & FASILITAS PERUMAHAN - BTL",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "5",
  		"name" => "IURAN PENSIUN HARI TUA - BTL",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "6",
  		"name" => "IURAN ASTEK - BTL",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "7",
  		"name" => "IURAN ASKES - BTL",
  	),
  	array(
  		"cat_code" => "FD",
  		"spec_code" => "8",
  		"name" => "LAIN-LAIN BTL BY. PERSONALIA",
  	),
  	array(
  		"cat_code" => "FE",
  		"spec_code" => "1",
  		"name" => "BEBAN KEUANGAN",
  	),
  	array(
  		"cat_code" => "FE",
  		"spec_code" => "2",
  		"name" => "BEBAN PPh  FINAL",
  	),
  	array(
  		"cat_code" => "FF",
  		"spec_code" => "1",
  		"name" => "BEBAN KENDARAAN",
  	),
  	array(
  		"cat_code" => "FG",
  		"spec_code" => "1",
  		"name" => "BEBAN PENGUJIAN",
  	),
  	array(
  		"cat_code" => "FH",
  		"spec_code" => "1",
  		"name" => "BEBAN UMUM",
  	),
  	array(
  		"cat_code" => "FI",
  		"spec_code" => "1",
  		"name" => "PEMBEBANAN BIAYA DIVISI",
  	),
  	array(
  		"cat_code" => "Z3",
  		"spec_code" => "1",
  		"name" => "BIAYA RISIKO",
  	),
  	array(
  		"cat_code" => "C1",
  		"spec_code" => "1",
  		"name" => "Landclearing",
  	),
  	array(
  		"cat_code" => "C1",
  		"spec_code" => "2",
  		"name" => "Striping",
  	),
  	array(
  		"cat_code" => "C1",
  		"spec_code" => "3",
  		"name" => "Perataan",
  	),
  	array(
  		"cat_code" => "C1",
  		"spec_code" => "4",
  		"name" => "Galian (Manual)",
  	),
  	array(
  		"cat_code" => "C1",
  		"spec_code" => "5",
  		"name" => "Galian Tanah Lumpur",
  	),
  	array(
  		"cat_code" => "C1",
  		"spec_code" => "6",
  		"name" => "Urugan (Manual)",
  	),
  	array(
  		"cat_code" => "C1",
  		"spec_code" => "7",
  		"name" => "Latief S: Skip dulu Pemadatan",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "1",
  		"name" => "Perkerasan Rigid",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "2",
  		"name" => "Perkerasan Fleksibel",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "3",
  		"name" => "Pembesian",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "4",
  		"name" => "Bekisting Kayu",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "5",
  		"name" => "Perancah",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "6",
  		"name" => "Bekisting Baja",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "7",
  		"name" => "Pengecoran Beton",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "8",
  		"name" => "Upah Pekerjaan Baja",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "9",
  		"name" => "Shoring",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "A",
  		"name" => "Pekerjaan Pondasi(Pile, Bored Pile, Pancang Baja)",
  	),
  	array(
  		"cat_code" => "C2",
  		"spec_code" => "B",
  		"name" => "Pekerjaan Beton Pracetak",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "1",
  		"name" => "Pasangan Basah",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "2",
  		"name" => "Pasangan Kering",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "3",
  		"name" => "Pengecatan",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "4",
  		"name" => "Plafond",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "5",
  		"name" => "Penutup Atap",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "6",
  		"name" => "Hardware",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "7",
  		"name" => "Railling/Balustrade",
  	),
  	array(
  		"cat_code" => "C3",
  		"spec_code" => "8",
  		"name" => "Pintu & Jendela",
  	),
  	array(
  		"cat_code" => "C4",
  		"spec_code" => "1",
  		"name" => "Pemipaan",
  	),
  	array(
  		"cat_code" => "C4",
  		"spec_code" => "2",
  		"name" => "Duckting",
  	),
  	array(
  		"cat_code" => "C4",
  		"spec_code" => "3",
  		"name" => "Sanitary",
  	),
  	array(
  		"cat_code" => "C4",
  		"spec_code" => "4",
  		"name" => "Equipment/Peralatan",
  	),
  	array(
  		"cat_code" => "C4",
  		"spec_code" => "5",
  		"name" => "Pengetesan",
  	),
  	array(
  		"cat_code" => "C5",
  		"spec_code" => "1",
  		"name" => "Instalasi",
  	),
  	array(
  		"cat_code" => "C5",
  		"spec_code" => "2",
  		"name" => "Instrumen",
  	),
  	array(
  		"cat_code" => "C7",
  		"spec_code" => "0",
  		"name" => "Mandor",
  	),
  	array(
  		"cat_code" => "C7",
  		"spec_code" => "1",
  		"name" => "Tukang",
  	),
  	array(
  		"cat_code" => "C7",
  		"spec_code" => "2",
  		"name" => "Pembantu Tukang",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "0",
  		"name" => "Papan Nama",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "1",
  		"name" => "Pagar Keliling",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "2",
  		"name" => "Pos Jaga",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "3",
  		"name" => "Kontraktor Keet",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "4",
  		"name" => "Direksi Keet",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "5",
  		"name" => "Kendaran Direksi",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "6",
  		"name" => "Gudang",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "7",
  		"name" => "Barak Pekerja",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "8",
  		"name" => "MCK",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "9",
  		"name" => "Workshop",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "A",
  		"name" => "Upah Pekerjaan Persiapan-Laboratorium",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "B",
  		"name" => "Jalan Kerja",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "C",
  		"name" => "Upah Pekerjaan Persiapan-Rambu Rambu",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "D",
  		"name" => "Listrik & Penerangan Kerja",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "E",
  		"name" => "Air Kerja",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "F",
  		"name" => "Penangkal Petir",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "G",
  		"name" => "Bak Curing",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "H",
  		"name" => "Pembersihan Lokasi",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "I",
  		"name" => "Pembersihan Rutin",
  	),
  	array(
  		"cat_code" => "C8",
  		"spec_code" => "J",
  		"name" => "Pembersihan Akhir",
  	),
  	array(
  		"cat_code" => "C9",
  		"spec_code" => "0",
  		"name" => "Meja",
  	),
  	array(
  		"cat_code" => "C9",
  		"spec_code" => "1",
  		"name" => "Kursi",
  	),
  	array(
  		"cat_code" => "D1",
  		"spec_code" => "1",
  		"name" => "Bahan Bakar",
  	),
  	array(
  		"cat_code" => "D1",
  		"spec_code" => "2",
  		"name" => "Pelumas",
  	),
  	array(
  		"cat_code" => "D1",
  		"spec_code" => "3",
  		"name" => "Operator",
  	),
  	array(
  		"cat_code" => "D1",
  		"spec_code" => "4",
  		"name" => "Gemuk",
  	),
  	array(
  		"cat_code" => "D1",
  		"spec_code" => "5",
  		"name" => "Filter",
  	),
  	array(
  		"cat_code" => "D2",
  		"spec_code" => "1",
  		"name" => "Suku Cadang",
  	),
  	array(
  		"cat_code" => "D2",
  		"spec_code" => "2",
  		"name" => "Mekanik",
  	),
  	array(
  		"cat_code" => "D2",
  		"spec_code" => "3",
  		"name" => "Tools (Peralatan Bantu / Perkakas Mesin)",
  	),
  	array(
  		"cat_code" => "D2",
  		"spec_code" => "4",
  		"name" => "Tools (Peralatan Bantu / Hand tools)",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "1",
  		"name" => "Pemakaian Alat/Milik Sendiri-Peralatan Pekerjaan Tanah",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "2",
  		"name" => "Pemakaian Alat/Milik Sendiri-Peralatan Pemecah/Pengebor/Peledak",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "3",
  		"name" => "Pemakaian Alat/Milik Sendiri-Peralatan Pemancang",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "4",
  		"name" => "Peralatan Distribusi",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "5",
  		"name" => "Peralatan Pengangkat",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "6",
  		"name" => "Peralatan Bengkel/Workshop",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "7",
  		"name" => "Peralatan Pembesian",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "8",
  		"name" => "Peralatan Cetakan",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "9",
  		"name" => "Peralatan Pengaduk",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "A",
  		"name" => "Peralatan Penggerak",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "B",
  		"name" => "End Truck",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "C",
  		"name" => "Internal Vibrator",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "D",
  		"name" => "External Vibrator",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "E",
  		"name" => "Vibrating Table",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "F",
  		"name" => "Peralatan Bantu (Las, Pompa,Perancah,Dll)",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "G",
  		"name" => "Peralalatan Finishing",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "H",
  		"name" => "Peralatan Pengecoran/",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "I",
  		"name" => "Casting Plant",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "J",
  		"name" => "Peralatan Heat Treatment",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "K",
  		"name" => "Peralatan Transportasi",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "L",
  		"name" => "Peralatan Peregang & Penekan",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "M",
  		"name" => "Peralatan Uap/Udara",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "N",
  		"name" => "Peralatan Tenaga",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "O",
  		"name" => "Peralatan Pengukuran",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "P",
  		"name" => "Peralatan CAD/CAM.",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "Q",
  		"name" => "Peralatan Pengetesan",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "R",
  		"name" => "Machine/Power Tools",
  	),
  	array(
  		"cat_code" => "D3",
  		"spec_code" => "S",
  		"name" => "Engine / Motor Bakar",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "1",
  		"name" => "Fasilitas Dan Utilitas Proyek-Papan Nama",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "2",
  		"name" => "Fasilitas Dan Utilitas Proyek-Pagar Keliling",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "3",
  		"name" => "Fasilitas Dan Utilitas Proyek-Pos Jaga",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "4",
  		"name" => "Fasilitas Dan Utilitas Proyek-Kontraktor Keet",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "5",
  		"name" => "Fasilitas Dan Utilitas Proyek-Direksi Keet",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "6",
  		"name" => "Fasilitas Dan Utilitas Proyek-Kendaraan Direksi",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "7",
  		"name" => "Fasilitas Dan Utilitas Proyek-Gudang",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "8",
  		"name" => "Fasilitas Dan Utilitas Proyek-Barak Pekerja",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "9",
  		"name" => "MCK",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "A",
  		"name" => "Workshop",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "B",
  		"name" => "Fasilitas Dan Utilitas Proyek-Laboratorium",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "C",
  		"name" => "Jalan Kerja",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "D",
  		"name" => "Fasilitas Dan Utilitas Proyek-Rambu Rambu",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "E",
  		"name" => "Listrik & Penerangan Kerja",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "F",
  		"name" => "Air Kerja",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "G",
  		"name" => "Penangkal Petir",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "H",
  		"name" => "Pembuatan Bak Curing",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "I",
  		"name" => "Sarana Kebersihan",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "J",
  		"name" => "Detour",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "K",
  		"name" => "Mobilisasi Dan Demobilisasi",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "L",
  		"name" => "Fasilitas-Pekerjaan Persiapan-Pembersihan Lokasi",
  	),
  	array(
  		"cat_code" => "E1",
  		"spec_code" => "M",
  		"name" => "Fasilitas-Pekerjaan Persiapan-Sarana Penunjang",
  	),
  	array(
  		"cat_code" => "E2",
  		"spec_code" => "1",
  		"name" => "Pekerjaan Sub Structure-Pondasi",
  	),
  	array(
  		"cat_code" => "E2",
  		"spec_code" => "2",
  		"name" => "Pekerjaan Sub Struktur-Pekerjaan Tanah",
  	),
  	array(
  		"cat_code" => "E2",
  		"spec_code" => "3",
  		"name" => "Pekerjaan Sub Structure-Dewatering",
  	),
  	array(
  		"cat_code" => "E2",
  		"spec_code" => "4",
  		"name" => "Waterstop",
  	),
  	array(
  		"cat_code" => "E2",
  		"spec_code" => "5",
  		"name" => "Termit Control & Pest Control",
  	),
  	array(
  		"cat_code" => "E2",
  		"spec_code" => "6",
  		"name" => "Pekerjaan Sub Structure-Pembesian",
  	),
  	array(
  		"cat_code" => "E2",
  		"spec_code" => "7",
  		"name" => "Pekerjaan Sub Structure-Pembetonan",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "1",
  		"name" => "Pekerjaan Struktur-Jalan",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "2",
  		"name" => "Pekerjaan Struktur-Jalan Kereta Api",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "3",
  		"name" => "Pekerjaan Struktur-Konstruksi Beton",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "4",
  		"name" => "Pekerjaan Struktur-Konstruksi Baja",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "5",
  		"name" => "Pekerjaan Struktur-Konstruksi Kayu",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "6",
  		"name" => "Pekerjaan Struktur-Konstruksi Perkerasan",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "7",
  		"name" => "Pekerjaan Struktur - Struktur Tanah",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "8",
  		"name" => "Pekerjaan Struktur-Penahan Tanah",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "9",
  		"name" => "Pekerjaan Struktur-Bekisting",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "A",
  		"name" => "Pekerjaan Struktur-Penahan Struktur Beton",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "B",
  		"name" => "Pekerjaan Struktur-Erection/Lounching",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "C",
  		"name" => "Pekerjaan Struktur-Drainage",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "D",
  		"name" => "Pekerjaan Struktur-Dermaga",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "E",
  		"name" => "Pekerjaan Struktur-Prestress",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "F",
  		"name" => "Jacking System",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "G",
  		"name" => "Struktur Atap (Roofing)",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "H",
  		"name" => "Pekerjaan Struktur-Pembesian (Reinforcing Steel)",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "I",
  		"name" => "Concrete Repair (Perbaikan Beton)",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "J",
  		"name" => "Grouting Ø >65/70 mm",
  	),
  	array(
  		"cat_code" => "E3",
  		"spec_code" => "K",
  		"name" => "Latief S: Pending dulu Pekerjaan Struktur-Poststress",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "1",
  		"name" => "Dinding",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "2",
  		"name" => "Kulit Luar",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "3",
  		"name" => "Space Frame",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "4",
  		"name" => "Plafon Dan Partisi",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "5",
  		"name" => "Furniture",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "6",
  		"name" => "Pintu, Jendela Dan Railing",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "7",
  		"name" => "Penutup Dinding",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "8",
  		"name" => "Penutup Lantai",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "9",
  		"name" => "Marmer Dan Granit",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "A",
  		"name" => "Keramik",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "B",
  		"name" => "Raised Floor",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "C",
  		"name" => "Lantai Kayu Interior",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "D",
  		"name" => "Waterproofing",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "E",
  		"name" => "Floor Hardener",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "F",
  		"name" => "Pengecatan",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "G",
  		"name" => "Stainless Steel",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "H",
  		"name" => "Wallpaper , VINYL",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "I",
  		"name" => "Lanscape/Halaman",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "J",
  		"name" => "Cleaning Services",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "K",
  		"name" => "Jalan/Jembatan/Bang.Air",
  	),
  	array(
  		"cat_code" => "E4",
  		"spec_code" => "L",
  		"name" => "Material Bantu Finishing(Beton)",
  	),
  	array(
  		"cat_code" => "E5",
  		"spec_code" => "1",
  		"name" => "Build In Furniture",
  	),
  	array(
  		"cat_code" => "E5",
  		"spec_code" => "2",
  		"name" => "Loose Furniture",
  	),
  	array(
  		"cat_code" => "E5",
  		"spec_code" => "3",
  		"name" => "Pekerjaan Hiasan(Art Works)",
  	),
  	array(
  		"cat_code" => "E5",
  		"spec_code" => "4",
  		"name" => "Sanitair",
  	),
  	array(
  		"cat_code" => "E6",
  		"spec_code" => "0",
  		"name" => "",
  	),
  	array(
  		"cat_code" => "E6",
  		"spec_code" => "1",
  		"name" => "Telpon",
  	),
  	array(
  		"cat_code" => "E6",
  		"spec_code" => "2",
  		"name" => "Sound Sistem",
  	),
  	array(
  		"cat_code" => "E6",
  		"spec_code" => "3",
  		"name" => "Traffic Light Dan Signage",
  	),
  	array(
  		"cat_code" => "E6",
  		"spec_code" => "4",
  		"name" => "Public Address & General Address",
  	),
  	array(
  		"cat_code" => "E7",
  		"spec_code" => "0",
  		"name" => "",
  	),
  	array(
  		"cat_code" => "E7",
  		"spec_code" => "1",
  		"name" => "Access Control",
  	),
  	array(
  		"cat_code" => "E7",
  		"spec_code" => "2",
  		"name" => "Building Automatic System",
  	),
  	array(
  		"cat_code" => "E7",
  		"spec_code" => "3",
  		"name" => "CCTV/MATV",
  	),
  	array(
  		"cat_code" => "E7",
  		"spec_code" => "4",
  		"name" => "Analyzer",
  	),
  	array(
  		"cat_code" => "E7",
  		"spec_code" => "5",
  		"name" => "Plant Control System",
  	),
  	array(
  		"cat_code" => "E8",
  		"spec_code" => "1",
  		"name" => "Fire Alarm System",
  	),
  	array(
  		"cat_code" => "E8",
  		"spec_code" => "2",
  		"name" => "Fire & Gas Detector",
  	),
  	array(
  		"cat_code" => "E8",
  		"spec_code" => "3",
  		"name" => "Foam System",
  	),
  	array(
  		"cat_code" => "E8",
  		"spec_code" => "4",
  		"name" => "Hydrant System",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "1",
  		"name" => "Pekerjaan Elektrikal-Instalasi",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "2",
  		"name" => "Pekerjaan Elektrikal-PJU",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "3",
  		"name" => "Pekerjaan Elektrikal-Panel Listrik",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "4",
  		"name" => "Pekerjaan Elektrikal-Gardu Induk",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "5",
  		"name" => "Pekerjaan Elektrikal-Penarikan Kabel",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "6",
  		"name" => "Pekerjaan Elektrikal-Lighting",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "7",
  		"name" => "Pekerjaan Elektrikal-Emergency Lamp",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "8",
  		"name" => "Pekerjaan Elektrikal-Socket Outlet",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "9",
  		"name" => "Pekerjaan Elektrikal-Fire Alarm System",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "A",
  		"name" => "Pekerjaan Elektrikal-Public Address System",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "B",
  		"name" => "Pekerjaan Mekanikal-Exhaust Fan",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "C",
  		"name" => "Pekerjaan Mekanikal-Ceiling Fan",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "D",
  		"name" => "Pekerjaan Mekanikal-Air Conditioning Split",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "E",
  		"name" => "Pekerjaan Mekanikal & Elektrikal - Air Intake Duct And Grill",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "F",
  		"name" => "Pekerjaan Elektrikal-Lightning Protection / Penangkal Petir",
  	),
  	array(
  		"cat_code" => "E9",
  		"spec_code" => "G",
  		"name" => "Pekerjaan Elektrikal-Kwh Meter",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "1",
  		"name" => "Tata Udara",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "2",
  		"name" => "Pekerjaan Pemipaan",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "3",
  		"name" => "Transportasi Vertikal",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "4",
  		"name" => "Transportasi Horizontal",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "5",
  		"name" => "Mekanikal Erection",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "6",
  		"name" => "Gantry",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "7",
  		"name" => "WTP/STP",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "8",
  		"name" => "Sumur Dalam",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "9",
  		"name" => "Swimming Pools System",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "A",
  		"name" => "Intalasi Gas",
  	),
  	array(
  		"cat_code" => "EA",
  		"spec_code" => "B",
  		"name" => "Instalasi Pompa-Pompa",
  	),
  	array(
  		"cat_code" => "EB",
  		"spec_code" => "1",
  		"name" => "Jasa Logistik-Angkutan Darat",
  	),
  	array(
  		"cat_code" => "EB",
  		"spec_code" => "2",
  		"name" => "Jasa Logistik-Angkutan Laut",
  	),
  	array(
  		"cat_code" => "EB",
  		"spec_code" => "3",
  		"name" => "Jasa Logistik-Angkutan Udara",
  	),
  	array(
  		"cat_code" => "EB",
  		"spec_code" => "4",
  		"name" => "Gudang",
  	),
  	array(
  		"cat_code" => "EB",
  		"spec_code" => "5",
  		"name" => "Handling And Inklaring",
  	),
  	array(
  		"cat_code" => "EB",
  		"spec_code" => "6",
  		"name" => "Jasa Logistik-Angkutan Multi Moda",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "1",
  		"name" => "Alat Berat",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "2",
  		"name" => "Bekisting",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "3",
  		"name" => "Alat Bantu",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "4",
  		"name" => "Jasa Persewaan-Transportasi",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "5",
  		"name" => "Plant",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "6",
  		"name" => "Alat Angkat",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "7",
  		"name" => "Alat Ukur",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "8",
  		"name" => "Genset",
  	),
  	array(
  		"cat_code" => "EC",
  		"spec_code" => "9",
  		"name" => "Shoring",
  	),
  	array(
  		"cat_code" => "ED",
  		"spec_code" => "1",
  		"name" => "Jasaperbaikan Alat Berat",
  	),
  	array(
  		"cat_code" => "ED",
  		"spec_code" => "2",
  		"name" => "Alat Ukur",
  	),
  	array(
  		"cat_code" => "ED",
  		"spec_code" => "3",
  		"name" => "Alat Penunjang",
  	),
  	array(
  		"cat_code" => "ED",
  		"spec_code" => "4",
  		"name" => "Alat Bantu",
  	),
  	array(
  		"cat_code" => "ED",
  		"spec_code" => "5",
  		"name" => "Bekisting",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "1",
  		"name" => "Design Engineering",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "2",
  		"name" => "Test & Comisioning",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "3",
  		"name" => "Survey & Pengukuran",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "4",
  		"name" => "Feasibility Study",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "5",
  		"name" => "Kajian AMDAL",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "6",
  		"name" => "Investigasi",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "7",
  		"name" => "Pile Load Test",
  	),
  	array(
  		"cat_code" => "EE",
  		"spec_code" => "8",
  		"name" => "Pile Integrity Test",
  	),
  	array(
  		"cat_code" => "EG",
  		"spec_code" => "1",
  		"name" => "Asuransi-Car",
  	),
  	array(
  		"cat_code" => "EG",
  		"spec_code" => "2",
  		"name" => "Asuransi Kesehatan",
  	),
  	array(
  		"cat_code" => "EG",
  		"spec_code" => "3",
  		"name" => "Asuransi Total Lost Only (TLO)",
  	),
  	array(
  		"cat_code" => "F1",
  		"spec_code" => "1",
  		"name" => "Sewa Lahan Milik Umum",
  	),
  	array(
  		"cat_code" => "F1",
  		"spec_code" => "2",
  		"name" => "Sewa Lahan Milik Instansi Pemerintah",
  	),
  	array(
  		"cat_code" => "F1",
  		"spec_code" => "3",
  		"name" => "Sewa Lahan Milik Instansi Swasta",
  	),
  	array(
  		"cat_code" => "F2",
  		"spec_code" => "1",
  		"name" => "Latief S: Pembelian lahan dilaksanakan perorangan Pembelian Lahan Milik Umum",
  	),
  	array(
  		"cat_code" => "F2",
  		"spec_code" => "2",
  		"name" => "Pembelian Lahan Milik Instansi Pemerintah",
  	),
  	array(
  		"cat_code" => "F2",
  		"spec_code" => "3",
  		"name" => "Pembelian Lahan Milik Instansi Swasta",
  	),
  );


        $data_insert = [];
        foreach ($specification_helper2 as $v)
        {
            $data = [
                'code' => $v['spec_code'],
                'name' => $v['name'],
                'category_id' => $category_pk[$v['cat_code']],
                'created_by' => 1
            ];
            $data_insert[] = $data;
        }
        //var_dump($data_insert);
        $this->db->insert_batch('specification', $data_insert);

        //echo '<pre>';
        //print_r($this->db->queries);
        //echo '</pre>';
        $this->db->trans_complete();



    }

    public function down()
    {

    }
}
