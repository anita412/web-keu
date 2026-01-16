<?php

namespace App\Http\Controllers;

use App\Models\Saham; 
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class SahamController extends Controller
{
    public function index(Request $request) { 
        // $sahams = saham::orderBy('id', 'DESC')->get();

        $saldo = (float) Setting::where('key', 'saldo_saham')->value('value') ?? 0;

        $sahams = Saham::latest()->paginate(10);

        $total_harga_beli = Saham::sum('harga_beli');

        $total_keuntungan = Saham::whereNotNull('harga_jual')
            ->where('harga_jual', '>', 0)
            ->selectRaw('SUM(harga_jual - harga_beli) as total')
            ->value('total') ?? 0;

        $total_uang = $saldo - $total_keuntungan;

        return view('pages.saham.index', compact(
            'sahams',
            'saldo',
            'total_harga_beli',
            'total_keuntungan',
            'total_uang'
        ));
    }

    public function updateSaldo(Request $request) {
        $cleanSaldo = str_replace('.', '', $request->input('saldo'));

        \App\Models\Setting::updateOrCreate(
            ['key' => 'saldo_saham'],
            ['value' => $cleanSaldo]
        );

        return redirect()->route('saham.index')->with('success', 'Saldo berhasil diperbarui!');
    }

    public function create() {
        return view('pages.saham.create');
    }
    
    public function store(Request $request)
    {
        $tanggal = $request->tanggal_beli 
            ? Carbon::createFromFormat('d-m-Y', $request->tanggal_beli)->format('Y-m-d')
            : now()->format('Y-m-d');

        $request->merge([
            'tanggal_beli' => $tanggal,
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        $validated = $request->validate([
            'nama_saham' => 'required|max:100',
            'tanggal_beli' => 'required|date',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'nullable|numeric',
            // 'keuntungan' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Saham::create($validated);

        return redirect()->route('saham.index')->with('success', 'Berhasil menambahkan data saham');
    }

    public function edit($id) {
        $saham = Saham::findOrFail($id); 
        return view('pages.saham.edit', [
            'saham' => $saham,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        if ($request->tanggal_beli) {
            $request->merge([
                'tanggal_beli' => Carbon::createFromFormat('d-m-Y', $request->tanggal_beli)->format('Y-m-d')
            ]);
        }

        $validated = $request->validate([
            'nama_saham' => 'required|max:100',
            'tanggal_beli' => 'nullable|date',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'nullable|numeric',
            // 'keuntungan' => 'nullable|numeric',
            'status' => ['required', Rule::in(['ada','terjual','hilang'])],
            'kategori' => 'required|string',
            'kategori_kustom' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|max:255'
        ]);

        $validated['kategori_kustom'] = (
            $validated['kategori'] === 'lainnya'
            ? $request->kategori_kustom
            : null
        );

        Saham::findOrFail($id)->update($validated);

        return redirect()->route('saham.index')->with('success', 'Berhasil mengubah data saham');
    }

    public function destroy($id) {
        try {
            $saham = Saham::findOrFail($id);             
            $saham->delete();
            return redirect()->route('saham.index')->with('success', 'saham berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('saham.index')->with('error', 'saham tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('saham.index')->with('error', 'Gagal menghapus saham. ' . $e->getMessage());
        }
    }

    
}