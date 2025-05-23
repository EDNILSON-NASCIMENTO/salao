<?php
include 'conexao.php';

$id = intval($_GET['id']);

// Busca a foto para excluir do servidor
$sql = mysqli_query($conn, "SELECT foto_url FROM profissionais WHERE id = $id");
$dados = mysqli_fetch_assoc($sql);

if ($dados) {
    // Excluir arquivo de imagem
    if (file_exists($dados['foto_url'])) {
        unlink($dados['foto_url']);
    }

    // Excluir registro no banco
    mysqli_query($conn, "DELETE FROM profissionais WHERE id = $id");

    echo "<script>alert('Profissional excluído com sucesso!'); location.href='lista_profissionais.php';</script>";
} else {
    echo "<script>alert('Profissional não encontrado!'); history.back();</script>";
}
?>
