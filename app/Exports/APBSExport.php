<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class APBSExport implements FromView,ShouldAutoSize
{
    use Exportable;

    protected $data;
    protected $styles;

    public function __construct($data, $styles) {
        $this->data = $data;
        $this->styles = $styles;
    }

    public function view() : View {
        return view('anggaran.laporan_pdf', [
            'data' => $this->data,
            'styles' => $this->styles
        ]);
    }
}
