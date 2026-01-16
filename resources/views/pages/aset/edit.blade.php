@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Aset {{ $aset->nama_aset }}</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-content">
                    
                    <form action="{{ url('/aset/' . $aset->id) }}" method="POST" id="formAset">
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
                                            <label for="nama_aset">Nama aset</label>
                                            <input type="text" id="nama_aset" class="form-control" name="nama_aset" 
                                                   value="{{ old('nama_aset', $aset->nama_aset) }}" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="tanggal_beli">Tanggal Beli</label>
                                            <input type="text" id="tanggal_beli" class="form-control" name="tanggal_beli"
                                                value="{{ old('tanggal_beli', \Carbon\Carbon::parse($aset->tanggal_beli)->format('d-m-Y')) }}" disabled>
                                        <input type="hidden" name="tanggal_beli" value="{{ old('tanggal_beli', \Carbon\Carbon::parse($aset->tanggal_beli)->format('d-m-Y')) }}">                                        
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="tanggal_beli">Tanggal Beli</label>
                                            <input type="date" id="tanggal-beli" class="form-control" name="tanggal_beli" 
                                                   value="{{ old('tanggal_beli', $aset->tanggal_beli) }}" required>
                                        </div> --}}
                                        
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                @foreach(['ada', 'terjual','hilang'] as $status)
                                                    <option value="{{ $status }}" 
                                                        {{ old('status', $aset->status) == $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php
                                        $kategoriOptions = [
                                            'kendaraan','tanah_&_rumah','elektronik','photography_&_videography', 'lainnya'
                                        ];
                                        @endphp

                                        <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <select name="kategori" id="kategori" class="form-control" required>
                                                @foreach ($kategoriOptions as $option)
                                                    <option value="{{ $option }}" 
                                                        {{ old('kategori', $aset->kategori) == $option ? 'selected' : '' }}>
                                                        {{ ucwords(str_replace('_',' ',$option)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="kategori_kustom_field" class="form-group"
                                            style="display: {{ old('kategori', $aset->kategori) == 'lainnya' ? 'block' : 'none' }};">
                                            
                                            <label for="kategori_kustom">Isi Kategori Lainnya</label>
                                            <input type="text" 
                                                id="kategori_kustom" 
                                                name="kategori_kustom" 
                                                class="form-control"
                                                value="{{ old('kategori_kustom', $aset->kategori_kustom) }}"
                                                placeholder="Masukkan kategori lain...">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="harga_beli">Harga Beli</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control text-end" name="harga_beli" id="harga_beli" 
                                                       value="{{ old('harga_beli', number_format($aset->harga_beli, 0, ',', '.')) }}" 
                                                       onkeyup="formatRupiah(this)" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="harga_jual">Harga Jual</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control text-end" name="harga_jual" id="harga_jual" 
                                                       value="{{ old('harga_jual', number_format($aset->harga_jual, 0, ',', '.')) }}" 
                                                       onkeyup="formatRupiah(this)">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="deskripsi">Deskripsi</label>
                                            <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $aset->deskripsi) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <div class="card-footer">
                            <div class="d-flex justify-content-end" style="gap: 10px;">
                                <a href="{{ url('/aset/index') }}" class="btn btn-outline-secondary">Batal</a>
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

    document.addEventListener("DOMContentLoaded", function() {
        const selectKategori = document.getElementById('kategori');
        const inputKustom = document.getElementById('kategori_kustom_field');

        function toggleInput() {
            if (selectKategori.value === "lainnya") {
                inputKustom.style.display = "block";
            } else {
                inputKustom.style.display = "none";
            }
        }

        selectKategori.addEventListener('change', toggleInput);

        toggleInput();
    });
</script>



