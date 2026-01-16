@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Saham Baru</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                
                <form action="{{ route('saham.store') }}" method="POST">
                    @csrf
                    
                    <div class="card-body">
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                Harap periksa kembali input Anda.
                            </div>
                        @endif
                        
                        <div class="form-body">
                            <div class="row">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_saham">Nama</label>
                                        <input type="text" id="nama_saham" class="form-control @error('nama_saham') is-invalid @enderror" 
                                               name="nama_saham" placeholder="Contoh: saham ABCD, Emas Antam" value="{{ old('nama_saham') }}">
                                        @error('nama_saham')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_beli">Tanggal Beli</label>
                                        <input type="text" id="tanggal_beli" class="form-control" name="tanggal_beli" 
                                            value="{{ now()->format('d-m-Y') }}" disabled>
                                    </div>
                                    <input type="hidden" name="tanggal_beli" value="{{ now()->format('d-m-Y') }}">

                                    {{-- <div class="form-group">
                                        <label for="tanggal_beli">Tanggal Beli</label>
                                        <input type="date" id="tanggal_beli" class="form-control @error('tanggal_beli') is-invalid @enderror" 
                                               name="tanggal_beli" value="{{ old('tanggal_beli') }}">
                                        @error('tanggal_beli')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                    
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="ada" {{ old('status') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="terjual" {{ old('status') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                                            <option value="hilang" {{ old('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>                                            
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="kategori">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                                            @php
                                                $kategoriOptions = ['dana_pensiun','dana_pendidikan','dana_darurat','bayi', 'umroh','sewa_toko', 'sawah','kondangan','lainnya']
                                            @endphp
                                            @foreach ($kategoriOptions as $option)
                                                @php $displayValue = ucwords(str_replace('_', ' ', $option)); @endphp
                                                <option value="{{ $option }}" {{ old('kategori') == $option ? 'selected' : '' }}>
                                                    {{ $displayValue }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group" id="kategori_kustom_field" style="display: none;">
                                        <label for="kategori_kustom">Isi Kategori Lainnya</label>
                                        <input type="text" name="kategori_kustom" id="kategori_kustom" 
                                            class="form-control @error('kategori_kustom') is-invalid @enderror" placeholder="Masukkan kategori lain...">
                                        @error('kategori_kustom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="harga_beli">Harga Beli</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control text-end @error('harga_beli') is-invalid @enderror" 
                                                   onkeyup="formatRupiah(this)" name="harga_beli" id="harga_beli" value="{{ old('harga_beli', 0) }}">
                                            @error('harga_beli')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="harga_jual">Harga Jual</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control text-end @error('harga_jual') is-invalid @enderror" 
                                                   onkeyup="formatRupiah(this)" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', 0) }}">
                                            @error('harga_jual')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap :10px">
                            <a href="{{ url('/saham/index') }}" class="btn btn-outline-secondary">Kembali</a> 
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                        </div>
                    </div>
                </form> 
                
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
