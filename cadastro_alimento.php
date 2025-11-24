<?php
session_start();
require_once "conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$mensagem = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Alimento - By Fat</title>
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
            border-radius:20px;padding:40px 50px;box-shadow:0 15px 35px rgba(0,0,0,0.3);
            max-width:700px;margin:0 auto;
        }
        h1{font-size:2.8rem;text-align:center;margin-bottom:10px;}
        .subtitle{text-align:center;font-size:1.4rem;opacity:0.9;margin-bottom:40px;}

        form{
            display:grid;grid-template-columns:1fr 1fr;gap:25px;
        }
        .full{width:100% !important;}

        label{
            display:block;margin-bottom:8px;font-weight:600;font-size:1.1rem;
            text-shadow:0 2px 8px rgba(0,0,0,0.3);
        }
        input[type=text], input[type=number], select{
            width:100%;padding:16px 20px;
            background:rgba(255,255,255,0.2);border:none;border-radius:12px;
            color:white;font-size:1.1rem;backdrop-filter:blur(10px);
            transition:0.3s;
        }
        input::placeholder{color:rgba(255,255,255,0.7);}
        input:focus, select:focus{
            outline:none;background:rgba(255,255,255,0.3);box-shadow:0 0 20px rgba(0,191,165,0.5);
        }
        select{
            cursor:pointer;
        }
        button{
            background:#00bfa5;color:white;padding:18px 40px;
            border:none;border-radius:12px;font-size:1.3rem;font-weight:700;
            cursor:pointer;margin-top:20px;width:100%;
            transition:0.3s;box-shadow:0 8px 25px rgba(0,191,165,0.4);
        }
        button:hover{
            background:#009688;transform:translateY(-3px);box-shadow:0 12px 30px rgba(0,191,165,0.6);
        }
        .msg{
            text-align:center;margin-top:25px;padding:20px;
            background:rgba(0,191,165,0.3);border-radius:12px;font-size:1.2rem;
            backdrop-filter:blur(10px);
        }
        .voltar{text-align:center;margin:60px 0;}
        .voltar a{color:#a0d8ff;font-size:1.4rem;text-decoration:none;}
        .voltar a:hover{text-decoration:underline;}
        footer{text-align:center;padding:50px;opacity:0.8;font-size:1.1rem;}

        @media(max-width:768px){
            .form-grid{grid-template-columns:1fr;}
            .card{padding:30px 25px;}
            header{flex-direction:column;text-align:center;}
            .logo-pequena{width:150px;margin-bottom:15px;}
            h1{font-size:2.3rem;}
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
        <h1>Cadastrar Novo Alimento</h1>
        <p class="subtitle">Adicione alimentos personalizados ao seu banco de dados</p>

        <?php if($mensagem): ?>
            <div class="msg"><?=htmlspecialchars($mensagem)?></div>
        <?php endif; ?>

        <form method="post" action="insert.php">
            <div class="form-grid">
                <div>
                    <label for="nome">Nome do Alimento</label>
                    <input type="text" name="nome" id="nome" placeholder="Ex: Arroz integral" required maxlength="50">
                </div>

                <div>
                    <label for="calorias_por_unidade">Calorias por Unidade</label>
                    <input type="number" name="calorias_por_unidade" id="calorias_por_unidade" 
                           placeholder="Ex: 130" step="0.01" min="0" required>
                </div>

                <div>
                    <label for="medida">Tipo de Medida</label>
                    <select name="medida" id="medida" required>
                        <option value="" disabled selected>Selecione...</option>
                        <option value="colher de sopa">Colher de Sopa</option>
                        <option value="concha">Concha</option>
                        <option value="copo">Copo</option>
                        <option value="unidade">Unidade</option>
                        <option value="fatia">Fatia</option>
                        <option value="porção">Porção</option>
                        <option value="100g">100g</option>
                    </select>
                </div>

                <div>
                    <label for="unidade">Unidade de Medida</label>
                    <select name="unidade" id="unidade" required>
                        <option value="" disabled selected>Selecione...</option>
                        <option value="gramas">Gramas (g)</option>
                        <option value="mililitros">Mililitros (ml)</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="tabela" value="Alimento">
            <button type="submit">CADASTRAR ALIMENTO</button>
        </form>
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