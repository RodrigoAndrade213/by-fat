<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - By Fat</title>
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
        .login-card{
            background:rgba(255,255,255,0.15);
            backdrop-filter:blur(20px);
            border-radius:24px;
            padding:50px 60px;
            width:420px;
            max-width:90%;
            box-shadow:0 20px 60px rgba(0,0,0,0.4);
            text-align:center;
            border:1px solid rgba(255,255,255,0.1);
        }
        .logo{
            width:220px;
            margin-bottom:20px;
            filter:drop-shadow(0 5px 15px rgba(0,0,0,0.4));
        }
        h1{
            font-size:3.2rem;
            font-weight:900;
            margin-bottom:8px;
            background:linear-gradient(135deg,#00bfa5,#00d4aa);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            text-shadow:0 4px 20px rgba(0,191,165,0.3);
        }
        h2{
            font-size:1.6rem;
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
        input::placeholder{
            color:rgba(255,255,255,0.7);
        }
        input:focus{
            outline:none;
            background:rgba(255,255,255,0.3);
            box-shadow:0 0 25px rgba(0,191,165,0.5);
            transform:scale(1.02);
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
            margin-top:10px;
            transition:0.4s;
            box-shadow:0 10px 30px rgba(0,191,165,0.4);
        }
        button:hover{
            background:#009688;
            transform:translateY(-5px);
            box-shadow:0 15px 40px rgba(0,191,165,0.6);
        }
        .erro{
            background:rgba(255,107,107,0.3);
            padding:16px;
            border-radius:12px;
            margin:20px 0;
            font-weight:600;
            backdrop-filter:blur(10px);
        }
        .link{
            margin-top:30px;
            font-size:1.1rem;
        }
        .link a{
            color:#00bfa5;
            text-decoration:none;
            font-weight:700;
            font-size:1.2rem;
        }
        .link a:hover{
            text-decoration: underline;
        }
        footer{
            position:absolute;
            bottom:20px;
            left:50%;
            transform:translateX(-50%);
            opacity:0.7;
            font-size:0.9rem;
        }
        @media(max-width:480px){
            .login-card{padding:40px 30px;}
            .logo{width:180px;}
            h1{font-size:2.6rem;}
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="assets/logo.png?v=1" alt="By Fat" class="logo">
    <h1>By Fat</h1>
    <h2>Bem-vindo de volta!</h2>

    <form method="post">
        <input type="email" name="email" placeholder="Seu e-mail" required autofocus>
        <input type="password" name="senha" placeholder="Sua senha" required>

        <button type="submit">ENTRAR</button>
    </form>

    <?php
    if ($_POST) {
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare("SELECT CODIGO, NOME, SENHA FROM Usuario WHERE EMAIL = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['SENHA'])) {
            $_SESSION['usuario_id'] = $user['CODIGO'];
            $_SESSION['usuario_nome'] = $user['NOME'];
            header("Location: index.php");
            exit;
        } else {
            echo '<div class="erro">E-mail ou senha incorretos!</div>';
        }
    }
    ?>

    <div class="link">
        Novo por aqui? <a href="cadastro_usuario.php">Criar conta gratuita</a>
    </div>
</div>

<footer>
    By Fat — Projeto Final de Banco de Dados © Rodrigo Andrade 2025
</footer>

</body>
</html>