<?php
    function counted($angka) {
        $angka = abs($angka);
        $baca = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        $counted = '';

        if ($angka < 12) { // 0 - 11
            $counted = ' '.$baca[$angka];
        } elseif ($angka < 20) { // 12 - 19
            $counted = counted($angka - 10).' belas';
        } elseif ($angka < 100) { // 20 - 99
            $counted = counted($angka / 10).' puluh'.counted($angka % 10);
        } elseif ($angka < 200) { // 100 - 199
            $counted = ' seratus'.counted($angka - 100);
        } elseif ($angka < 1000) { // 200 - 999
            $counted = counted($angka / 100).' ratus'.counted($angka % 100);
        } elseif ($angka < 2000) { // 1.000 - 1.999
            $counted = ' seribu'.counted($angka - 1000);
        } elseif ($angka < 1000000) { // 2.000 - 999.999
            $counted = counted($angka / 1000).' ribu'.counted($angka % 1000);
        } elseif ($angka < 1000000000) { // 1000000 - 999.999.990
            $counted = counted($angka / 1000000).' juta'.counted($angka % 1000000);
        }

        return $counted;
    }