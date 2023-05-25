<?php

function tanggal_indo($value)
{
    $tanggal = date($value);

    switch (date('m', strtotime($tanggal))) {
        case '01':
            $bulan = 'Januari';
            break;
        case '02':
            $bulan = 'Februari';
            break;
        case '03':
            $bulan = 'Maret';
            break;
        case '04':
            $bulan = 'April';
            break;
        case '05':
            $bulan = 'Mei';
            break;
        case '06':
            $bulan = 'Juni';
            break;
        case '07':
            $bulan = 'Juli';
            break;
        case '08':
            $bulan = 'Agustus';
            break;
        case '09':
            $bulan = 'September';
            break;
        case '10':
            $bulan = 'Oktober';
            break;
        case '11':
            $bulan = 'November';
            break;
        case '12':
            $bulan = 'Desember';
            break;

        default:
            $bulan = 'Tidak diketahui';
            break;
    }

    return date('d', strtotime($tanggal)) . ' ' . $bulan . ' ' . date('Y', strtotime($tanggal));
}

function format_uang($angka)
{
    return number_format($angka, 0, ',', '.');
}

function terbilang($angka)
{
    $angka = abs($angka);
    $baca = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    $terbilang = '';

    if ($angka < 12) {
        $terbilang = '' . $baca[$angka];
    } elseif ($angka < 20) {
        $terbilang = terbilang($angka - 10) . 'belas';
    } elseif ($angka < 100) {
        $terbilang = terbilang($angka / 10) . 'puluh' . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $terbilang = 'seratus' . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $terbilang = terbilang($angka / 100) . 'ratus' . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        $terbilang = 'seribu' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $terbilang = terbilang($angka / 1000) . 'ribu' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $terbilang = terbilang($angka / 1000000) . 'juta' . terbilang($angka % 1000000);
    }

    return $terbilang;
}
