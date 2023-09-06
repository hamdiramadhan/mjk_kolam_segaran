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