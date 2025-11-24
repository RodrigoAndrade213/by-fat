<?php
$link = mysqli_connect("localhost", "root", "", "by_fat");
if ($link === false) {
    die("ERRO: Não foi possível conectar ao BD. " . mysqli_connect_error());
}

$tabela = mysqli_real_escape_string($link, $_REQUEST['tabela']);

if ($tabela == "Usuario") {
    $nome = mysqli_real_escape_string($link, $_REQUEST['nome']);
    $idade = mysqli_real_escape_string($link, $_REQUEST['idade']);
    $peso = mysqli_real_escape_string($link, $_REQUEST['peso']);
    $altura = isset($_REQUEST['altura']) && is_numeric($_REQUEST['altura']) && $_REQUEST['altura'] > 0 ? mysqli_real_escape_string($link, $_REQUEST['altura']) : 165;
    $altura_m = $altura / 100;
    $imc = isset($_REQUEST['imc']) && $_REQUEST['imc'] !== "" ? mysqli_real_escape_string($link, $_REQUEST['imc']) : round($peso / ($altura_m * $altura_m), 2);
    $peso_ideal = isset($_REQUEST['peso_ideal']) && $_REQUEST['peso_ideal'] !== "" ? mysqli_real_escape_string($link, $_REQUEST['peso_ideal']) : round($altura - 100 - (($altura - 150) / 4), 2);
    $sql = "INSERT INTO Usuario (NOME, IDADE, PESO, ALTURA, IMC, PESO_IDEAL) VALUES ('$nome', '$idade', '$peso', '$altura', '$imc', '$peso_ideal')";
} elseif ($tabela == "Alimento") {
    $nome = mysqli_real_escape_string($link, $_REQUEST['nome']);
    $medida = mysqli_real_escape_string($link, $_REQUEST['medida']);
    $unidade = mysqli_real_escape_string($link, $_REQUEST['unidade']);
    $calorias_por_unidade = mysqli_real_escape_string($link, $_REQUEST['calorias_por_unidade']);
    $sql = "INSERT INTO Alimento (NOME, MEDIDA, UNIDADE, CALORIAS_POR_UNIDADE) 
            VALUES ('$nome', '$medida', '$unidade', '$calorias_por_unidade')";
} else {
    die("Tabela inválida!");
}

if (mysqli_query($link, $sql)) {
    header("Location: cadastro_alimento.php?message=" . urlencode("Gravação efetuada com sucesso!"));
} else {
    echo "Erro (Não foi possível inserir o registro na tabela): " . mysqli_error($link);
}

mysqli_close($link);
?>
