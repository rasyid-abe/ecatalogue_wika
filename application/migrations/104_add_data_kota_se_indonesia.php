<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_data_kota_se_indonesia extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        $t_kab = array(
    	array(
    		"id" => "1101",
    		"name" => "KABUPATEN SIMEULUE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1102",
    		"name" => "KABUPATEN ACEH SINGKIL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1103",
    		"name" => "KABUPATEN ACEH SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1104",
    		"name" => "KABUPATEN ACEH TENGGARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1105",
    		"name" => "KABUPATEN ACEH TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1106",
    		"name" => "KABUPATEN ACEH TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1107",
    		"name" => "KABUPATEN ACEH BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1108",
    		"name" => "KABUPATEN ACEH BESAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1109",
    		"name" => "KABUPATEN PIDIE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1110",
    		"name" => "KABUPATEN BIREUEN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1111",
    		"name" => "KABUPATEN ACEH UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1112",
    		"name" => "KABUPATEN ACEH BARAT DAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1113",
    		"name" => "KABUPATEN GAYO LUES",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1114",
    		"name" => "KABUPATEN ACEH TAMIANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1115",
    		"name" => "KABUPATEN NAGAN RAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1116",
    		"name" => "KABUPATEN ACEH JAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1117",
    		"name" => "KABUPATEN BENER MERIAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1118",
    		"name" => "KABUPATEN PIDIE JAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1171",
    		"name" => "KOTA BANDA ACEH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1172",
    		"name" => "KOTA SABANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1173",
    		"name" => "KOTA LANGSA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1174",
    		"name" => "KOTA LHOKSEUMAWE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1175",
    		"name" => "KOTA SUBULUSSALAM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1201",
    		"name" => "KABUPATEN NIAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1202",
    		"name" => "KABUPATEN MANDAILING NATAL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1203",
    		"name" => "KABUPATEN TAPANULI SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1204",
    		"name" => "KABUPATEN TAPANULI TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1205",
    		"name" => "KABUPATEN TAPANULI UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1206",
    		"name" => "KABUPATEN TOBA SAMOSIR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1207",
    		"name" => "KABUPATEN LABUHAN BATU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1208",
    		"name" => "KABUPATEN ASAHAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1209",
    		"name" => "KABUPATEN SIMALUNGUN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1210",
    		"name" => "KABUPATEN DAIRI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1211",
    		"name" => "KABUPATEN KARO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1212",
    		"name" => "KABUPATEN DELI SERDANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1213",
    		"name" => "KABUPATEN LANGKAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1214",
    		"name" => "KABUPATEN NIAS SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1215",
    		"name" => "KABUPATEN HUMBANG HASUNDUTAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1216",
    		"name" => "KABUPATEN PAKPAK BHARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1217",
    		"name" => "KABUPATEN SAMOSIR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1218",
    		"name" => "KABUPATEN SERDANG BEDAGAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1219",
    		"name" => "KABUPATEN BATU BARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1220",
    		"name" => "KABUPATEN PADANG LAWAS UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1221",
    		"name" => "KABUPATEN PADANG LAWAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1222",
    		"name" => "KABUPATEN LABUHAN BATU SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1223",
    		"name" => "KABUPATEN LABUHAN BATU UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1224",
    		"name" => "KABUPATEN NIAS UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1225",
    		"name" => "KABUPATEN NIAS BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1226",
    		"name" => "KABUPATEN MANDAILING",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1271",
    		"name" => "KOTA SIBOLGA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1272",
    		"name" => "KOTA TANJUNG BALAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1273",
    		"name" => "KOTA PEMATANG SIANTAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1274",
    		"name" => "KOTA TEBING TINGGI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1275",
    		"name" => "KOTA MEDAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1276",
    		"name" => "KOTA BINJAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1277",
    		"name" => "KOTA PADANGSIDIMPUAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1278",
    		"name" => "KOTA GUNUNGSITOLI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1301",
    		"name" => "KABUPATEN KEPULAUAN MENTAWAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1302",
    		"name" => "KABUPATEN PESISIR SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1303",
    		"name" => "KABUPATEN SOLOK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1304",
    		"name" => "KABUPATEN SIJUNJUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1305",
    		"name" => "KABUPATEN TANAH DATAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1306",
    		"name" => "KABUPATEN PADANG PARIAMAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1307",
    		"name" => "KABUPATEN AGAM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1308",
    		"name" => "KABUPATEN LIMA PULUH KOTA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1309",
    		"name" => "KABUPATEN PASAMAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1310",
    		"name" => "KABUPATEN SOLOK SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1311",
    		"name" => "KABUPATEN DHARMASRAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1312",
    		"name" => "KABUPATEN PASAMAN BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1371",
    		"name" => "KOTA PADANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1372",
    		"name" => "KOTA SOLOK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1373",
    		"name" => "KOTA SAWAH LUNTO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1374",
    		"name" => "KOTA PADANG PANJANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1375",
    		"name" => "KOTA BUKITTINGGI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1376",
    		"name" => "KOTA PAYAKUMBUH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1377",
    		"name" => "KOTA PARIAMAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1401",
    		"name" => "KABUPATEN KUANTAN SINGINGI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1402",
    		"name" => "KABUPATEN INDRAGIRI HULU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1403",
    		"name" => "KABUPATEN INDRAGIRI HILIR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1404",
    		"name" => "KABUPATEN PELALAWAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1405",
    		"name" => "KABUPATEN S I A K",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1406",
    		"name" => "KABUPATEN KAMPAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1407",
    		"name" => "KABUPATEN ROKAN HULU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1408",
    		"name" => "KABUPATEN BENGKALIS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1409",
    		"name" => "KABUPATEN ROKAN HILIR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1410",
    		"name" => "KABUPATEN KEPULAUAN MERANTI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1471",
    		"name" => "KOTA PEKANBARU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1473",
    		"name" => "KOTA D U M A I",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1501",
    		"name" => "KABUPATEN KERINCI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1502",
    		"name" => "KABUPATEN MERANGIN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1503",
    		"name" => "KABUPATEN SAROLANGUN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1504",
    		"name" => "KABUPATEN BATANG HARI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1505",
    		"name" => "KABUPATEN MUARO JAMBI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1506",
    		"name" => "KABUPATEN TANJUNG JABUNG TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1507",
    		"name" => "KABUPATEN TANJUNG JABUNG BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1508",
    		"name" => "KABUPATEN TEBO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1509",
    		"name" => "KABUPATEN BUNGO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1571",
    		"name" => "KOTA JAMBI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1572",
    		"name" => "KOTA SUNGAI PENUH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1601",
    		"name" => "KABUPATEN OGAN KOMERING ULU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1602",
    		"name" => "KABUPATEN OGAN KOMERING ILIR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1603",
    		"name" => "KABUPATEN MUARA ENIM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1604",
    		"name" => "KABUPATEN LAHAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1605",
    		"name" => "KABUPATEN MUSI RAWAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1606",
    		"name" => "KABUPATEN MUSI BANYUASIN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1607",
    		"name" => "KABUPATEN BANYU ASIN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1608",
    		"name" => "KABUPATEN OGAN KOMERING ULU SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1609",
    		"name" => "KABUPATEN OGAN KOMERING ULU TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1610",
    		"name" => "KABUPATEN OGAN ILIR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1611",
    		"name" => "KABUPATEN EMPAT LAWANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1612",
    		"name" => "KABUPATEN PENUKAL ABAB LEMATANG ILIR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1613",
    		"name" => "KABUPATEN MUSI RAWAS UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1671",
    		"name" => "KOTA PALEMBANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1672",
    		"name" => "KOTA PRABUMULIH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1673",
    		"name" => "KOTA PAGAR ALAM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1674",
    		"name" => "KOTA LUBUKLINGGAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1701",
    		"name" => "KABUPATEN BENGKULU SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1702",
    		"name" => "KABUPATEN REJANG LEBONG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1703",
    		"name" => "KABUPATEN BENGKULU UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1704",
    		"name" => "KABUPATEN KAUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1705",
    		"name" => "KABUPATEN SELUMA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1706",
    		"name" => "KABUPATEN MUKOMUKO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1707",
    		"name" => "KABUPATEN LEBONG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1708",
    		"name" => "KABUPATEN KEPAHIANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1709",
    		"name" => "KABUPATEN BENGKULU TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1771",
    		"name" => "KOTA BENGKULU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1801",
    		"name" => "KABUPATEN LAMPUNG BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1802",
    		"name" => "KABUPATEN TANGGAMUS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1803",
    		"name" => "KABUPATEN LAMPUNG SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1804",
    		"name" => "KABUPATEN LAMPUNG TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1805",
    		"name" => "KABUPATEN LAMPUNG TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1806",
    		"name" => "KABUPATEN LAMPUNG UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1807",
    		"name" => "KABUPATEN WAY KANAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1808",
    		"name" => "KABUPATEN TULANGBAWANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1809",
    		"name" => "KABUPATEN PESAWARAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1810",
    		"name" => "KABUPATEN PRINGSEWU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1811",
    		"name" => "KABUPATEN MESUJI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1812",
    		"name" => "KABUPATEN TULANG BAWANG BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1813",
    		"name" => "KABUPATEN PESISIR BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1871",
    		"name" => "KOTA BANDAR LAMPUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1872",
    		"name" => "KOTA METRO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1901",
    		"name" => "KABUPATEN BANGKA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1902",
    		"name" => "KABUPATEN BELITUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1903",
    		"name" => "KABUPATEN BANGKA BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1904",
    		"name" => "KABUPATEN BANGKA TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1905",
    		"name" => "KABUPATEN BANGKA SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1906",
    		"name" => "KABUPATEN BELITUNG TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1971",
    		"name" => "KOTA PANGKAL PINANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "1972",
    		"name" => "KOTA TANJUNG PANDAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "2101",
    		"name" => "KABUPATEN KARIMUN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "2102",
    		"name" => "KABUPATEN BINTAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "2103",
    		"name" => "KABUPATEN NATUNA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "2104",
    		"name" => "KABUPATEN LINGGA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "2105",
    		"name" => "KABUPATEN KEPULAUAN ANAMBAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "2171",
    		"name" => "KOTA BATAM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "2172",
    		"name" => "KOTA TANJUNG PINANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3101",
    		"name" => "KABUPATEN KEPULAUAN SERIBU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3171",
    		"name" => "KOTA JAKARTA SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3172",
    		"name" => "KOTA JAKARTA TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3173",
    		"name" => "KOTA JAKARTA PUSAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3174",
    		"name" => "KOTA JAKARTA BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3175",
    		"name" => "KOTA JAKARTA UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3201",
    		"name" => "KABUPATEN BOGOR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3202",
    		"name" => "KABUPATEN SUKABUMI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3203",
    		"name" => "KABUPATEN CIANJUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3204",
    		"name" => "KABUPATEN BANDUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3205",
    		"name" => "KABUPATEN GARUT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3206",
    		"name" => "KABUPATEN TASIKMALAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3207",
    		"name" => "KABUPATEN CIAMIS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3208",
    		"name" => "KABUPATEN KUNINGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3209",
    		"name" => "KABUPATEN CIREBON",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3210",
    		"name" => "KABUPATEN MAJALENGKA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3211",
    		"name" => "KABUPATEN SUMEDANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3212",
    		"name" => "KABUPATEN INDRAMAYU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3213",
    		"name" => "KABUPATEN SUBANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3214",
    		"name" => "KABUPATEN PURWAKARTA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3215",
    		"name" => "KABUPATEN KARAWANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3216",
    		"name" => "KABUPATEN BEKASI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3217",
    		"name" => "KABUPATEN BANDUNG BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3218",
    		"name" => "KABUPATEN PANGANDARAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3271",
    		"name" => "KOTA BOGOR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3272",
    		"name" => "KOTA SUKABUMI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3273",
    		"name" => "KOTA BANDUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3274",
    		"name" => "KOTA CIREBON",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3275",
    		"name" => "KOTA BEKASI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3276",
    		"name" => "KOTA DEPOK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3277",
    		"name" => "KOTA CIMAHI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3278",
    		"name" => "KOTA TASIKMALAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3279",
    		"name" => "KOTA BANJAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3301",
    		"name" => "KABUPATEN CILACAP",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3302",
    		"name" => "KABUPATEN BANYUMAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3303",
    		"name" => "KABUPATEN PURBALINGGA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3304",
    		"name" => "KABUPATEN BANJARNEGARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3305",
    		"name" => "KABUPATEN KEBUMEN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3306",
    		"name" => "KABUPATEN PURWOREJO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3307",
    		"name" => "KABUPATEN WONOSOBO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3308",
    		"name" => "KABUPATEN MAGELANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3309",
    		"name" => "KABUPATEN BOYOLALI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3310",
    		"name" => "KABUPATEN KLATEN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3311",
    		"name" => "KABUPATEN SUKOHARJO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3312",
    		"name" => "KABUPATEN WONOGIRI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3313",
    		"name" => "KABUPATEN KARANGANYAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3314",
    		"name" => "KABUPATEN SRAGEN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3315",
    		"name" => "KABUPATEN GROBOGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3316",
    		"name" => "KABUPATEN BLORA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3317",
    		"name" => "KABUPATEN REMBANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3318",
    		"name" => "KABUPATEN PATI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3319",
    		"name" => "KABUPATEN KUDUS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3320",
    		"name" => "KABUPATEN JEPARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3321",
    		"name" => "KABUPATEN DEMAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3322",
    		"name" => "KABUPATEN SEMARANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3323",
    		"name" => "KABUPATEN TEMANGGUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3324",
    		"name" => "KABUPATEN KENDAL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3325",
    		"name" => "KABUPATEN BATANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3326",
    		"name" => "KABUPATEN PEKALONGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3327",
    		"name" => "KABUPATEN PEMALANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3328",
    		"name" => "KABUPATEN TEGAL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3329",
    		"name" => "KABUPATEN BREBES",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3371",
    		"name" => "KOTA MAGELANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3372",
    		"name" => "KOTA SURAKARTA (SOLO)",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3373",
    		"name" => "KOTA SALATIGA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3374",
    		"name" => "KOTA SEMARANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3375",
    		"name" => "KOTA PEKALONGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3376",
    		"name" => "KOTA TEGAL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3401",
    		"name" => "KABUPATEN KULON PROGO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3402",
    		"name" => "KABUPATEN BANTUL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3403",
    		"name" => "KABUPATEN GUNUNG KIDUL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3404",
    		"name" => "KABUPATEN SLEMAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3471",
    		"name" => "KOTA YOGYAKARTA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3501",
    		"name" => "KABUPATEN PACITAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3502",
    		"name" => "KABUPATEN PONOROGO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3503",
    		"name" => "KABUPATEN TRENGGALEK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3504",
    		"name" => "KABUPATEN TULUNGAGUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3505",
    		"name" => "KABUPATEN BLITAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3506",
    		"name" => "KABUPATEN KEDIRI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3507",
    		"name" => "KABUPATEN MALANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3508",
    		"name" => "KABUPATEN LUMAJANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3509",
    		"name" => "KABUPATEN JEMBER",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3510",
    		"name" => "KABUPATEN BANYUWANGI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3511",
    		"name" => "KABUPATEN BONDOWOSO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3512",
    		"name" => "KABUPATEN SITUBONDO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3513",
    		"name" => "KABUPATEN PROBOLINGGO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3514",
    		"name" => "KABUPATEN PASURUAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3515",
    		"name" => "KABUPATEN SIDOARJO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3516",
    		"name" => "KABUPATEN MOJOKERTO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3517",
    		"name" => "KABUPATEN JOMBANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3518",
    		"name" => "KABUPATEN NGANJUK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3519",
    		"name" => "KABUPATEN MADIUN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3520",
    		"name" => "KABUPATEN MAGETAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3521",
    		"name" => "KABUPATEN NGAWI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3522",
    		"name" => "KABUPATEN BOJONEGORO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3523",
    		"name" => "KABUPATEN TUBAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3524",
    		"name" => "KABUPATEN LAMONGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3525",
    		"name" => "KABUPATEN GRESIK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3526",
    		"name" => "KABUPATEN BANGKALAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3527",
    		"name" => "KABUPATEN SAMPANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3528",
    		"name" => "KABUPATEN PAMEKASAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3529",
    		"name" => "KABUPATEN SUMENEP",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3571",
    		"name" => "KOTA KEDIRI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3572",
    		"name" => "KOTA BLITAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3573",
    		"name" => "KOTA MALANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3574",
    		"name" => "KOTA PROBOLINGGO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3575",
    		"name" => "KOTA PASURUAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3576",
    		"name" => "KOTA MOJOKERTO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3577",
    		"name" => "KOTA MADIUN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3578",
    		"name" => "KOTA SURABAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3579",
    		"name" => "KOTA BATU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3580",
    		"name" => "KOTA BOJONEGORO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3601",
    		"name" => "KABUPATEN PANDEGLANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3602",
    		"name" => "KABUPATEN LEBAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3603",
    		"name" => "KABUPATEN TANGERANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3604",
    		"name" => "KABUPATEN SERANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3671",
    		"name" => "KOTA TANGERANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3672",
    		"name" => "KOTA CILEGON",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3673",
    		"name" => "KOTA SERANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "3674",
    		"name" => "KOTA TANGERANG SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5101",
    		"name" => "KABUPATEN JEMBRANA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5102",
    		"name" => "KABUPATEN TABANAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5103",
    		"name" => "KABUPATEN BADUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5104",
    		"name" => "KABUPATEN GIANYAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5105",
    		"name" => "KABUPATEN KLUNGKUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5106",
    		"name" => "KABUPATEN BANGLI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5107",
    		"name" => "KABUPATEN KARANG ASEM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5108",
    		"name" => "KABUPATEN BULELENG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5171",
    		"name" => "KOTA DENPASAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5201",
    		"name" => "KABUPATEN LOMBOK BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5202",
    		"name" => "KABUPATEN LOMBOK TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5203",
    		"name" => "KABUPATEN LOMBOK TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5204",
    		"name" => "KABUPATEN SUMBAWA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5205",
    		"name" => "KABUPATEN DOMPU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5206",
    		"name" => "KABUPATEN BIMA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5207",
    		"name" => "KABUPATEN SUMBAWA BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5208",
    		"name" => "KABUPATEN LOMBOK UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5271",
    		"name" => "KOTA MATARAM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5272",
    		"name" => "KOTA BIMA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5301",
    		"name" => "KABUPATEN SUMBA BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5302",
    		"name" => "KABUPATEN SUMBA TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5303",
    		"name" => "KABUPATEN KUPANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5304",
    		"name" => "KABUPATEN TIMOR TENGAH SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5305",
    		"name" => "KABUPATEN TIMOR TENGAH UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5306",
    		"name" => "KABUPATEN BELU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5307",
    		"name" => "KABUPATEN ALOR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5308",
    		"name" => "KABUPATEN LEMBATA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5309",
    		"name" => "KABUPATEN FLORES TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5310",
    		"name" => "KABUPATEN SIKKA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5311",
    		"name" => "KABUPATEN ENDE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5312",
    		"name" => "KABUPATEN NGADA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5313",
    		"name" => "KABUPATEN MANGGARAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5314",
    		"name" => "KABUPATEN ROTE NDAO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5315",
    		"name" => "KABUPATEN MANGGARAI BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5316",
    		"name" => "KABUPATEN SUMBA TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5317",
    		"name" => "KABUPATEN SUMBA BARAT DAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5318",
    		"name" => "KABUPATEN NAGEKEO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5319",
    		"name" => "KABUPATEN MANGGARAI TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5320",
    		"name" => "KABUPATEN SABU RAIJUA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5321",
    		"name" => "KABUPATEN MALAKA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "5371",
    		"name" => "KOTA KUPANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6101",
    		"name" => "KABUPATEN SAMBAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6102",
    		"name" => "KABUPATEN BENGKAYANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6103",
    		"name" => "KABUPATEN LANDAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6104",
    		"name" => "KABUPATEN MEMPAWAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6105",
    		"name" => "KABUPATEN SANGGAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6106",
    		"name" => "KABUPATEN KETAPANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6107",
    		"name" => "KABUPATEN SINTANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6108",
    		"name" => "KABUPATEN KAPUAS HULU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6109",
    		"name" => "KABUPATEN SEKADAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6110",
    		"name" => "KABUPATEN MELAWI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6111",
    		"name" => "KABUPATEN KAYONG UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6112",
    		"name" => "KABUPATEN KUBU RAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6171",
    		"name" => "KOTA PONTIANAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6172",
    		"name" => "KOTA SINGKAWANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6201",
    		"name" => "KABUPATEN KOTAWARINGIN BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6202",
    		"name" => "KABUPATEN KOTAWARINGIN TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6203",
    		"name" => "KABUPATEN KAPUAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6204",
    		"name" => "KABUPATEN BARITO SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6205",
    		"name" => "KABUPATEN BARITO UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6206",
    		"name" => "KABUPATEN SUKAMARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6207",
    		"name" => "KABUPATEN LAMANDAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6208",
    		"name" => "KABUPATEN SERUYAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6209",
    		"name" => "KABUPATEN KATINGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6210",
    		"name" => "KABUPATEN PULANG PISAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6211",
    		"name" => "KABUPATEN GUNUNG MAS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6212",
    		"name" => "KABUPATEN BARITO TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6213",
    		"name" => "KABUPATEN MURUNG RAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6271",
    		"name" => "KOTA PALANGKA RAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6301",
    		"name" => "KABUPATEN TANAH LAUT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6302",
    		"name" => "KABUPATEN KOTA BARU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6303",
    		"name" => "KABUPATEN BANJAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6304",
    		"name" => "KABUPATEN BARITO KUALA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6305",
    		"name" => "KABUPATEN TAPIN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6306",
    		"name" => "KABUPATEN HULU SUNGAI SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6307",
    		"name" => "KABUPATEN HULU SUNGAI TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6308",
    		"name" => "KABUPATEN HULU SUNGAI UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6309",
    		"name" => "KABUPATEN TABALONG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6310",
    		"name" => "KABUPATEN TANAH BUMBU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6311",
    		"name" => "KABUPATEN BALANGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6371",
    		"name" => "KOTA BANJARMASIN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6372",
    		"name" => "KOTA BANJAR BARU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6401",
    		"name" => "KABUPATEN PASER",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6402",
    		"name" => "KABUPATEN KUTAI BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6403",
    		"name" => "KABUPATEN KUTAI KARTANEGARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6404",
    		"name" => "KABUPATEN KUTAI TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6405",
    		"name" => "KABUPATEN BERAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6409",
    		"name" => "KABUPATEN PENAJAM PASER UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6411",
    		"name" => "KABUPATEN MAHAKAM HULU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6471",
    		"name" => "KOTA BALIKPAPAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6472",
    		"name" => "KOTA SAMARINDA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6474",
    		"name" => "KOTA BONTANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6501",
    		"name" => "KABUPATEN MALINAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6502",
    		"name" => "KABUPATEN BULUNGAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6503",
    		"name" => "KABUPATEN TANA TIDUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6504",
    		"name" => "KABUPATEN NUNUKAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "6571",
    		"name" => "KOTA TARAKAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7101",
    		"name" => "KABUPATEN BOLAANG MONGONDOW",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7102",
    		"name" => "KABUPATEN MINAHASA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7103",
    		"name" => "KABUPATEN KEPULAUAN SANGIHE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7104",
    		"name" => "KABUPATEN KEPULAUAN TALAUD",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7105",
    		"name" => "KABUPATEN MINAHASA SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7106",
    		"name" => "KABUPATEN MINAHASA UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7107",
    		"name" => "KABUPATEN BOLAANG MONGONDOW UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7108",
    		"name" => "KABUPATEN SIAU TAGULANDANG BIARO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7109",
    		"name" => "KABUPATEN MINAHASA TENGGARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7110",
    		"name" => "KABUPATEN BOLAANG MONGONDOW SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7111",
    		"name" => "KABUPATEN BOLAANG MONGONDOW TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7171",
    		"name" => "KOTA MANADO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7172",
    		"name" => "KOTA BITUNG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7173",
    		"name" => "KOTA TOMOHON",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7174",
    		"name" => "KOTA KOTAMOBAGU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7201",
    		"name" => "KABUPATEN BANGGAI KEPULAUAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7202",
    		"name" => "KABUPATEN BANGGAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7203",
    		"name" => "KABUPATEN MOROWALI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7204",
    		"name" => "KABUPATEN POSO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7205",
    		"name" => "KABUPATEN DONGGALA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7206",
    		"name" => "KABUPATEN TOLI-TOLI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7207",
    		"name" => "KABUPATEN BUOL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7208",
    		"name" => "KABUPATEN PARIGI MOUTONG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7209",
    		"name" => "KABUPATEN TOJO UNA-UNA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7210",
    		"name" => "KABUPATEN SIGI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7211",
    		"name" => "KABUPATEN BANGGAI LAUT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7212",
    		"name" => "KABUPATEN MOROWALI UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7213",
    		"name" => "KABUPATEN LUWUK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7271",
    		"name" => "KOTA PALU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7272",
    		"name" => "KOTA POSO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7273",
    		"name" => "KOTA TOLITOLI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7301",
    		"name" => "KABUPATEN KEPULAUAN SELAYAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7302",
    		"name" => "KABUPATEN BULUKUMBA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7303",
    		"name" => "KABUPATEN BANTAENG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7304",
    		"name" => "KABUPATEN JENEPONTO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7305",
    		"name" => "KABUPATEN TAKALAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7306",
    		"name" => "KABUPATEN GOWA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7307",
    		"name" => "KABUPATEN SINJAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7308",
    		"name" => "KABUPATEN MAROS",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7309",
    		"name" => "KABUPATEN PANGKAJENE DAN KEPULAUAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7310",
    		"name" => "KABUPATEN BARRU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7311",
    		"name" => "KABUPATEN BONE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7312",
    		"name" => "KABUPATEN SOPPENG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7313",
    		"name" => "KABUPATEN WAJO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7314",
    		"name" => "KABUPATEN SIDENRENG RAPPANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7315",
    		"name" => "KABUPATEN PINRANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7316",
    		"name" => "KABUPATEN ENREKANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7317",
    		"name" => "KABUPATEN LUWU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7318",
    		"name" => "KABUPATEN TANA TORAJA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7322",
    		"name" => "KABUPATEN LUWU UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7325",
    		"name" => "KABUPATEN LUWU TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7326",
    		"name" => "KABUPATEN TORAJA UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7371",
    		"name" => "KOTA MAKASSAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7372",
    		"name" => "KOTA PAREPARE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7373",
    		"name" => "KOTA PALOPO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7401",
    		"name" => "KABUPATEN BUTON",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7402",
    		"name" => "KABUPATEN MUNA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7403",
    		"name" => "KABUPATEN KONAWE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7404",
    		"name" => "KABUPATEN KOLAKA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7405",
    		"name" => "KABUPATEN KONAWE SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7406",
    		"name" => "KABUPATEN BOMBANA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7407",
    		"name" => "KABUPATEN WAKATOBI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7408",
    		"name" => "KABUPATEN KOLAKA UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7409",
    		"name" => "KABUPATEN BUTON UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7410",
    		"name" => "KABUPATEN KONAWE UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7411",
    		"name" => "KABUPATEN KOLAKA TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7412",
    		"name" => "KABUPATEN KONAWE KEPULAUAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7413",
    		"name" => "KABUPATEN MUNA BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7414",
    		"name" => "KABUPATEN BUTON TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7415",
    		"name" => "KABUPATEN BUTON SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7471",
    		"name" => "KOTA KENDARI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7472",
    		"name" => "KOTA BAUBAU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7501",
    		"name" => "KABUPATEN BOALEMO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7502",
    		"name" => "KABUPATEN GORONTALO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7503",
    		"name" => "KABUPATEN POHUWATO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7504",
    		"name" => "KABUPATEN BONE BOLANGO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7505",
    		"name" => "KABUPATEN GORONTALO UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7571",
    		"name" => "KOTA GORONTALO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7601",
    		"name" => "KABUPATEN MAJENE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7602",
    		"name" => "KABUPATEN POLEWALI MANDAR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7603",
    		"name" => "KABUPATEN MAMASA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7604",
    		"name" => "KABUPATEN MAMUJU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7605",
    		"name" => "KABUPATEN MAMUJU UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7606",
    		"name" => "KABUPATEN MAMUJU TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "7671",
    		"name" => "KOTA MAMUJU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8101",
    		"name" => "KABUPATEN MALUKU TENGGARA BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8102",
    		"name" => "KABUPATEN MALUKU TENGGARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8103",
    		"name" => "KABUPATEN MALUKU TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8104",
    		"name" => "KABUPATEN BURU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8105",
    		"name" => "KABUPATEN KEPULAUAN ARU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8106",
    		"name" => "KABUPATEN SERAM BAGIAN BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8107",
    		"name" => "KABUPATEN SERAM BAGIAN TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8108",
    		"name" => "KABUPATEN MALUKU BARAT DAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8109",
    		"name" => "KABUPATEN BURU SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8171",
    		"name" => "KOTA AMBON",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8172",
    		"name" => "KOTA TUAL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8201",
    		"name" => "KABUPATEN HALMAHERA BARAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8202",
    		"name" => "KABUPATEN HALMAHERA TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8203",
    		"name" => "KABUPATEN KEPULAUAN SULA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8204",
    		"name" => "KABUPATEN HALMAHERA SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8205",
    		"name" => "KABUPATEN HALMAHERA UTARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8206",
    		"name" => "KABUPATEN HALMAHERA TIMUR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8207",
    		"name" => "KABUPATEN PULAU MOROTAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8208",
    		"name" => "KABUPATEN PULAU TALIABU",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8271",
    		"name" => "KOTA TERNATE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8272",
    		"name" => "KOTA TIDORE KEPULAUAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "8273",
    		"name" => "KOTA SOFIFI ",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9101",
    		"name" => "KABUPATEN FAKFAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9102",
    		"name" => "KABUPATEN KAIMANA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9103",
    		"name" => "KABUPATEN TELUK WONDAMA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9104",
    		"name" => "KABUPATEN TELUK BINTUNI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9105",
    		"name" => "KABUPATEN MANOKWARI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9106",
    		"name" => "KABUPATEN SORONG SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9107",
    		"name" => "KABUPATEN SORONG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9108",
    		"name" => "KABUPATEN RAJA AMPAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9109",
    		"name" => "KABUPATEN TAMBRAUW",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9110",
    		"name" => "KABUPATEN MAYBRAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9111",
    		"name" => "KABUPATEN MANOKWARI SELATAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9112",
    		"name" => "KABUPATEN PEGUNUNGAN ARFAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9171",
    		"name" => "KOTA SORONG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9172",
    		"name" => "KOTA MANOKWARI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9401",
    		"name" => "KABUPATEN MERAUKE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9402",
    		"name" => "KABUPATEN JAYAWIJAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9403",
    		"name" => "KABUPATEN JAYAPURA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9404",
    		"name" => "KABUPATEN NABIRE",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9408",
    		"name" => "KABUPATEN KEPULAUAN YAPEN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9409",
    		"name" => "KABUPATEN BIAK NUMFOR",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9410",
    		"name" => "KABUPATEN PANIAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9411",
    		"name" => "KABUPATEN PUNCAK JAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9412",
    		"name" => "KABUPATEN MIMIKA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9413",
    		"name" => "KABUPATEN BOVEN DIGOEL",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9414",
    		"name" => "KABUPATEN MAPPI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9415",
    		"name" => "KABUPATEN ASMAT",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9416",
    		"name" => "KABUPATEN YAHUKIMO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9417",
    		"name" => "KABUPATEN PEGUNUNGAN BINTANG",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9418",
    		"name" => "KABUPATEN TOLIKARA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9419",
    		"name" => "KABUPATEN SARMI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9420",
    		"name" => "KABUPATEN KEEROM",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9426",
    		"name" => "KABUPATEN WAROPEN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9427",
    		"name" => "KABUPATEN SUPIORI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9428",
    		"name" => "KABUPATEN MAMBERAMO RAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9429",
    		"name" => "KABUPATEN NDUGA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9430",
    		"name" => "KABUPATEN LANNY JAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9431",
    		"name" => "KABUPATEN MAMBERAMO TENGAH",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9432",
    		"name" => "KABUPATEN YALIMO",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9433",
    		"name" => "KABUPATEN PUNCAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9434",
    		"name" => "KABUPATEN DOGIYAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9435",
    		"name" => "KABUPATEN INTAN JAYA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9436",
    		"name" => "KABUPATEN DEIYAI",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9471",
    		"name" => "KOTA JAYAPURA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9472",
    		"name" => "KOTA BIAK",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9474",
    		"name" => "KOTA TIMIKA",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9501",
    		"name" => "KABUPATEN PERCONTOHAN",
    		"created_by" => 1,
    	),
    	array(
    		"id" => "9571",
    		"name" => "KOTA PERCONTOHAN",
    		"created_by" => 1,
    	),
    );



        $this->db->insert_batch('location', $t_kab);

    }

    public function down()
    {

    }
}
