<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("
    SELECT DATE(r.DATA) as data_ref, r.TIPO, a.NOME as alimento, r.QUANTIDADE, 
           a.CALORIAS_POR_UNIDADE, (r.QUANTIDADE * a.CALORIAS_POR_UNIDADE) as kcal
    FROM Refeicao r
    JOIN Alimento a ON r.ALIMENTO_CODIGO = a.CODIGO
    WHERE r.USUARIO_CODIGO = ?
    ORDER BY r.DATA DESC, 
             FIELD(r.TIPO,'Café da manhã','Almoço','Lanche da tarde','Jantar','Ceia')
");
$stmt->execute([$usuario_id]);
$refeicoes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Refeições - By Fat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#1e3a8a 0%,#3b82f6 100%);
            min-height:100vh;color:white;
        }
        .container{max-width:1200px;margin:0 auto;padding:20px;}
        header{
            display:flex;justify-content:space-between;align-items:center;
            margin-bottom:30px;flex-wrap:wrap;
        }
        .logo-pequena{width:180px;}
        .user-info{
            background:rgba(255,255,255,0.2);padding:10px 25px;
            border-radius:50px;backdrop-filter:blur(10px);font-weight:600;
        }
        .user-info a{color:#fff;text-decoration:none;margin-left:15px;}
        .card{
            background:rgba(255,255,255,0.15);backdrop-filter:blur(15px);
            border-radius:20px;padding:35px;box-shadow:0 15px 35px rgba(0,0,0,0.3);
            margin-bottom:30px;
        }
        h1{font-size:2.8rem;text-align:center;margin-bottom:10px;}
        .subtitle{text-align:center;font-size:1.4rem;opacity:0.9;margin-bottom:30px;}

        .dia{
            background:rgba(255,255,255,0.15);border-radius:16px;
            padding:25px;margin-bottom:25px;backdrop-filter:blur(10px);
        }
        .dia h2{
            font-size:2rem;color:#fff;margin-bottom:20px;
            display:flex;justify-content:space-between;align-items:center;
            text-shadow:0 2px 10px rgba(0,0,0,0.4);
        }
        .refeicao{
            background:rgba(255,255,255,0.25);border-radius:14px;
            overflow:hidden;margin-bottom:20px;box-shadow:0 8px 25px rgba(0,0,0,0.2);
        }
        .refeicao-header{
            background:#00bfa5;color:white;padding:16px 25px;
            font-size:1.5rem;font-weight:700;text-shadow:0 2px 8px rgba(0,0,0,0.5);
        }
        table{width:100%;border-collapse:collapse;}
        th{
            background:rgba(0,0,0,0.2);padding:16px;text-align:left;
            color:white;font-weight:600;font-size:1.1rem;
        }
        td{padding:14px 16px;border-bottom:1px solid rgba(255,255,255,0.1);}
        tr:hover{background:rgba(255,255,255,0.1);}
        .kcal{font-weight:800;color:#ff6b6b;font-size:1.1rem;}
        .total-refeicao{
            background:rgba(0,191,165,0.3) !important;color:white;font-weight:700;font-size:1.1rem;
        }
        .total-dia{
            background:#1e3a8a;color:white;font-weight:800;font-size:1.5rem;
            text-align:right;
        }
        .empty{
            text-align:center;padding:100px 20px;font-size:1.6rem;opacity:0.8;
        }
        .empty a{
            color:#00bfa5;font-weight:700;text-decoration:none;font-size:1.3rem;
        }
        .voltar{text-align:center;margin:50px 0;}
        .voltar a{
            color:#a0d8ff;font-size:1.4rem;text-decoration:none;
        }
        .voltar a:hover{text-decoration:underline;}
        footer{
            text-align:center;padding:40px;opacity:0.8;font-size:1.1rem;
        }
        @media(max-width:768px){
            header{flex-direction:column;text-align:center;}
            .logo-pequena{width:150px;margin-bottom:15px;}
            .dia h2{flex-direction:column;gap:8px;font-size:1.7rem;}
            th,td{font-size:0.95rem;padding:12px;}
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <a href="index.php"><img src="assets/logo.png?v=1" alt="By Fat" class="logo-pequena"></a>
        <div class="user-info">
            Olá, <strong><?=htmlspecialchars($_SESSION['usuario_nome'])?></strong>
            <a href="logout.php">Sair</a>
        </div>
    </header>

    <div class="card">
        <h1>Minhas Refeições</h1>
        <p class="subtitle">Histórico completo das suas refeições</p>

        <?php if(empty($refeicoes)): ?>
            <div class="empty">
                Nenhuma refeição registrada ainda.<br><br>
                <a href="registrar_refeicao.php">Registrar minha primeira refeição</a>
            </div>
        <?php else: 
            $dia_atual = null;
            $tipo_atual = null;
            $total_dia = 0;
            $total_tipo = 0;

            foreach($refeicoes as $r):
                $data_br = date('d/m/Y', strtotime($r['data_ref']));
                $dia_semana = ucfirst(strftime('%A', strtotime($r['data_ref'])));

                if($dia_atual !== $r['data_ref']):
                    if($dia_atual !== null):
                        echo "<tr class='total-refeicao'><td colspan='2'>Total $tipo_atual</td><td class='kcal'>".number_format($total_tipo,1)." kcal</td></tr>";
                        echo "</tbody></table></div>";
                        echo "<tr class='total-dia'><td colspan='2'><strong>TOTAL DO DIA</strong></td><td class='kcal'>".number_format($total_dia,1)." kcal</td></tr>";
                        echo "</div>";
                    endif;
                    $dia_atual = $r['data_ref'];
                    $total_dia = 0;
                    echo "<div class='dia'>
                          <h2>$data_br <span>$dia_semana</span></h2>";
                endif;

                if($tipo_atual !== $r['TIPO']):
                    if($tipo_atual !== null):
                        echo "<tr class='total-refeicao'><td colspan='2'>Total $tipo_atual</td><td class='kcal'>".number_format($total_tipo,1)." kcal</td></tr>";
                        echo "</tbody></table></div>";
                        $total_tipo = 0;
                    endif;
                    $tipo_atual = $r['TIPO'];
                    echo "<div class='refeicao'>
                          <div class='refeicao-header'>$tipo_atual</div>
                          <table>
                            <thead><tr><th>Alimento</th><th>Quantidade</th><th>Calorias</th></tr></thead>
                            <tbody>";
                endif;

                $total_dia += $r['kcal'];
                $total_tipo += $r['kcal'];
                echo "<tr>
                        <td>{$r['alimento']}</td>
                        <td>{$r['QUANTIDADE']}</td>
                        <td class='kcal'>".number_format($r['kcal'],1)." kcal</td>
                      </tr>";
            endforeach;

            // Fecha o último dia
            echo "<tr class='total-refeicao'><td colspan='2'>Total $tipo_atual</td><td class='kcal'>".number_format($total_tipo,1)." kcal</td></tr>";
            echo "</tbody></table></div>";
            echo "<tr class='total-dia'><td colspan='2'><strong>TOTAL DO DIA</strong></td><td class='kcal'>".number_format($total_dia,1)." kcal</td></tr>";
            echo "</div>";
        endif; ?>
    </div>

    <div class="voltar">
        <a href="index.php">Voltar ao menu principal</a>
    </div>

    <footer>
        By Fat — Projeto Final de Banco de Dados<br>
        Desenvolvido por Rodrigo Andrade © 2025
    </footer>
</div>
</body>
</html>