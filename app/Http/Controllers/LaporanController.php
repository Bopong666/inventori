<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    //

    public function barang()
    {
        if (Auth::user()->level == 'user') {
            return abort(404);
        }

        $data = Barang::withSum('masuk', 'jumlah')->withSum('permintaan', 'jumlah')->get();
        // $data = Barang::all();

        $pdf = PDF::loadView('barang_pdf', ['datas' => $data]);
        return $pdf->download('laporan-barang-pdf.pdf');
    }

    public function permintaan()
    {
        if (Auth::user()->level == 'user') {
            return abort(404);
        }
        $data = Permintaan::with(['user', 'barang', 'puskesmas'])->get();
        $pdf = PDF::loadView('permintaan_pdf', ['datas' => $data]);
        return $pdf->download('laporan-permintaan-pdf.pdf');
    }
}
