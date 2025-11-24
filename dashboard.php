<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'];
$meta_diaria = 2200;

$hoje = date('Y-m-d');
$stmt = $pdo->prepare("
    SELECT COALESCE(SUM(r.QUANTIDADE * a.CALORIAS_POR_UNIDADE), 0)
    FROM Refeicao r
    JOIN Alimento a ON r.ALIMENTO_CODIGO = a.CODIGO
    WHERE r.USUARIO_CODIGO = ? AND r.DATA = ?
");
$stmt->execute([$usuario_id, $hoje]);
$total_hoje = $stmt->fetchColumn();

$labels = $calorias = [];
for ($i = 6; $i >= 0; $i--) {
    $data = date('Y-m-d', strtotime("-$i days"));
    $data_br = date('d/m', strtotime($data));
    $dia_semana = ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'][date('w', strtotime($data))];

    $stmt->execute([$usuario_id, $data]);
    $cal = $stmt->fetchColumn();

    $labels[] = "$dia_semana\n$data_br";
    $calorias[] = round($cal, 1);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - By Fat</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#1e3a8a 0%,#3b82f6 100%);
            min-height:100vh;color:white;
        }
        .container{max-width:1200px;margin:0 auto;padding:20px;}
        header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;}
        .logo-pequena{width:180px;}
        .user-info{background:rgba(255,255,255,0.2);padding:10px 25px;border-radius:50px;backdrop-filter:blur(10px);font-weight:600;}
        .user-info a{color:#fff;text-decoration:none;margin-left:15px;}
        .card{background:rgba(255,255,255,0.15);backdrop-filter:blur(15px);border-radius:20px;padding:35px;box-shadow:0 15px 35px rgba(0,0,0,0.3);margin-bottom:30px;}
        h1{font-size:2.6rem;text-align:center;margin-bottom:10px;}
        .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:25px;margin:30px 0;}
        .stat-card{background:rgba(255,255,255,0.25);border-radius:18px;padding:28px;text-align:center;backdrop-filter:blur(12px);box-shadow:0 8px 25px rgba(0,0,0,0.2);}
        .big{font-size:3.4rem;font-weight:800;margin:12px 0;letter-spacing:-1px;}
        .progress{height:22px;background:rgba(255,255,255,0.3);border-radius:11px;overflow:hidden;margin:18px 0;border:2px solid rgba(255,255,255,0.2);}
        .bar{height:100%;background:#00bfa5;border-radius:11px;width:<?=min(100,($total_hoje/$meta_diaria)*100)?>%;transition:width 1.8s ease;}
        .status-dentro{color:#51cf66 !important;font-weight:900;text-shadow:0 0 10px rgba(81,207,102,0.6), 0 0 20px white;-webkit-text-stroke:1.5px white;}
        .status-acima{color:#ff6b6b !important;font-weight:900;text-shadow:0 0 10px rgba(255,107,107,0.6), 0 0 20px white;-webkit-text-stroke:1.5px white;}
        .chart-container{padding:30px;background:rgba(255,255,255,0.1);border-radius:20px;}
        canvas{max-height:420px;}
        .voltar{text-align:center;margin:50px 0;}
        .voltar a{color:#a0d8ff;font-size:1.3rem;text-decoration:none;transition:0.3s;}
        .voltar a:hover{text-decoration:underline;transform:scale(1.05);}
        footer{text-align:center;padding:50px;opacity:0.85;margin-top:30px;font-size:1.1rem;}
        @media(max-width:768px){
            header{flex-direction:column;text-align:center;}
            .logo-pequena{width:150px;margin-bottom:15px;}
            .big{font-size:2.8rem;}
            .status-dentro,.status-acima{font-size:2.2rem !important;}
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <a href="index.php"><img src="assets/logo.png?v=1" alt="By Fat" class="logo-pequena"></a>
        <div class="user-info">
            Olá, <strong><?=htmlspecialchars($nome)?></strong>
            <a href="logout.php">Sair</a>
        </div>
    </header>

    <div class="card">
        <h1>Dashboard</h1>
        <p style="text-align:center;font-size:1.3rem;opacity:0.9;margin-bottom:30px;">Bem-vindo de volta, <?=htmlspecialchars($nome)?>!</p>

        <div class="stats">
            <div class="stat-card">
                <h3>Calorias Hoje</h3>
                <div class="big"><?=number_format($total_hoje,0)?> <span style="font-size:0.5em;">kcal</span></div>
                <div class="progress"><div class="bar"></div></div>
                <p style="font-size:1.1rem;font-weight:600;"><?=number_format(($total_hoje/$meta_diaria)*100,1)?>% da meta diária</p>
            </div>

            <div class="stat-card">
                <h3>Meta Diária</h3>
                <div class="big"><?=$meta_diaria?> <span style="font-size:0.5em;">kcal</span></div>
            </div>

            <div class="stat-card">
                <h3>Status do Dia</h3>
                <div class="big <?= $total_hoje > $meta_diaria ? 'status-acima' : 'status-dentro' ?>">
                    <?= $total_hoje > $meta_diaria ? 'Acima' : 'Dentro' ?><br>da meta
                </div>
            </div>
        </div>

        <div class="chart-container">
            <h2 style="text-align:center;margin-bottom:25px;font-size:1.8rem;">Calorias nos Últimos 7 Dias</h2>
            <canvas id="grafico"></canvas>
        </div>
    </div>

    <div class="voltar">
        <a href="index.php">← Voltar ao menu principal</a>
    </div>

    <footer>
        By Fat — Projeto Final de Banco de Dados<br>
        Desenvolvido por Rodrigo Andrade © 2025
    </footer>
</div>

<script>
new Chart(document.getElementById('grafico'), {
    type: 'bar',
    data: {
        labels: <?=json_encode($labels)?>,
        datasets: [{
            label: 'Calorias consumidas',
            data: <?=json_encode($calorias)?>,
            backgroundColor: '#00bfa5',
            borderColor: '#ffffff',
            borderWidth: 3,
            borderRadius: 12,
            barThickness: 40
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { backgroundColor: 'rgba(0,0,0,0.8)' }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: 'white' } },
            x: { grid: { display: false }, ticks: { color: 'white', font: { size: 14 } } }
        }
    }
});
</script>
</body>
</html>