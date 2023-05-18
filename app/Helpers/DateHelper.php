<?php
namespace App\Helpers;

use Illuminate\Support\Carbon;

class DateHelper {
    public static function getNow() {
        $bulan = Carbon::now()->format('m');
        if ($bulan <= 6) {
            return Carbon::now()->subYear()->format('Y');
        } else {
            return Carbon::now()->format('Y');
        }
    }

    public static function getNow2() {
        $bulan = Carbon::now()->format('m');
        if ($bulan <= 6) {
            return Carbon::now()->format('Y');
        } else {
            return Carbon::now()->addYear()->format('Y');
        }
    }
}

