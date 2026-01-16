<?php

namespace App\Http\Controllers;

use App\Models\Income; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index() {
        $incomes = Income::orderBy('id', 'DESC')->get();

        $total_pemasukan = Income::sum('pemasukan');

        $total_pengeluaran = Income::sum('pengeluaran');
        $totalSemuaIncome = $total_pemasukan - $total_pengeluaran;

        return view('pages.income.index', compact('incomes', 'total_pemasukan', 'total_pengeluaran', 'totalSemuaIncome'));
    }

    public function create() {
        return view('pages.income.create');
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
            'nama_income' => 'required|max:100',
            'tanggal_beli' => 'required|date',
            'pemasukan' => 'required|numeric',
            'pengeluaran' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'penyimpanan_income' => 'required|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Income::create($validated);

        return redirect('/income/index')->with('success', 'Berhasil menambahkan data income');
    }

    public function edit($id) {
        $income = Income::findOrFail($id); 
        return view('pages.income.edit', [
            'income' => $income,
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
            'nama_income' => 'required|max:100',
            'tanggal_beli' => 'nullable|date',
            'pemasukan' => 'required|numeric',
            'pengeluaran' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'penyimpanan_income' => 'required|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Income::findOrFail($id)->update($validated);

        return redirect('/income/index')->with('success', 'Berhasil mengubah data income');
    }

    public function destroy($id) {
        try {
            $income = Income::findOrFail($id);             
            $income->delete();
            return redirect('/income/index')->with('success', 'income berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/income/index')->with('error', 'income tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect('/income/index')->with('error', 'Gagal menghapus income. ' . $e->getMessage());
        }
    }
}