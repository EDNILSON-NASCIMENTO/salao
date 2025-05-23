<?php
include 'conexao.php';

$id = intval($_GET['id']);
$sql = mysqli_query($conn, "SELECT * FROM profissionais WHERE id = $id");
$dados = mysqli_fetch_assoc($sql);

if (!$dados) {
    echo "<script>alert('Profissional não encontrado!'); history.back();</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Profissional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Editar Profissional</h2>
    <form method="POST" action="atualizar_profissional.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
        
        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($dados['nome']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail:</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($dados['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Atual:</label><br>
            <img src="<?php echo $dados['foto_url']; ?>" width="200"><br><br>
            <label class="form-label">Trocar Foto (opcional):</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Salvar Alterações
        </button>
        <a href="lista_profissionais.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </form>
</div>

</body>
</html>
