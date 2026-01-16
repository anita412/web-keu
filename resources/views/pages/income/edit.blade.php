@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Income {{ $income->nama_income }}</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-content">
                    
                    <form action="{{ url('/income/' . $income->id) }}" method="POST" id="formIncome">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-body">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_income">Nama income</label>
                                            <input type="text" id="nama_income" class="form-control" name="nama_income" 
                                                   value="{{ old('nama_income', $income->nama_income) }}" required>
                                        </div>
                                        
                                        <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="text" id="tanggal" class="form-control" name="tanggal" 
                                            value="{{ now()->format('d-m-Y') }}" disabled>
                                        </div>
                                        <input type="hidden" name="tanggal" value="{{ now()->format('d-m-Y') }}">

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                @foreach(['ada', 'terjual','hilang'] as $status)
                                                    <option value="{{ $status }}" 
                                                        {{ old('status', $income->status) == $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php
                                        $kategoriOptions = [
                                                        'korean_shipping','samaji_store','photosport','fotoyu', 'sawah','hidroponik','lainnya'
                                                    ];
                                        @endphp

                                        <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <select name="kategori" id="kategori" class="form-control" required>
                                                @foreach ($kategoriOptions as $option)
                                                    <option value="{{ $option }}" 
                                                        {{ old('kategori', $income->kategori) == $option ? 'selected' : '' }}>
                                                        {{ ucwords(str_replace('_',' ',$option)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="kategori_kustom_field" class="form-group"
                                            style="display: {{ old('kategori', $income->kategori) == 'lainnya' ? 'block' : 'none' }};">
                                            
                                            <label for="kategori_kustom">Isi Kategori Lainnya</label>
                                            <input type="text" 
                                                id="kategori_kustom" 
                                                name="kategori_kustom" 
                                                class="form-control"
                                                value="{{ old('kategori_kustom', $income->kategori_kustom) }}"
                                                placeholder="Masukkan kategori lain...">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pemasukan">Pemasukan</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control text-end" name="pemasukan" id="pemasukan" 
                                                       value="{{ old('pemasukan', number_format($income->pemasukan, 0, ',', '.')) }}" 
                                                       onkeyup="formatRupiah(this)" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="pengeluaran">Pengeluaran</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control text-end" name="pengeluaran" id="pengeluaran" 
                                                       value="{{ old('pengeluaran', number_format($income->pengeluaran, 0, ',', '.')) }}" 
                                                       onkeyup="formatRupiah(this)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="penyimpanan_income">penyimpanan income</label>
                                            <input type="text" id="penyimpanan_income" class="form-control" name="penyimpanan_income" 
                                                   value="{{ old('penyimpanan_income', $income->penyimpanan_income) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $income->deskripsi) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <div class="card-footer">
                            <div class="d-flex justify-content-end" style="gap: 10px;">
                                <a href="{{ url('/income/index') }}" class="btn btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function formatRupiah(input) {
        let nilai = input.value.replace(/\./g, '').replace(/[^0-9]/g, '');
        if (nilai === '') {
            input.value = '';
            return;
        }
        let angka = parseInt(nilai, 10);
        if (isNaN(angka)) {
            input.value = input.value.replace(/[^0-9]/g, '');
            return;
        }    
        let format = angka.toLocaleString('id-ID', {
            minimumFractionDigits: 0
        }).replace('Rp', '').trim();                                      
        input.value = format;
    }
</script>
