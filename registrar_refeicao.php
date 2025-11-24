<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$usuario_id = $_SESSION['usuario_id'];

$mensagem = "";
if ($_POST) {
    $data = $_POST['data'];
    $tipo = $_POST['tipo'];

    $stmt = $pdo->prepare("INSERT INTO Refeicao (DATA, TIPO, ALIMENTO_CODIGO, QUANTIDADE, USUARIO_CODIGO) 
                           VALUES (?, ?, ?, ?, ?)");

    foreach ($_POST['alimento'] as $i => $item) {
        if (empty($item)) continue;
        list($alimento_id, $cal_por_unidade) = explode("|", $item);
        $qtd = $_POST['quantidade'][$i] ?? 1;
        $stmt->execute([$data, $tipo, $alimento_id, $qtd, $usuario_id]);
    }
    $mensagem = "<div class='sucesso'>Refeição salva com sucesso!</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Refeição - By Fat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            color: white;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 20px; }
        header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; flex-wrap: wrap;
        }
        .logo-pequena { width: 180px; }
        .user-info {
            background: rgba(255,255,255,0.2);
            padding: 10px 20px; border-radius: 50px;
            backdrop-filter: blur(10px); font-weight: 600;
        }
        .user-info a { color:#fff; text-decoration:none; margin-left:15px; }
        .card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        h1 { font-size: 2.4rem; text-align:center; margin-bottom:20px; }
        table { width:100%; margin:20px 0; }
        td { padding:12px 0; }
        input, select {
            padding:10px; border-radius:8px; border:none;
            width:100%; font-size:1rem;
        }
        .itens-table {
            width:100%; border-collapse:collapse; margin:25px 0;
            background:rgba(255,255,255,0.1); border-radius:12px; overflow:hidden;
        }
        .itens-table th {
            background:#0d47a1; padding:15px; text-align:left;
        }
        .itens-table td { padding:15px; vertical-align:middle; }
        .itens-table select, .itens-table input { width:95%; }
        .itens-table input[type=number] { width:80px; }
        .btn-remove {
            background:#e64a19; color:white; border:none;
            padding:8px 15px; border-radius:8px; cursor:pointer;
        }
        .btn-add {
            background:#ff8f00; color:white; border:none;
            padding:12px 20px; border-radius:10px; cursor:pointer; font-weight:600;
        }
        .total { font-size:1.6rem; font-weight:700; text-align:center; margin:25px 0; }
        .btn-salvar {
            display:block; margin:30px auto;
            padding:18px 40px; font-size:1.3rem; font-weight:700;
            background:#00bfa5; color:white; border:none;
            border-radius:15px; cursor:pointer;
        }
        .sucesso {
            background:#1b5e20; padding:15px; border-radius:10px;
            text-align:center; margin:20px 0; font-weight:600;
        }
        .voltar { text-align:center; margin:30px 0; }
        .voltar a { color:#a0d8ff; font-size:1.1rem; }
        @media (max-width:768px){
            header{flex-direction:column; text-align:center;}
            .logo-pequena{width:150px; margin-bottom:15px;}
            .itens-table th, .itens-table td { font-size:0.9rem; padding:10px; }
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
        <h1>Registrar Refeição</h1>

        <?php if($mensagem) echo $mensagem; ?>

        <form method="post">
            <table>
                <tr>
                    <td><strong>Data:</strong></td>
                    <td><input type="date" name="data" value="<?=date('Y-m-d')?>" required></td>
                </tr>
                <tr>
                    <td><strong>Tipo de Refeição:</strong></td>
                    <td>
                        <select name="tipo" required>
                            <option value="Café da manhã">Café da manhã</option>
                            <option value="Almoço" selected>Almoço</option>
                            <option value="Lanche da tarde">Lanche da tarde</option>
                            <option value="Jantar">Jantar</option>
                            <option value="Ceia">Ceia</option>
                        </select>
                    </td>
                </tr>
            </table>

            <h2>Itens da Refeição</h2>
            <table class="itens-table" id="itens">
                <thead>
                    <tr>
                        <th>Alimento</th>
                        <th>Quantidade</th>
                        <th>Calorias</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="alimento[]" onchange="calc(this)" required>
                                <option value="">Selecione...</option>
                                <?php
                                $stmt = $pdo->query("SELECT CODIGO, NOME, MEDIDA, CALORIAS_POR_UNIDADE FROM Alimento ORDER BY NOME");
                                while ($a = $stmt->fetch()) {
                                    echo "<option value='{$a['CODIGO']}|{$a['CALORIAS_POR_UNIDADE']}'>
                                            {$a['NOME']} ({$a['MEDIDA']})
                                          </option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="number" step="0.01" name="quantidade[]" value="1" min="0.01" oninput="calc(this)" required></td>
                        <td class="cal">0</td>
                        <td><button type="button" class="btn-remove" onclick="this.closest('tr').remove(); total()">Remover</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn-add" onclick="addItem()">+ Adicionar outro alimento</button>

            <p class="total">Total de calorias: <span id="total">0</span> kcal</p>

            <button type="submit" class="btn-salvar">Salvar Refeição Completa</button>
        </form>
    </div>

    <div class="voltar">
        <a href="index.php">← Voltar ao menu principal</a>
    </div>

    <footer style="text-align:center; margin-top:60px; opacity:0.8;">
        By Fat — Projeto Final de Banco de Dados<br>
        Desenvolvido por Rodrigo Andrade © 2025
    </footer>
</div>

<script>
function calc(el) {
    const tr = el.closest('tr');
    const select = tr.querySelector('select');
    const qtd = parseFloat(tr.querySelector('input[type=number]').value) || 0;
    const partes = select.value.split('|');
    const cal = partes.length === 2 ? partes[1] * qtd : 0;
    tr.querySelector('.cal').innerText = cal.toFixed(1);
    total();
}
function total() {
    let t = 0;
    document.querySelectorAll('.cal').forEach(c => t += parseFloat(c.innerText) || 0);
    document.getElementById('total').innerText = t.toFixed(1);
}
function addItem() {
    const tbody = document.querySelector('#itens tbody');
    const clone = tbody.children[0].cloneNode(true);
    clone.querySelector('select').value = '';
    clone.querySelector('input').value = '1';
    clone.querySelector('.cal').innerText = '0';
    tbody.appendChild(clone);
}
total();
</script>
</body>
</html>
