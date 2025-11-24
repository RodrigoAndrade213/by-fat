<?php
$link = mysqli_connect("localhost", "root", "", "by_fat");
if ($link === false) {
    die("ERRO: Não foi possível conectar ao BD. " . mysqli_connect_error());
}

$data = mysqli_real_escape_string($link, $_REQUEST['data']);
$alimento_codigo = mysqli_real_escape_string($link, $_REQUEST['alimento_codigo']);
$quantidade = mysqli_real_escape_string($link, $_REQUEST['quantidade']);
$descricao = mysqli_real_escape_string($link, $_REQUEST['descricao']);
$usuario_codigo = mysqli_real_escape_string($link, $_REQUEST['usuario_codigo']);

// Verifica se o alimento existe
$sql_check = "SELECT CALORIAS_POR_UNIDADE FROM Alimento WHERE CODIGO = ?";
$stmt_check = mysqli_prepare($link, $sql_check);
mysqli_stmt_bind_param($stmt_check, "i", $alimento_codigo);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) > 0) {
    $row = mysqli_fetch_array($result_check);
    $calorias_por_unidade = $row['CALORIAS_POR_UNIDADE'];
    $calorias = $quantidade * $calorias_por_unidade;

    $sql = "INSERT INTO Refeicao (DATA, ALIMENTO_CODIGO, QUANTIDADE, DESCRICAO, USUARIO_CODIGO) 
            VALUES ('$data', '$alimento_codigo', '$quantidade', '$descricao', '$usuario_codigo')";
    if (mysqli_query($link, $sql)) {
        header("Location: cadastro_refeicao.php?message=" . urlencode("Gravação efetuada com sucesso!"));
    } else {
        echo "Erro (Não foi possível inserir o registro na tabela): " . mysqli_error($link);
    }
} else {
    header("Location: cadastro_refeicao.php?error=alimento_nao_encontrado");
}

mysqli_stmt_close($stmt_check);
mysqli_close($link);
?>