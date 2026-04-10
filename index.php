<?php
$data = json_decode(file_get_contents('data.json'), true);
$latest = end($data['history']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Tavuk Döner Endeksi | Veri Analizi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg: #0f111a;
            --card-bg: #161926;
            --text-main: #ffffff;
            --text-dim: #94a3b8;
            --accent: #f97316; /* Döner Turuncusu */
            --chart-blue: #38bdf8;
            --danger: #ef4444;
            --success: #22c55e;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Başlık Alanı */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px 0;
            border-bottom: 1px solid #2d3142;
            margin-bottom: 40px;
        }

        .logo-area h1 { font-size: 2.5rem; margin: 0; font-weight: 900; letter-spacing: -1px; }
        .logo-area p { color: var(--text-dim); margin: 5px 0 0 0; }

        /* Ana İstatistikler */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #2d3142;
            transition: transform 0.3s ease;
        }

        .stat-card:hover { transform: translateY(-5px); }
        .stat-label { font-size: 0.85rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px; }
        .stat-value { font-size: 2rem; font-weight: 800; margin: 10px 0; }
        .stat-sub { font-size: 0.9rem; }

        /* Grafik Konteynırları */
        .chart-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .chart-container {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #2d3142;
        }

        /* Footer Referansları */
        footer {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid #2d3142;
            text-align: center;
            color: var(--text-dim);
        }

        .profile-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .profile-link:hover { text-decoration: underline; }

        @media (max-width: 900px) {
            .chart-section { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="dashboard">
    <header>
        <div class="logo-area">
            <h1>🌯 Tavuk Döner Endeksi</h1>
            <p>Hüseyin Furkan Mıklar tarafından hazırlanan ekonomik veri seti</p>
        </div>
        <div style="text-align: right">
            <div class="stat-label">Son Güncelleme</div>
            <div style="font-weight: bold"><?php echo $data['last_update']; ?></div>
        </div>
    </header>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Güncel Fiyat (TL)</div>
            <div class="stat-value">₺<?php echo $latest['price']; ?></div>
            <div class="stat-sub trend-up" style="color: var(--danger)">↑ %<?php echo number_format((($latest['price'] / $data['history'][0]['price']) - 1) * 100, 0); ?> Artış</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Dolar Bazlı</div>
            <div class="stat-value">$<?php echo $latest['usd']; ?></div>
            <div class="stat-sub">Global Satın Alma Gücü</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Asgari Ücret / Döner</div>
            <div class="stat-value"><?php echo $latest['min_wage_qty']; ?> Adet</div>
            <div class="stat-sub" style="color: var(--danger)">Kritik Eşik: 80 Altı Zor Dönem</div>
        </div>
    </div>

    <div class="chart-section">
        <div class="chart-container">
            <h3 style="margin-top:0">📈 Fiyat Analizi (TL vs USD)</h3>
            <canvas id="mainChart"></canvas>
        </div>
        <div class="chart-container">
            <h3 style="margin-top:0">💰 200 TL Ne Alır?</h3>
            <canvas id="purchasingPowerChart"></canvas>
        </div>
    </div>

    <div class="chart-container" style="margin-top: 20px;">
        <h3>📊 Tarihsel Veri Tablosu</h3>
        <table style="width:100%; border-collapse: collapse; text-align: left;">
            <tr style="color: var(--text-dim); border-bottom: 1px solid #2d3142;">
                <th style="padding: 15px 0;">Dönem</th>
                <th>Fiyat (₺)</th>
                <th>Fiyat ($)</th>
                <th>Maaş/Döner</th>
            </tr>
            <?php foreach(array_reverse($data['history']) as $row): ?>
            <tr style="border-bottom: 1px solid #1e2235;">
                <td style="padding: 15px 0;"><?php echo $row['date']; ?></td>
                <td style="font-weight: bold;">₺<?php echo $row['price']; ?></td>
                <td>$<?php echo $row['usd']; ?></td>
                <td><?php echo $row['min_wage_qty']; ?> adet</td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <footer>
        <p>Geliştiren: <strong><?php echo $data['author']; ?></strong></p>
        <p>
            <a href="<?php echo $data['links']['web']; ?>" class="profile-link">GökBörü Project</a> | 
            <a href="<?php echo $data['links']['linkedin']; ?>" class="profile-link">LinkedIn</a>
        </p>
        <p style="font-size: 0.8rem; margin-top: 20px;">Bu veriler kişisel gözlemlere dayanmaktadır. Yatırım tavsiyesi değildir.</p>
    </footer>
</div>

<script>
// Ana Grafik (TL & USD)
const mainCtx = document.getElementById('mainChart').getContext('2d');
new Chart(mainCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($data['history'], 'date')); ?>,
        datasets: [{
            label: 'Fiyat (TL)',
            data: <?php echo json_encode(array_column($data['history'], 'price')); ?>,
            borderColor: '#f97316',
            backgroundColor: 'rgba(249, 115, 22, 0.1)',
            fill: true,
            yAxisID: 'y',
        }, {
            label: 'Fiyat ($)',
            data: <?php echo json_encode(array_column($data['history'], 'usd')); ?>,
            borderColor: '#38bdf8',
            borderDash: [5, 5],
            fill: false,
            yAxisID: 'y1',
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { type: 'linear', display: true, position: 'left', grid: { color: '#1e2235' } },
            y1: { type: 'linear', display: true, position: 'right', grid: { drawOnChartArea: false } }
        },
        plugins: { legend: { labels: { color: '#fff' } } }
    }
});

// Satın Alma Gücü (200 TL ile kaç adet?)
const pCtx = document.getElementById('purchasingPowerChart').getContext('2d');
new Chart(pCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($data['history'], 'date')); ?>,
        datasets: [{
            label: 'Adet',
            data: <?php echo json_encode(array_map(function($p){ return 200/$p; }, array_column($data['history'], 'price'))); ?>,
            backgroundColor: '#22c55e'
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { grid: { color: '#1e2235' } } }
    }
});
</script>

</body>
</html>