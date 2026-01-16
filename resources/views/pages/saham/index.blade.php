@extends('layouts.app')

@section('content')
    @php
        use Illuminate\Support\Carbon;
        use Illuminate\Support\Str;

        // $total_uang = ($saldo ?? 0) - ($total_keuntungan ?? 0);

    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Saham</h1>
        <a href="{{ route('saham.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <form action="{{ route('saham.updateSaldo') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="displaySaldo" class="form-control form-control-sm" 
                                value="{{ number_format($saldo ?? 0, 0, ',', '.') }}">
                            
                            <input type="hidden" name="saldo" id="realSaldo" value="{{ $saldo ?? 0 }}">
                            
                            <button class="btn btn-sm btn-primary" type="submit">Set</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="alert alert-info shadow h-100 d-flex align-items-center mb-0">
                <div>
                    <strong>Total Harga Beli:</strong> Rp {{ number_format($total_harga_beli ?? 0, 0, ',', '.') }} <br>
                    <strong>Total Keuntungan:</strong> <span class="text-success font-weight-bold">Rp {{ number_format($total_keuntungan ?? 0, 0, ',', '.') }}</span> <br>
                    
                    <strong>Total Uang (Saldo - Untung):</strong> <span class="text-primary font-weight-bold">Rp {{ number_format($total_uang ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="text-center">
                                <tr style="center">
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Keuntungan</th>
                                    <th>Kategori</th> 
                                    <th>Deskripsi</th>                                     
                                    <th>Status</th>
                                    <th style="width: 100px;">Aksi</th> 
                                </tr>
                            </thead>
                            
                            <tbody>
                            @forelse ($sahams as $item) 
                                <tr>
                                    <td>{{ $item->nama_saham }}</td> 
                                    <td>{{ Carbon::parse($item->tanggal_beli)->format('d-m-Y') }}</td>
                                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                    @php
                                        $keuntungan = ($item->harga_jual > 0) ? ($item->harga_jual - $item->harga_beli) : 0;
                                        $keuntunganClass = ($item->harga_jual <= 0) ? 'text-secondary' : (($keuntungan >= 0) ? 'text-success' : 'text-danger');
                                    @endphp

                                    <td class="{{ $keuntunganClass }}">
                                        @if($item->harga_jual > 0)
                                            Rp {{ number_format($keuntungan, 0, ',', '.') }}
                                        @else
                                            <span class="text-muted">-</span> 
                                        @endif
                                    </td>                                    
                                    <td>
                                        @php
                                            $displayKategori = ($item->kategori === 'lainnya' && !empty($item->kategori_kustom))
                                                ? ucwords($item->kategori_kustom) 
                                                : ucwords(str_replace('_', ' ', $item->kategori)); 

                                            $baseKategori = $item->kategori; 

                                            $customColors = [
                                                'dana_pensiun'  => ['bg' => '#8c9140', 'text' => '#333333'], 
                                                'dana_pendidikan'=> ['bg' => '#ffa07a', 'text' => '#333333'], 
                                                'dana_darurat'  => ['bg' => '#abd7a2', 'text' => '#333333'], 
                                                'bayi'          => ['bg' => '#e8d8ff', 'text' => '#333333'], 
                                                'umroh'         => ['bg' => '#A9A9A9', 'text' => '#333333'], 
                                                'sewa_toko'     => ['bg' => '#ffd0e5', 'text' => '#333333'], 
                                                'sawah'         => ['bg' => '#f09bab', 'text' => '#333333'], 
                                                'kondangan'     => ['bg' => '#7ae7ff', 'text' => '#333333'], 
                                                'lainnya'       => ['bg' => '#eac58f', 'text' => '#333333'], 
                                            ];

                                            $colorSet = $customColors[$baseKategori] ?? ['bg' => '#AAAAAA', 'text' => '#333333'];
                                        @endphp
                                        
                                        <span class="badge" style="
                                            background-color: {{ $colorSet['bg'] }};
                                            color: {{ $colorSet['text'] }};
                                            padding: 0.35em 0.65em;
                                            font-weight: 700;
                                            line-height: 1;
                                            text-align: center;
                                            white-space: nowrap;
                                            vertical-align: baseline;
                                            border-radius: 0.25rem;">
                                            {{ $displayKategori }}
                                        </span>
                                    </td>                                
                                    <td>{{ Str::limit($item->deskripsi, 50, '...') }}</td>                                    
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch ($item->status) {
                                                case 'ada':
                                                    $statusClass = 'bg-primary text-white'; 
                                                    break;
                                                case 'terjual':
                                                    $statusClass = 'bg-info text-white'; 
                                                    break;
                                                case 'hilang':
                                                    $statusClass = 'bg-secondary text-white'; 
                                                    break;
                                                default:
                                                    $statusClass = 'bg-light text-dark';
                                                    break;
                                            }
                                        @endphp
                                        
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex" style="gap: 5px;">
                                            <a href="{{ url('/saham/' . $item->id . '/edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="{{ url('/saham/' . $item->id) }}" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#confirmationDelete-{{ $item->id }}"> 
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td> 
                                </tr>

                            @include('pages.saham.delete') 

                            @empty
                                <tr>
                                    <td colspan="9"> 
                                        <p class="pt-3 text-center">Tidak ada data</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        const displaySaldo = document.getElementById('displaySaldo');
        const realSaldo = document.getElementById('realSaldo');

        displaySaldo.addEventListener('keyup', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            
            realSaldo.value = value;

            if (value !== "") {
                this.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                this.value = "";
            }
        });
    </script>
@endpush
@endsection