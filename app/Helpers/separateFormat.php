<?php
    function separate($nilai) {
        $formatrupiah = 'Rp. '.number_format($nilai, '2', ',', '.');
        return $formatrupiah;
    }
