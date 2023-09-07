<?php
  
use Carbon\Carbon;
  
/**
 * Write code on Method
 *
 * @return response()
 */
function nomor($urut)
    {
        $res = $urut;
        if($urut < 100){
            $res = '000' . $urut;
        }
        else if($urut < 100){
            $res = '00' . $urut;
        }
        else if($urut < 1000){
            $res = '0' . $urut;
        }
        return $res;
    }

function timestamp($tanggal)
{
    $timestamp = strtotime($tanggal);
    return $timestamp;
}

function nama_hari()
{
    $nama_hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    return $nama_hari;
}

function format_harga($harga)
{
    $data = number_format($harga,0,',','.');
    return $data;
}

function format_tanggal($tanggal)
{
    $timestamp = strtotime($tanggal);
    $tanggalOutput = date('d F Y', $timestamp);
    $englishMonths = array(
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    );
    
    $indonesianMonths = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    
    // Replace English month names with Indonesian month names
    $dateOutput = str_replace($englishMonths, $indonesianMonths, $tanggalOutput);
    return $dateOutput;
}