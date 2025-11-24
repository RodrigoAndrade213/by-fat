<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>By Fat - Controle Alimentar</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            text-align: center;
            padding: 40px 20px;
        }
        .logo {
            width: 320px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));
            margin-bottom: 20px;
        }
        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .subtitle {
            font-size: 1.4rem;
            opacity: 0.9;
            margin-bottom: 40px;
        }
        .user-info {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255,255,255,0.2);
            padding: 12px 25px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            font-weight: 600;
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }
        .card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            border-radius: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .card:hover {
            transform: translateY(-15px);
            background: rgba(255,255,255,0.25);
        }
        .card h3 {
            font-size: 1.6rem;
            margin-bottom: 15px;
        }
        .card a {
            color: white;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 600;
            display: block;
            padding: 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 15px;
            margin-top: 15px;
            transition: 0.3s;
        }
        .card a:hover {
            background: rgba(255,255,255,0.4);
            transform: scale(1.05);
        }
        footer {
            text-align: center;
            padding: 40px;
            margin-top: 60px;
            opacity: 0.8;
            font-size: 1.1rem;
        }
        @media (max-width: 768px) {
            h1 { font-size: 2.8rem; }
            .logo { width: 280px; }
            .user-info { position: static; margin: 20px auto; display: inline-block; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            Olá, <strong><?=htmlspecialchars($_SESSION['usuario_nome'])?></strong> | 
            <a href="logout.php" style="color:#fff;">Sair</a>
        </div>

        <header>
    <!-- Só a logo, sem repetir o título -->
    <img src="assets/logo.png?v=1" alt="By Fat - Com Rodrigo Andrade" class="logo" style="width:420px; margin-bottom:10px;">

    <!-- Subtítulo menor e mais elegante, centralizado -->
    <p class="subtitle" style="font-size:1.5rem; opacity:0.95; margin-top:-10px;">
        Seu controle alimentar inteligente
    </p>
</header>

        <div class="menu">
            <div class="card">
                <h3>Dashboard</h3>
                <p>Gráficos e metas diárias</p>
                <a href="dashboard.php">Acessar Dashboard</a>
            </div>

            <div class="card">
                <h3>Registrar Refeição</h3>
                <p>Adicionar alimentos consumidos</p>
                <a href="registrar_refeicao.php">Registrar Agora</a>
            </div>

            <div class="card">
                <h3>Minhas Refeições</h3>
                <p>Histórico completo organizado</p>
                <a href="minhas_refeicoes.php">Ver Histórico</a>
            </div>

            <div class="card">
                <h3>Cadastrar Alimento</h3>
                <p>Adicionar novos alimentos</p>
                <a href="cadastro_alimento.php">Cadastrar</a>
            </div>
        </div>

        <footer>
            By Fat — Projeto Final de Banco de Dados<br>
            Desenvolvido por Rodrigo Andrade © 2025
        </footer>
    </div>
</body>
</html>