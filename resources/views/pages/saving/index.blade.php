@extends('layouts.app')

@section('content')
    @php
        use Illuminate\Support\Carbon;
        use Illuminate\Support\Str;
    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Saving</h1>
        <a href="{{ url('/saving/create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
        </a>
    </div>

    <div class="alert alert-info mt-3">
        <strong>Total Pemasukan:</strong> Rp {{ number_format($total_pemasukan, 0, ',', '.') }} <br>
        <strong>Total Pengeluaran:</strong> Rp {{ number_format($total_pengeluaran, 0, ',', '.') }} <br>
        <strong>Saldo :</strong> Rp {{ number_format($totalSemuaSaving, 0, ',', '.') }}   
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
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                    <th>Kategori</th> 
                                    <th>Penyimpanan</th>                                    
                                    <th>Deskripsi</th>                                     
                                    <th>Status</th>
                                    <th style="width: 100px;">Aksi</th> 
                                </tr>
                            </thead>
                            
                            <tbody>
                            @forelse ($savings as $item) 
                                <tr>
                                    <td>{{ $item->nama_saving }}</td> 
                                    <td>{{ Carbon::parse($item->tanggal_beli)->format('d-m-Y') }}</td>
                                    <td>Rp {{ number_format($item->pemasukan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                        
                                    <td>
                                        @php
                                            $displayKategori = ($item->kategori === 'lainnya' && !empty($item->kategori_kustom))
                                                ? ucwords($item->kategori_kustom) 
                                                : ucwords(str_replace('_', ' ', $item->kategori)); 

                                            $baseKategori = $item->kategori; 
                                            $customColors = [
                                                'guru'  => ['bg' => '#8c9140', 'text' => '#333333'], 
                                                'modal_usaha'=> ['bg' => '#ffa07a', 'text' => '#333333'], 
                                                'cash'  => ['bg' => '#abd7a2', 'text' => '#333333'], 
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
                                    <td>{{ $item->penyimpanan_saving }}</td> 
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
                                            <a href="{{ url('/saving/' . $item->id . '/edit') }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="{{ url('/saving/' . $item->id) }}" >
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

                            @include('pages.saving.delete') 

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
@endsection