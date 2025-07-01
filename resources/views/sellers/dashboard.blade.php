@extends('layouts.seller')
@section('title', 'Dashboard - Scentscape')

@section('content')
<div class="mb-6 px-4 md:px-6 lg:px-10">
    <h1 class="text-3xl font-semibold text-[#414833] flex items-center gap-3">
        <i class="fa-solid fa-gauge"></i> Welcome to your Dashboard
    </h1>
    <p class="text-[#9BAF9A] text-sm mt-1">Your store smells great today 🌿</p>
</div>

<!-- Summary -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 px-4 md:px-6 lg:px-10">
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#9BAF9A] text-white">
            <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Today's Sales</p>
            <p class="text-lg font-semibold text-[#3E3A39]">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#BFA6A0] text-white">
            <i class="fa-solid fa-bag-shopping text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">New Orders</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $pesananMasuk }} Orders</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#D6C6B8] text-white">
            <i class="fa-solid fa-truck-fast text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Products Sold Today</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $produkTerjual }} Products</p>
        </div>
    </div>
    <div class="bg-[#F6F1EB] shadow p-5 rounded-xl flex items-center gap-4">
        <div class="p-3 rounded-full bg-[#9BAF9A] text-white">
            <i class="fa-solid fa-box text-lg"></i>
        </div>
        <div>
            <p class="text-sm text-[#BFA6A0]">Total Product Stock</p>
            <p class="text-lg font-semibold text-[#3E3A39]">{{ $totalStokProduk }} Products</p>
        </div>
    </div>
</div>

<!-- Highlight Activity -->
<div class="bg-[#9BAF9A]/10 border-l-4 border-[#9BAF9A] text-[#414833] p-4 md:p-5 rounded-lg mb-6 mx-4 md:mx-6 lg:mx-10">
    <p class="text-sm">
        Today, you received <span class="font-bold">{{ $pesananBaruHariIni }} new orders</span> and <span class="font-bold">{{ $produkTerkirimHariIni }} products</span> were shipped to buyers. Keep up the great work! 🌟
    </p>
</div>

<!-- Weekly Sales Chart -->
<div class="bg-white rounded-xl shadow p-6 mt-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <p class="font-semibold text-[#3E3A39]">Weekly Sales Statistics</p>
        <div class="text-sm text-gray-500" id="chart-period">
            Loading...
        </div>
    </div>
    
    <canvas id="salesChart" height="100"></canvas>
    
    <div id="chart-loading" class="text-center py-8 text-gray-500">
        <i class="fa-solid fa-spinner fa-spin"></i>
        <p class="mt-2">Loading sales data...</p>
    </div>
    
    <div id="weekly-summary" class="mt-4 p-3 bg-gray-50 rounded-lg hidden">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Total Sales This Week:</span>
                <p class="font-semibold text-[#414833]" id="total-sales">Rp 0</p>
            </div>
            <div>
                <span class="text-gray-600">Total Orders This Week:</span>
                <p class="font-semibold text-[#414833]" id="total-orders">0 orders</p>
            </div>
        </div>
    </div>
</div>

<script>
let salesChartInstance = null;
let isChartInitialized = false;

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');
    const loadingElement = document.getElementById('chart-loading');
    const summaryElement = document.getElementById('weekly-summary');
    const periodElement = document.getElementById('chart-period');

    if (!ctx) return;
    if (isChartInitialized) return;
    if (salesChartInstance) {
        salesChartInstance.destroy();
        salesChartInstance = null;
    }

    salesChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales (Rp)',
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
                duration: 0
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
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
                        label: function (context) {
                            return 'Sales: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            }
        }
    });

    isChartInitialized = true;

    async function loadWeeklySales() {
        if (loadWeeklySales.isLoading) return;
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

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const result = await response.json();

            if (result.success && salesChartInstance) {
                const dayTranslation = {
                    'Sen': 'Mon',
                    'Sel': 'Tue',
                    'Rab': 'Wed',
                    'Kam': 'Thu',
                    'Jum': 'Fri',
                    'Sab': 'Sat',
                    'Min': 'Sun'
                };

                salesChartInstance.data.labels = result.data.labels.map(label => dayTranslation[label] || label);
                salesChartInstance.data.datasets[0].data = result.data.sales;
                salesChartInstance.update('none');

                document.getElementById('total-sales').textContent =
                    'Rp ' + new Intl.NumberFormat('id-ID').format(result.data.total_sales);
                document.getElementById('total-orders').textContent =
                    result.data.total_orders + ' orders';
                if (periodElement) {
                    periodElement.textContent = result.data.periode.mulai + ' - ' + result.data.periode.selesai;
                }

                if (loadingElement) loadingElement.style.display = 'none';
                if (summaryElement) summaryElement.classList.remove('hidden');

            } else {
                throw new Error(result.message || 'Failed to load data');
            }

        } catch (error) {
            console.error('Error loading weekly sales:', error);
            if (loadingElement) {
                loadingElement.innerHTML =
                    '<i class="fa-solid fa-exclamation-triangle text-red-500"></i><p class="mt-2 text-red-500">Failed to load data. Please refresh the page.</p>';
            }
        } finally {
            loadWeeklySales.isLoading = false;
        }
    }

    loadWeeklySales();
});

window.addEventListener('beforeunload', function () {
    if (salesChartInstance) {
        salesChartInstance.destroy();
        salesChartInstance = null;
        isChartInitialized = false;
    }
});

if (!window.chartEventListenerAdded) {
    window.chartEventListenerAdded = true;

    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            if (salesChartInstance) Chart.defaults.animation = false;
        } else {
            if (salesChartInstance) Chart.defaults.animation = false;
        }
    });
}
</script>
@endsection
