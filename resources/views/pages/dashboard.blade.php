@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
    $currentMonth = $filterDate ?? Carbon::now()->format('Y-m');
@endphp
@if ($errors->any())
        @dd($errors->all())
    @endif

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<div class="row mb-4">
    <div class="col-md-4">
        <form id="filterForm" method="GET" action="{{ url('/dashboard') }}">
            <div class="input-group">
                <input type="text" 
                       id="monthYearPicker" 
                       name="filter_date" 
                       class="form-control bg-light border-0 small" 
                       placeholder="Filter Bulan & Tahun"
                       value="{{ request('filter_date') ?? \Carbon\Carbon::now()->format('Y-m') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-filter fa-sm"></i> Filter
                    </button>
                    <a href="{{ url('/dashboard') }}" class="btn btn-danger">
                        <i class="fas fa-times fa-sm"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-uppercase mb-1">
                    <h6 class="m-0 font-weight-bold text-primary">Total Aset</h6>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Harga Beli Aset: Rp {{ number_format($totalHargaBeliAset ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
                <h10 class="text-success">
                    Keuntungan Aset: Rp {{ number_format($totalKeuntunganAset ?? 0, 0, ',', '.') }}
                </h10>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-uppercase mb-1">
                    <h6 class="m-0 font-weight-bold text-primary">Total Saham</h6>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Harga Beli Saham: Rp {{ number_format($totalHargaBeliSaham ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
                <h10 class="text-success">
                    Keuntungan Saham: Rp {{ number_format($totalKeuntunganSaham ?? 0, 0, ',', '.') }}
                </h10>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-uppercase mb-1">
                    <h6 class="m-0 font-weight-bold text-primary">Total Income</h6>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Pemasukan Income: Rp {{ number_format($totalPemasukanIncome ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Pengeluaran Income: Rp {{ number_format($totalPengeluaranIncome ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-uppercase mb-1">
                    <h6 class="m-0 font-weight-bold text-primary">Total Maintenance</h6>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Pemasukan Maintenance: Rp {{ number_format($totalPemasukanMaintenance ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Pengeluaran Maintenance: Rp {{ number_format($totalPengeluaranMaintenance ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-uppercase mb-1">
                    <h6 class="m-0 font-weight-bold text-primary">Total Saving</h6>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Pemasukan Saving: Rp {{ number_format($totalPemasukanSaving ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
                <div class="mb-0 font-weight-bold text-gray-800">
                    <h10 class="">
                        Pengeluaran Saving: Rp {{ number_format($totalPengeluaranSaving ?? 0, 0, ',', '.') }}
                    </h10>                
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Grafik Aset
                </h6>
            </div>
            <div class="card-body">
                <canvas id="asetChart"></canvas> 
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Grafik Saham
                </h6>
            </div>
            <div class="card-body">
                <canvas id="sahamChart"></canvas> 
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Grafik Income
                </h6>
            </div>
            <div class="card-body">
                <canvas id="incomeChart"></canvas> 
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Grafik Maintenance
                </h6>
            </div>
            <div class="card-body">
                <canvas id="maintenanceChart"></canvas> 
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Grafik Saving
                </h6>
            </div>
            <div class="card-body">
                <canvas id="savingChart"></canvas> 
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#monthYearPicker", {
                dateFormat: "Y-m",
                plugins: [
                    new monthSelectPlugin({ 
                        shorthand: true,
                        dateFormat: "Y-m",
                        altFormat: "F Y",
                        theme: "light"
                    })
                ],
            });
        });
        //CHART ASET
        const asetLabels = @json(collect($grafikAset ?? [])->pluck('nama_aset')->values()); 
        const asetHargaBeli = @json(collect($grafikAset ?? [])->pluck('harga_beli')->values()); 
        const asetKeuntungan = @json(collect($grafikAset ?? [])->pluck('keuntungan_hitung')->values());

        new Chart(document.getElementById('asetChart'), {
            type: 'bar',
            data: {
                labels: asetLabels,
                datasets: [
                    {
                        label: 'Harga Beli Aset',
                        data: asetHargaBeli,
                        backgroundColor: 'rgba(255, 218, 193, 0.7)',
                        borderColor: 'rgba(255, 218, 193, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Keuntungan Aset',
                        data: asetKeuntungan,
                        backgroundColor: 'rgba(173, 216, 230, 0.7)',
                        borderColor: 'rgba(173, 216, 230, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        //CHART SAHAM
        const sahamLabels = @json(collect($grafikSaham ?? [])->pluck('nama_saham')->values()); 
        const sahamHargaBeli = @json(collect($grafikSaham ?? [])->pluck('harga_beli')->values()); 
        const sahamKeuntungan = @json(collect($grafikSaham ?? [])->pluck('keuntungan_hitung')->values());

        new Chart(document.getElementById('sahamChart'), {
            type: 'bar',
            data: {
                labels: sahamLabels,
                datasets: [
                    {
                        label: 'Harga Beli Saham',
                        data: sahamHargaBeli,
                        backgroundColor: 'rgba(255, 218, 193, 0.7)',
                        borderColor: 'rgba(255, 218, 193, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Keuntungan Saham',
                        data: sahamKeuntungan,
                        backgroundColor: 'rgba(173, 216, 230, 0.7)',
                        borderColor: 'rgba(173, 216, 230, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        //INCOME
        const incomeLabels = @json(collect($grafikIncome ?? [])->pluck('nama_income')->values()); 
        const incomePemasukan = @json(collect($grafikIncome ?? [])->pluck('total_pemasukan')->values()); 
        const incomePengeluaran = @json(collect($grafikIncome ?? [])->pluck('total_pengeluaran')->values());

        new Chart(document.getElementById('incomeChart'), {
            type: 'bar',
            data: {
                labels: incomeLabels,
                datasets: [
                    {
                        label: 'Pemasukan income',
                        data: incomePemasukan,
                        backgroundColor: 'rgba(255, 218, 193, 0.7)',
                        borderColor: 'rgba(255, 218, 193, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran income',
                        data: incomePengeluaran,
                        backgroundColor: 'rgba(173, 216, 230, 0.7)',
                        borderColor: 'rgba(173, 216, 230, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        //MAINTENANCE
        const maintenanceLabels = @json(collect($grafikMaintenance ?? [])->pluck('nama_maintenance')->values()); 
        const maintenancePemasukan = @json(collect($grafikMaintenance ?? [])->pluck('total_pemasukan')->values()); 
        const maintenancePengeluaran = @json(collect($grafikMaintenance ?? [])->pluck('total_pengeluaran')->values());

        new Chart(document.getElementById('maintenanceChart'), {
            type: 'bar',
            data: {
                labels: maintenanceLabels,
                datasets: [
                    {
                        label: 'Pemasukan maintenance',
                        data: maintenancePemasukan,
                        backgroundColor: 'rgba(255, 218, 193, 0.7)',
                        borderColor: 'rgba(255, 218, 193, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran maintenance',
                        data: maintenancePengeluaran,
                        backgroundColor: 'rgba(173, 216, 230, 0.7)',
                        borderColor: 'rgba(173, 216, 230, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        //SAVING
        const savingLabels = @json(collect($grafikSaving ?? [])->pluck('nama_saving')->values()); 
        const savingPemasukan = @json(collect($grafikSaving ?? [])->pluck('total_pemasukan')->values()); 
        const savingPengeluaran = @json(collect($grafikSaving ?? [])->pluck('total_pengeluaran')->values());

        new Chart(document.getElementById('savingChart'), {
            type: 'bar',
            data: {
                labels: savingLabels,
                datasets: [
                    {
                        label: 'Pemasukan saving',
                        data: savingPemasukan,
                        backgroundColor: 'rgba(255, 218, 193, 0.7)',
                        borderColor: 'rgba(255, 218, 193, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran saving',
                        data: savingPengeluaran,
                        backgroundColor: 'rgba(173, 216, 230, 0.7)',
                        borderColor: 'rgba(173, 216, 230, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
        
    </script>
@endpush
