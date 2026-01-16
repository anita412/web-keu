<?php

namespace App\Http\Controllers;

use App\Models\Saving; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class SavingController extends Controller
{
    public function index() {
        $savings = Saving::orderBy('id', 'DESC')->get();

        $total_pemasukan = Saving::sum('pemasukan');

        $total_pengeluaran = Saving::sum('pengeluaran');

        $totalSemuaSaving = $total_pemasukan - $total_pengeluaran;
        
        return view('pages.saving.index', compact('savings', 'total_pemasukan', 'total_pengeluaran', 'totalSemuaSaving'));
    }

    public function create() {
        return view('pages.saving.create');
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
            'nama_saving' => 'required|max:100',
            'tanggal_beli' => 'required|date',
            'pemasukan' => 'required|numeric',
            'pengeluaran' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'penyimpanan_saving' => 'required|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Saving::create($validated);

        // return redirect('/saving/index')->with('success', 'Berhasil menambahkan data saving');
        return redirect()->route('saving.index')->with('success', 'Berhasil menambahkan data saving');
    }

    public function edit($id) {
        $saving = Saving::findOrFail($id); 
        return view('pages.saving.edit', [
            'saving' => $saving,
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
            'nama_saving' => 'required|max:100',
            'tanggal_beli' => 'nullable|date',
            'pemasukan' => 'required|numeric',
            'pengeluaran' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'penyimpanan_saving' => 'required|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Saving::findOrFail($id)->update($validated);

        return redirect('/saving/index')->with('success', 'Berhasil mengubah data saving');
    }

    public function destroy($id) {
        try {
            $saving = Saving::findOrFail($id);             
            $saving->delete();
            return redirect('/saving/index')->with('success', 'saving berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/saving/index')->with('error', 'saving tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect('/saving/index')->with('error', 'Gagal menghapus saving. ' . $e->getMessage());
        }
    }
}