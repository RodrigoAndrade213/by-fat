<?php 
require_once 'conexao.php'; 
$mensagem = '';
$tipo_msg = '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - By Fat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#1e3a8a 0%,#3b82f6 100%);
            min-height:100vh;
            display:flex;justify-content:center;align-items:center;
            color:white;
        }
        .card{
            background:rgba(255,255,255,0.15);
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding:50px 60px;
            width:480px;
            max-width:92%;
            box-shadow:0 20px 60px rgba(0,0,0,0.4);
            border:1px solid rgba(255,255,255,0.1);
        }
        .logo{
            width:220px;
            margin:0 auto 25px;
            display:block;
            filter:drop-shadow(0 5px 15px rgba(0,0,0,0.4));
        }
        h1{
            font-size:3rem;
            text-align:center;
            margin-bottom:8px;
            background:linear-gradient(135deg,#00bfa5,#00d4aa);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }
        h2{
            text-align:center;
            font-size:1.5rem;
            opacity:0.9;
            margin-bottom:40px;
            font-weight:400;
        }
        form{
            display:grid;
            gap:20px;
        }
        input{
            padding:18px 22px;
            border:none;
            border-radius:14px;
            background:rgba(255,255,255,0.2);
            color:white;
            font-size:1.1rem;
            backdrop-filter:blur(10px);
            transition:0.3s;
        }
        input::placeholder{color:rgba(255,255,255,0.7);}
        input:focus{
            outline:none;
            background:rgba(255,255,255,0.3);
            box-shadow:0 0 25px rgba(0,191,165,0.5);
        }
        button{
            padding:18px;
            border:none;
            border-radius:14px;
            background:#00bfa5;
            color:white;
            font-size:1.4rem;
            font-weight:700;
            cursor:pointer;
            margin-top:15px;
            transition:0.4s;
            box-shadow:0 10px 30px rgba(0,191,165,0.4);
        }
        button:hover{
            background:#009688;
            transform:translateY(-5px);
            box-shadow:0 15px 40px rgba(0,191,165,0.6);
        }
        .sucesso{
            background:rgba(0,191,165,0.3);
            padding:20px;
            border-radius:14px;
            text-align:center;
            font-size:1.3rem;
            margin:20px 0;
            backdrop-filter:blur(10px);
        }
        .erro{
            background:rgba(255,107,107,0.3);
            padding:20px;
            border-radius:14px;
            text-align:center;
            font-size:1.2rem;
            margin:20px 0;
        }
        .link{
            text-align:center;
            margin-top:30px;
            font-size:1.1rem;
        }
        .link a{
            color:#00bfa5;
            font-weight:700;
            text-decoration:none;
            font-size:1.2rem;
        }
        .link a:hover{text-decoration:underline;}
        footer{
            position:absolute;
            bottom:20px;
            left:50%;
            transform:translateX(-50%);
            opacity:0.7;
            font-size:0.9rem;
        }
        @media(max-width:480px){
            .card{padding:40px 35px;}
            .logo{width:180px;}
            h1{font-size:2.5rem;}
        }
    </style>
</head>
<body>

<div class="card">
    <img src="assets/logo.png?v=1" alt="By Fat" class="logo">
    <h1>Criar Conta</h1>
    <h2>Junte-se ao By Fat agora!</h2>

    <?php
    if ($_POST) {
        $nome   = trim($_POST['nome']);
        $email  = strtolower(trim($_POST['email']));
        $senha  = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $idade  = $_POST['idade'] ?: null;
        $peso   = $_POST['peso'] ?: null;
        $altura = $_POST['altura'] ?: null;

        try {
            $stmt = $pdo->prepare("INSERT INTO Usuario (NOME, EMAIL, SENHA, IDADE, PESO, ALTURA) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $senha, $idade, $peso, $altura]);
            $mensagem = "Conta criada com sucesso!<br><a href='login.php' style='color:#00bfa5;font-weight:700;'>Fazer login agora</a>";
            $tipo_msg = "sucesso";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensagem = "Este e-mail já está cadastrado!";
            } else {
                $mensagem = "Erro ao cadastrar. Tente novamente.";
            }
            $tipo_msg = "erro";
        }
    }
    ?>

    <?php if($mensagem): ?>
        <div class="<?= $tipo_msg ?>"><?= $mensagem ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="Seu e-mail" required>
        <input type="password" name="senha" placeholder="Crie uma senha" required minlength="4">
        <input type="number" name="idade" placeholder="Idade (opcional)" min="10" max="120">
        <input type="number" step="0.1" name="peso" placeholder="Peso em kg (opcional)">
        <input type="number" name="altura" placeholder="Altura em cm (opcional)" min="100" max="250">
        
        <button type="submit">CRIAR MINHA CONTA</button>
    </form>

    <div class="link">
        Já tem conta? <a href="login.php">Fazer login</a>
    </div>
</div>

<footer>
    
</footer>

</body>
</html>