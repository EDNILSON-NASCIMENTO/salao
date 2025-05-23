<?php
include 'conexao.php';

$id = intval($_POST['id']);
$nome = $_POST['nome'];
$email = $_POST['email'];

// Busca dados atuais
$sql = mysqli_query($conn, "SELECT * FROM profissionais WHERE id = $id");
$dados = mysqli_fetch_assoc($sql);

if (!$dados) {
    echo "<script>alert('Profissional não encontrado!'); history.back();</script>";
    exit;
}

// Verifica se há nova imagem
if (!empty($_FILES['foto']['name'])) {
    $diretorio = "img/profissionais/";
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }

    $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'bmp'];

    if (in_array($extensao, $permitidos)) {
        $novo_nome = uniqid() . '.' . $extensao;
        $caminho = $diretorio . $novo_nome;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho)) {
            // Exclui a foto anterior
            if (file_exists($dados['foto_url'])) {
                unlink($dados['foto_url']);
            }
            $foto_url = $caminho;
        } else {
            echo "<script>alert('Erro ao fazer upload da nova foto!'); history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Formato de imagem não permitido!'); history.back();</script>";
        exit;
    }
} else {
    // Mantém a foto atual
    $foto_url = $dados['foto_url'];
}

// Atualiza dados
mysqli_query($conn, "UPDATE profissionais SET nome = '$nome', email = '$email', foto_url = '$foto_url' WHERE id = $id");

echo "<script>alert('Dados atualizados com sucesso!'); location.href='lista_profissionais.php';</script>";
?>
