<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

    function get_timeago( $ptime )
    {
        $date = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
        $now = $date->format('Y-m-d H:i:s');

        $estimate_time = strtotime($now) - strtotime($ptime);

        if( $estimate_time < 1 )
        {
            return 'less than 1 second ago';
        }

        $condition = array(
                    12 * 30 * 24 * 60 * 60  =>  'tahun',
                    30 * 24 * 60 * 60       =>  'bulan',
                    24 * 60 * 60            =>  'hari',
                    60 * 60                 =>  'jam',
                    60                      =>  'menit',
                    1                       =>  'detik'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $estimate_time / $secs;

            if( $d >= 1 )
            {
                $r = round( $d );
                //return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
                return $r . ' ' . $str .  ' yang lalu';
            }
        }
    }

    function send_notifikasi_by_role_id($role_id, $message, $id_pengirim = 1)
    {
        $CI = &get_instance();
        $users = $CI->db->get_where('users_roles', ['role_id' => $role_id])->result();
        $data_notif = [];
        foreach ($users as $user)
        {
            $data_notif [] = [
                'id_pengirim' => $id_pengirim,
                'id_penerima' => $user->user_id,
                'deskripsi' => $message
            ];
        }
        //die(var_dump($data_notif));
        if(!empty($data_notif))
        {
            $CI->db->insert_batch('notification', $data_notif);
        }
    }

    function get_no_surat_api_wika($data)
    {
        $url = 'http://developer.wika.co.id/SIAS/apirest/index.php/alat';
        /*
        $json_params = '{"tanggal":"2019-04-09","perihal":"Pengadaan Beton Readymix Aditive (Khusus) Type 1","nama_user":"latief",
                "penandatangan":"General Manager","nip":"4CCFD310AA","unit_kerja":"B.DSU1","tujuan":"Vendor"}';
        $data = json_decode($json_params);
        */

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        //die(var_dump($server_output));
        $result = json_decode($server_output);
        if ($result->status != 'success')
        {
            return FALSE;
        }
        else
        {
            return $result->message;
        }
    }

 	function uploadFile($file_name, $dir,$prefix_file,$ext=''){
        $CI =& get_instance();
        $return_file_name="";
        $config['upload_path']          = $dir;
        $config['allowed_types']        = '*';
        if($ext != ''){
            $ext = $ext;
        }else{
            $ext = ".jpg";
        }
        $config['file_name'] = $prefix_file."_".time().$ext;

        $return = array();
        $return['status'] = FALSE;
        $return['message'] = "";
        $CI->load->library('upload');
        $CI->upload->initialize($config);
        if ($CI->upload->do_upload($file_name)){
            $upload_data = $CI->upload->data();
            $return_file_name = $config['file_name'];
            $return['status'] = TRUE;
            $return['message'] = $return_file_name;
        }else{
            $return['status'] = FALSE;
            $return['message'] =  $CI->upload->display_errors();
        }
        return $return;
    }


	function rupiah($num, $koma = 0)
	{
		return number_format($num, $koma, ',', '.');
	}

    function dibulatkan($num, $pembulatannya = 100)
    {
        $bagi = (int) ($num / $pembulatannya);
        //return $bagi;
        return rupiah($bagi * $pembulatannya);
    }

    function hari($index)
    {
        $hari = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];

        if(!isset($hari[$index])) return FALSE;

        return $hari[$index];
    }

    function bulan($index)
    {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        if(!isset($bulan[$index])) return FALSE;

        return $bulan[$index];
    }

    function tgl_indo($str, $dengan_jam = FALSE)
    {
        $date = date('Y-n-d', strtotime($str));
        $pecahkan = explode('-', $date);
        //return $pecahkan[1];


        if ($dengan_jam === FALSE)
        {
            return $pecahkan[2] . ' ' . bulan($pecahkan[1]) . ' ' . $pecahkan[0];
        }
        else
        {
            $jam = date('H:i:s', strtotime($str));
            return $pecahkan[2] . ' ' . bulan($pecahkan[1]) . ' ' . $pecahkan[0] . ' '.$jam;
        }
    }

    function my_print_r($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }


    function array_to_options($array, $selected = '')
    {
        $option = "";
        foreach($array as $k => $v)
        {
            $sel = "";
            if($k == $selected)
            {
                $sel = "selected";
            }
            $option .= "<option value='$k' $sel>$v</option>";
        }

        return $option;
    }

    function result_to_options($result, $selected = '', $value = 'id', $text = 'name')
    {
        $option = "";
        foreach($result as $k => $v)
        {
            $sel = "";
            if($v->$value == $selected)
            {
                $sel = "selected";
            }
            $option .= "<option value='" . $v->$value . "' $sel>" . $v->$text . "</option>";
        }

        return $option;
    }

    function send_sms_by_user_id($user_id, $message = '')
    {

    }

    function send_sms_by_vendor_id($vendor_id, $message = '')
    {

    }

    function send_sms_by_role_id($role_id, $message = 'cek')
    {
        $CI = &get_instance();
        $users = $CI->db->get_where('users_roles', ['role_id' => $role_id])->result();
        $user_id = [];
        foreach ($users as $user)
        {
            $user_id[] = $user->user_id;
        }

        if(empty($user_id))
        {
            return FALSE;
        }

        $query = $CI->db->where_in('id', $user_id)->get('users');
        if(empty($query->result()))
        {
            return FALSE;
        }

        $no_hp = [];
        foreach ($query->result() as $k => $v)
        {
            if($v->phone != '')
            {
                $no_hp[] = $v->phone;
            }
        }
        //my_print_r($no_hp);
        //die();
        if (!empty($no_hp))
        {
            sendsms($no_hp, $message);
        }
        //var_dump($query->result());
        // $CI->db->insert_batch('notification', $data_notif);
    }

    function sendsms($handphone = '081394760961',$text = 'ok sipp'){
        #29082018 pecah antara sms biasa dan sms masking


        if (is_array($handphone))
        {
            foreach($handphone as $v)
            {
                sendsms($v, $text);
            }
            return FALSE;
        }

        if($handphone == '')
        {
            return FALSE;
        }

        $hostname=$_SERVER['HTTP_HOST'];
        $handphone=preg_replace('/\D/', '', $handphone);
        #$hostname="localhost";
        $dr_url="103.25.196.29";
        $usernamesmsmasking="wika_bsi";
        $passwordsmsmasking="bfdb70970ec8f41e4016f6e341c7596c";
        $sender="WIKA-SCM";

        if($handphone){
            $subs=substr($handphone,1);
            $depan=substr($handphone,0,1);
            if($depan=="0") $handphone="62".$subs;

            $data_xml="data=
            <bulk_sending>
                <username>".$usernamesmsmasking."</username>
                <password>".$passwordsmsmasking."</password>
                <priority>high</priority>
                <sender>".$sender."</sender>
                <dr_url>".$dr_url."</dr_url>
                <allowduplicate>1</allowduplicate>
                <data_packet>
                    <packet>
                        <msisdn>".$handphone."</msisdn>
                        <sms>".$text."</sms>
                        <is_long_sms>N</is_long_sms>
                    </packet>
                </data_packet>
            </bulk_sending>
            ";
            $URL = "http://webapps.promediautama.com:29003/sms_applications/smsb/api_mt_send_message.php";
            $ch = curl_init($URL);
            //curl_setopt($ch, CURLOPT_MUTE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_xml);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            echo($output);
        }



    }


     function penyebut($nilai) {
            $nilai = abs($nilai);
            $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                $temp = penyebut($nilai - 10). " Belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " Seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " Seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
            }     
            return $temp;
        }
 
    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }           
        return $hasil;
    }