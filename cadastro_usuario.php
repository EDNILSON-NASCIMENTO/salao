<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // Verifica se já existe
  $check = mysqli_query($conn, "SELECT * FROM usuarios WHERE email = '$email'");
  if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('E-mail já cadastrado.'); location.href='login.php';</script>";
    exit;
  }

  // Inserção simples
  mysqli_query($conn, "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')");
  $id = mysqli_insert_id($conn);
  $_SESSION['usuario'] = ['id' => $id, 'nome' => $nome, 'email' => $email];

  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Cadastro de Novo Usuário</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input type="email" name="email" class="form-control" required value="<?= $_GET['email'] ?? '' ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Cadastrar e Entrar</button>
  </form>
</div>
</body>
</html>
