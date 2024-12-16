@extends('admin.layout.sidebar')

@section('title', 'Track Penjualan')

@section('content')
<div class="container">
    <h1>Track Penjualan, Pemasukan, dan Pengeluaran</h1>

    <!-- Diagram Garis -->
    <div class="chart-section" style="margin-top: 30px">
        <h3 class="text-center" style="margin-bottom: 10px;">📈 Penjualan per Bulan</h3>
        <div style="display: flex; justify-content: start; align-items: flex-start; gap: 20px;">
            <div style="width: 80%; max-width: 600px; height: 400px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px; padding: 15px; background-color: #fff;">
                <canvas id="salesChart"></canvas>
            </div>
            <div class="details-box" style="width: 25%; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                <h4>Detail Penjualan Bulanan</h4>
                <ul id="salesDetails" style="list-style-type: none; padding: 0;">
                    <!-- Data persentase akan dimasukkan di sini -->
                </ul>
            </div>
        </div>
    </div>

    <!-- Diagram Batang -->
    <div class="chart-section" style="margin-top: 30px">
        <h3 class="text-center" style="margin-bottom: 10px;">📊 Pemasukan dan Pengeluaran</h3>
        <div style="display: flex; justify-content: start; align-items: flex-start; gap: 20px;">
            <div style="width: 60%; max-width: 600px; height: 400px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px; padding: 15px; background-color: #fff;">
                <canvas id="incomeExpenseChart"></canvas>
            </div>
            <div class="details-box" style="width: 35%; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                <h4>Detail Pemasukan dan Pengeluaran</h4>
                <ul id="incomeExpenseDetails" style="list-style-type: none; padding: 0;">
                    <!-- Data persentase akan dimasukkan di sini -->
                </ul>
            </div>
        </div>
    </div>

    <!-- Diagram Lingkaran -->
    <!-- Diagram Lingkaran -->
    <div class="chart-section" style="margin-top: 30px;">
        <h3 class="text-center" style="margin-bottom: 10px;">🍕 Persentase Penjualan per Menu</h3>
        <div style="display: flex; justify-content: start; align-items: flex-start; gap: 20px;">
            <div style="width: 60%; max-width: 600px; height: 400px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px; padding: 15px; background-color: #fff;">
                <canvas id="salesPieChart"></canvas>
            </div>
            <div class="details-box" style="width: 35%; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                <h4>Detail Penjualan per Menu</h4>
                <ul id="menuDetails" style="list-style-type: none; padding: 0;">
                    <!-- Data persentase akan dimasukkan di sini -->
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const months = @json($months);
    const salesData = @json($salesPerMonth);
    const incomeData = @json($incomePerMonth);
    const expenseData = @json($expensePerMonth);
    const salesPerMenu = @json($salesPerMenu);

    // Gradient Helper
    const createGradient = (ctx, height, color1, color2) => {
        let gradient = ctx.createLinearGradient(0, 0, 0, height);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    };

    // Fungsi Persentase
    const calculatePercentage = (data, total) => ((data / total) * 100).toFixed(2);

    // Diagram Garis: Penjualan per Bulan
    const totalSales = Object.values(salesData).reduce((a, b) => a + b, 0);
    const salesDetails = document.getElementById('salesDetails');
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesGradient = createGradient(salesCtx, 400, 'rgba(0, 123, 255, 0.5)', 'rgba(0, 123, 255, 0)');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Total Penjualan',
                data: months.map((_, index) => salesData[index + 1] || 0),
                borderColor: 'blue',
                backgroundColor: salesGradient,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                },
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.1)' },
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.1)' },
                }
            }
        }
    });

    months.forEach((month, i) => {
        const sales = salesData[i + 1] || 0;
        const percentage = calculatePercentage(sales, totalSales);
        salesDetails.innerHTML += `<li>${month}: ${sales} penjualan (${percentage}%)</li>`;
    });

    // Diagram Batang: Pemasukan dan Pengeluaran
    const totalIncome = Object.values(incomeData).reduce((a, b) => a + b, 0);
    const incomeExpenseDetails = document.getElementById('incomeExpenseDetails');
    const incomeCtx = document.getElementById('incomeExpenseChart').getContext('2d');
    new Chart(incomeCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: months.map((_, index) => incomeData[index + 1] || 0),
                    backgroundColor: 'rgba(0, 200, 83, 0.7)',
                    borderRadius: 8
                },
                {
                    label: 'Pengeluaran',
                    data: months.map((_, index) => expenseData[index + 1] || 0),
                    backgroundColor: 'rgba(244, 67, 54, 0.7)',
                    borderRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                },
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.1)' },
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.1)' },
                }
            }
        }
    });

    months.forEach((month, i) => {
        const income = incomeData[i + 1] || 0;
        const expense = expenseData[i + 1] || 0;
        incomeExpenseDetails.innerHTML += `<li>${month}: Pemasukan ${income} (${calculatePercentage(income, totalIncome)}%), Pengeluaran ${expense}</li>`;
    });

    // Diagram Lingkaran: Penjualan per Menu
    const totalMenuSales = Object.values(salesPerMenu).reduce((a, b) => a + b, 0);
    const menuDetails = document.getElementById('menuDetails');
    const pieCtx = document.getElementById('salesPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(salesPerMenu),
            datasets: [{
                label: 'Penjualan',
                data: Object.values(salesPerMenu),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#F44336', '#9C27B0'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                },
            },
        }
    });

    const menuColors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#F44336', '#9C27B0'
    ]; // Warna yang digunakan di pie chart

    Object.entries(salesPerMenu).forEach(([menu, value], index) => {
        const percentage = calculatePercentage(value, totalMenuSales);
        menuDetails.innerHTML += `<li><span style="color: ${menuColors[index]}">${menu}</span>: ${value} penjualan (${percentage}%)</li>`;
    });
</script>

<style>
    /* Styling untuk box detail */
    .details-box {
        width: 35%;
        padding: 20px;
        background-color: #f0f8ff; /* Warna latar belakang lebih lembut */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Efek hover */
    }

    .details-box:hover {
        transform: scale(1.05); /* Efek zoom */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Efek shadow lebih kuat */
    }

    h4 {
        color: #333; /* Warna teks yang kontras */
        font-size: 1.25em; /* Ukuran font yang sedikit lebih besar */
        margin-bottom: 15px;
    }

    /* Styling untuk list item */
    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    li {
        display: flex;
        align-items: center;
        font-size: 1em;
        margin-bottom: 10px;
        color: #555; /* Warna teks lebih soft */
    }

    li:before {
        content: '🔹'; /* Menggunakan icon bullet untuk menarik perhatian */
        margin-right: 10px;
    }

    /* Styling untuk item yang disorot */
    li span {
        font-weight: bold;
        color: #007bff; /* Warna biru untuk highlight */
    }

    /* Styling untuk chart section */
    .chart-section {
        margin-top: 30px;
    }
</style>
@endsection
