@extends('layouts.seller')
@section('title', 'Dashboard - Scentscape')

@section('content')
<div class="mb-6 px-4 md:px-6 lg:px-10">
    <h1 class="text-3xl font-semibold text-[#414833] flex items-center gap-3">
        <i class="fa-solid fa-gauge"></i> Selamat datang di Dashboard
    </h1>
    <p class="text-[#9BAF9A] text-sm mt-1">Toko kamu terlihat wangi hari ini 🌿</p>
</div>

<!-- Ringkasan -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 px-4 md:px-6 lg:px-10">
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#9BAF9A] text-white">
            <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Total Penjualan</p>
            <p class="text-lg font-semibold text-[#3E3A39]">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#BFA6A0] text-white">
            <i class="fa-solid fa-bag-shopping text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Pesanan Masuk</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $pesananMasuk }} Pesanan</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#D6C6B8] text-white">
            <i class="fa-solid fa-truck-fast text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Produk Terjual</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $produkTerjual }} Produk</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#9BAF9A] text-white">
            <i class="fa-solid fa-box text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Total Stok Produk</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $totalStokProduk }} Produk</p>
        </div>
    </div>
</div>

<!-- Highlight aktivitas -->
<div class="bg-[#9BAF9A]/10 border-l-4 border-[#9BAF9A] text-[#414833] p-4 md:p-5 rounded-lg mb-6 mx-4 md:mx-6 lg:mx-10">
    <p class="text-sm">
        Hari ini kamu mendapatkan <span class="font-bold">{{ $pesananBaruHariIni }} pesanan baru</span> dan <span class="font-bold">{{ $produkTerkirimHariIni }} produk</span> dikirim ke pembeli. Tetap semangat! 🌟
    </p>
</div>

<!-- Chart Penjualan Mingguan -->
<div class="bg-white rounded-xl shadow p-6 mt-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <p class="font-semibold text-[#3E3A39]">Statistik Penjualan Mingguan</p>
        <div class="text-sm text-gray-500" id="chart-period">
            Loading...
        </div>
    </div>
    
    <!-- Canvas untuk Chart -->
    <canvas id="salesChart" height="100"></canvas>
    
    <!-- Loading indicator -->
    <div id="chart-loading" class="text-center py-8 text-gray-500">
        <i class="fa-solid fa-spinner fa-spin"></i>
        <p class="mt-2">Memuat data penjualan...</p>
    </div>
    
    <!-- Summary mingguan -->
    <div id="weekly-summary" class="mt-4 p-3 bg-gray-50 rounded-lg hidden">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Total Penjualan Minggu Ini:</span>
                <p class="font-semibold text-[#414833]" id="total-sales">Rp 0</p>
            </div>
            <div>
                <span class="text-gray-600">Total Pesanan Minggu Ini:</span>
                <p class="font-semibold text-[#414833]" id="total-orders">0 pesanan</p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Chart -->
<script>
// Pastikan hanya ada satu instance chart
let salesChartInstance = null;
let isChartInitialized = false;

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart');
    const loadingElement = document.getElementById('chart-loading');
    const summaryElement = document.getElementById('weekly-summary');
    const periodElement = document.getElementById('chart-period');
    
    if (!ctx) return;

    // Cegah inisialisasi berulang
    if (isChartInitialized) {
        return;
    }

    // Destroy chart lama jika ada
    if (salesChartInstance) {
        salesChartInstance.destroy();
        salesChartInstance = null;
    }

    // Inisialisasi chart HANYA SEKALI dengan data loading state
    salesChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: [0, 0, 0, 0, 0, 0, 0],
                borderColor: '#9BAF9A',
                backgroundColor: 'rgba(155, 175, 154, 0.2)',
                tension: 0.4,
                pointBackgroundColor: '#9BAF9A',
                pointBorderColor: '#9BAF9A',
                pointRadius: 5,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 0 // Matikan animasi untuk menghindari bergetar
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Penjualan: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            }
        }
    });

    // Mark sebagai sudah diinisialisasi
    isChartInitialized = true;

    // Fungsi untuk load data dari API (HANYA SEKALI)
    async function loadWeeklySales() {
        // Cegah multiple API calls
        if (loadWeeklySales.isLoading) {
            return;
        }
        loadWeeklySales.isLoading = true;

        try {
            const response = await fetch('{{ route("seller.dashboard.weekly-sales") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            
            if (result.success && salesChartInstance) {
                // Update data chart TANPA re-render
                salesChartInstance.data.labels = result.data.labels;
                salesChartInstance.data.datasets[0].data = result.data.sales;
                
                // Update chart dengan mode 'none' untuk menghindari animasi bergetar
                salesChartInstance.update('none');

                // Update summary
                if (document.getElementById('total-sales')) {
                    document.getElementById('total-sales').textContent = 
                        'Rp ' + new Intl.NumberFormat('id-ID').format(result.data.total_sales);
                }
                
                if (document.getElementById('total-orders')) {
                    document.getElementById('total-orders').textContent = 
                        result.data.total_orders + ' pesanan';
                }
                
                // Update periode
                if (periodElement) {
                    periodElement.textContent = result.data.periode.mulai + ' - ' + result.data.periode.selesai;
                }
                
                // Hide loading, show summary
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }
                if (summaryElement) {
                    summaryElement.classList.remove('hidden');
                }
                
            } else {
                throw new Error(result.message || 'Gagal memuat data');
            }

        } catch (error) {
            console.error('Error loading weekly sales:', error);
            
            // Show error state
            if (loadingElement) {
                loadingElement.innerHTML = '<i class="fa-solid fa-exclamation-triangle text-red-500"></i><p class="mt-2 text-red-500">Gagal memuat data. Silakan refresh halaman.</p>';
            }
        } finally {
            loadWeeklySales.isLoading = false;
        }
    }

    // Load data hanya sekali setelah DOM ready
    loadWeeklySales();
});

// Cleanup yang proper saat page unload
window.addEventListener('beforeunload', function() {
    if (salesChartInstance) {
        salesChartInstance.destroy();
        salesChartInstance = null;
        isChartInitialized = false;
    }
});

// Prevent multiple event listener registration
if (window.chartEventListenerAdded) {
    // Sudah ada event listener, skip
} else {
    window.chartEventListenerAdded = true;
    
    // Handle visibility change untuk mencegah re-render saat tab switch
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            // Tab disembunyikan, pause animations jika ada
            if (salesChartInstance) {
                Chart.defaults.animation = false;
            }
        } else {
            // Tab ditampilkan kembali
            if (salesChartInstance) {
                Chart.defaults.animation = false; // Tetap matikan animasi
            }
        }
    });
}
</script>
@endsection