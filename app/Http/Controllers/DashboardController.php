<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Saham;
use App\Models\Income;
use App\Models\Maintenance;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{    

    public function index(Request $request)
    {
        
        $filterDate = $request->input('filter_date', Carbon::now()->format('Y-m'));
        try {
            $carbonDate = Carbon::createFromFormat('Y-m', $filterDate);
        } catch (\Exception $e) {
            $carbonDate = Carbon::now();
        }

        $bulan = $carbonDate->month;
        $tahun = $carbonDate->year;
        $excludedStatuses = ['terjual', 'hilang'];

        $totalHargaBeliAset = (int) Aset::sum('harga_beli');
        $totalKeuntunganAset = (int) Aset::where('harga_jual', '>', 0)
            ->selectRaw('SUM(harga_jual - harga_beli) as total')
            ->value('total') ?? 0;
        $grafikAset = Aset::whereMonth('tanggal_beli', $bulan)
        ->whereYear('tanggal_beli', $tahun)
        ->whereNotIn('status', $excludedStatuses)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get()
        ->map(function ($item) {
            $item->keuntungan_hitung = ($item->harga_jual > 0) 
                ? (int)$item->harga_jual - (int)$item->harga_beli 
                : 0; 
                
            return $item;
        });

        $totalHargaBeliSaham = (int) Saham::sum('harga_beli');
        $totalKeuntunganSaham = (int) Saham::where('harga_jual', '>', 0)
            ->selectRaw('SUM(harga_jual - harga_beli) as total')
            ->value('total') ?? 0;
        $grafikSaham = Saham::whereMonth('tanggal_beli', $bulan)
        ->whereYear('tanggal_beli', $tahun)
        ->whereNotIn('status', $excludedStatuses)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get()
        ->map(function ($item) {
            $item->keuntungan_hitung = ($item->harga_jual > 0) 
                ? (int)$item->harga_jual - (int)$item->harga_beli 
                : 0;
                
            return $item;
        });

        $totalPemasukanIncome = (int) Income::sum('pemasukan');
        $totalPengeluaranIncome = (int) Income::sum('pengeluaran');

        $grafikIncome = Income::whereMonth('tanggal_beli', $bulan)
        ->whereYear('tanggal_beli', $tahun)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get()
        ->groupBy('nama_income')->map(function ($items, $nama) {
            return [
                'nama_income' => $nama,
                'total_pemasukan' => $items->sum('pemasukan'),
                'total_pengeluaran' => $items->sum('pengeluaran'),
            ];
        })->values();

        $totalPemasukanMaintenance = (int) Maintenance::sum('pemasukan');
        $totalPengeluaranMaintenance = (int) Maintenance::sum('pengeluaran');

        $grafikMaintenance = Maintenance::whereMonth('tanggal_beli', $bulan)
        ->whereYear('tanggal_beli', $tahun)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get()
        ->groupBy('nama_maintenance')->map(function ($items, $nama) {
            return [
                'nama_maintenance' => $nama,
                'total_pemasukan' => $items->sum('pemasukan'),
                'total_pengeluaran' => $items->sum('pengeluaran'),
            ];
        })->values();

        $totalPemasukanSaving = (int) Saving::sum('pemasukan');
        $totalPengeluaranSaving = (int) Saving::sum('pengeluaran');

        $grafikSaving = Saving::whereMonth('tanggal_beli', $bulan)
        ->whereYear('tanggal_beli', $tahun)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get()
        ->groupBy('nama_saving')->map(function ($items, $nama) {
            return [
                'nama_saving' => $nama,
                'total_pemasukan' => $items->sum('pemasukan'),
                'total_pengeluaran' => $items->sum('pengeluaran'),
            ];
        })->values();

        return view('pages.dashboard', compact(
            'grafikAset', 'totalHargaBeliAset', 'totalKeuntunganAset',
            'grafikSaham', 'totalHargaBeliSaham', 'totalKeuntunganSaham',
            'grafikIncome', 'totalPemasukanIncome', 'totalPengeluaranIncome',
            'grafikMaintenance', 'totalPemasukanMaintenance', 'totalPengeluaranMaintenance',
            'grafikSaving', 'totalPemasukanSaving', 'totalPengeluaranSaving',
            'filterDate'
        ));
    }
}