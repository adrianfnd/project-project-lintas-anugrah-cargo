@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome, {{ auth()->user()->operator->name }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Total Paket Hari Ini</p>
                        <p class="fs-30 mb-2">{{ $paketHariIni }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Total Paket</p>
                        <p class="fs-30 mb-2">{{ $totalPaket }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Paket Dalam Perjalanan</p>
                        <p class="fs-30 mb-2">{{ $paketDikirim }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Paket Sampai</p>
                        <p class="fs-30 mb-2">{{ $paketSampai }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Ketepatan Waktu</p>
                        <p class="font-weight-500">Grafik ini menunjukkan performa ketepatan waktu pengiriman
                            berdasarkan rata-rata rating per bulan.</p>
                        <select id="time-period-performance" class="col-md-2 mb-3 form-control">
                            <option value="monthly">Bulan</option>
                            <option value="yearly">Tahun</option>
                        </select>
                        <canvas id="performance-chart"></canvas>
                        <div class="mt-3 text-muted">
                            <p><strong>Catatan:</strong></p>
                            <ul>
                                <li>Grafik ini menampilkan rata-rata rating ketepatan waktu pengiriman.</li>
                                <li>Untuk tampilan bulanan, data dikelompokkan per minggu; untuk tahunan, data menunjukkan
                                    total paket per bulan.</li>
                                <li>Garis grafik menunjukkan rata-rata rating</li>
                                <li>Nilai maksimum: 5</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Laporan Paket</p>
                        <p class="font-weight-500">Grafik ini menunjukkan performa laporan paket berdasarkan
                            rata-rata rating per bulan.</p>
                        <select id="time-period" class="col-md-2 mb-3 form-control">
                            <option value="monthly">Bulan</option>
                            <option value="yearly">Tahun</option>
                        </select>
                        <canvas id="paket-chart"></canvas>
                        <div class="mt-3 text-muted">
                            <p><strong>Catatan:</strong></p>
                            <ul>
                                <li>Grafik ini menampilkan jumlah paket yang diproses.</li>
                                <li>Untuk tampilan bulanan, data dikelompokkan per minggu; untuk tahunan, data menunjukkan
                                    total paket per bulan.</li>
                                <li>Batang grafik menunjukkan volume paket, memberikan gambaran tentang pengiriman.
                                </li>
                                <li>Nilai maksimum: 100</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('performance-chart').getContext('2d');
            var performanceChart;

            function fetchPerformanceData(period) {
                fetch(`/operator/dashboard-operator/chart-performance?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        if (performanceChart) {
                            performanceChart.destroy();
                        }
                        performanceChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Ketepatan Waktu',
                                    data: data.data,
                                    borderColor: function(context) {
                                        const index = context.dataIndex;
                                        return index % 2 === 0 ? 'rgba(75, 192, 192, 1)' :
                                            'rgba(255, 99, 132, 1)';
                                    },
                                    segment: {
                                        borderColor: function(context) {
                                            return context.p0.parsed.x % 2 === 0 ?
                                                'rgba(75, 192, 192, 1)' :
                                                'rgba(255, 99, 132, 1)';
                                        },
                                    },
                                    tension: 0.4,
                                    fill: false
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 1200,
                                        title: {
                                            display: true,
                                            text: 'Nilai'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: period === 'monthly' ? 'Minggu' : 'Bulan'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    });
            }

            document.getElementById('time-period-performance').addEventListener('change', function() {
                var period = this.value;
                fetchPerformanceData(period);
            });

            fetchPerformanceData('monthly');
        });


        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('paket-chart').getContext('2d');
            var salesChart;

            function fetchChartData(period) {
                fetch(`/operator/dashboard-operator/chart-paket?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        if (salesChart) {
                            salesChart.destroy();
                        }
                        salesChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: 'Paket',
                                    data: data.data,
                                    backgroundColor: function(context) {
                                        const colors = ['rgba(75, 192, 192, 1)',
                                            'rgba(75, 192, 192, 1)'
                                        ];
                                        return colors[context.dataIndex % colors.length];
                                    },
                                    borderColor: function(context) {
                                        const borderColors = ['rgba(75, 192, 192, 1)',
                                            'rgba(75, 192, 192, 1)'
                                        ];
                                        return borderColors[context.dataIndex % borderColors
                                            .length];
                                    },
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            }

            document.getElementById('time-period').addEventListener('change', function() {
                var period = this.value;
                fetchChartData(period);
            });

            fetchChartData('monthly');
        });
    </script>
@endsection
