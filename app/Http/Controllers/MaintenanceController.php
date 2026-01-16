<?php

namespace App\Http\Controllers;

use App\Models\Maintenance; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    public function index() {
        $maintenances = Maintenance::orderBy('id', 'DESC')->get();

        $total_pemasukan = Maintenance::sum('pemasukan');

        $total_pengeluaran = Maintenance::sum('pengeluaran');
        
        $totalSemuaMaintenance = $total_pemasukan - $total_pengeluaran;

        return view('pages.maintenance.index', compact('maintenances', 'total_pemasukan', 'total_pengeluaran', 'totalSemuaMaintenance'));
    }

    public function create() {
        return view('pages.maintenance.create');
    }
    
    public function store(Request $request)
    {
        $tanggal = $request->tanggal_beli 
            ? Carbon::createFromFormat('d-m-Y', $request->tanggal_beli)->format('Y-m-d')
            : now()->format('Y-m-d');

        $request->merge([
            'tanggal_beli' => $tanggal,
            'pemasukan' => str_replace('.', '', $request->pemasukan),
            'pengeluaran' => str_replace('.', '', $request->pengeluaran),
        ]);

        $validated = $request->validate([
            'nama_maintenance' => 'required|max:100',
            'tanggal_beli' => 'required|date',
            'pemasukan' => 'required|numeric',
            'pengeluaran' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'penyimpanan_maintenance' => 'required|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Maintenance::create($validated);

        return redirect('/maintenance/index')->with('success', 'Berhasil menambahkan data maintenance');
    }

    public function edit($id) {
        $maintenance = Maintenance::findOrFail($id); 
        return view('pages.maintenance.edit', [
            'maintenance' => $maintenance,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'pemasukan' => str_replace('.', '', $request->pemasukan),
            'pengeluaran' => str_replace('.', '', $request->pengeluaran),
        ]);

        if ($request->tanggal_beli) {
            $request->merge([
                'tanggal_beli' => Carbon::createFromFormat('d-m-Y', $request->tanggal_beli)->format('Y-m-d')
            ]);
        }

        $validated = $request->validate([
            'nama_maintenance' => 'required|max:100',
            'tanggal_beli' => 'nullable|date',
            'pemasukan' => 'required|numeric',
            'pengeluaran' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'penyimpanan_maintenance' => 'required|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Maintenance::findOrFail($id)->update($validated);

        return redirect('/maintenance/index')->with('success', 'Berhasil mengubah data maintenance');
    }

    public function destroy($id) {
        try {
            $maintenance = Maintenance::findOrFail($id);             
            $maintenance->delete();
            return redirect('/maintenance/index')->with('success', 'maintenance berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/maintenance/index')->with('error', 'maintenance tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect('/maintenance/index')->with('error', 'Gagal menghapus maintenance. ' . $e->getMessage());
        }
    }
}