<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    echo "<script>alert('Acesso restrito!'); location.href='index.php';</script>";
    exit;
}

include 'conexao.php';

$res = mysqli_query($conn, "SELECT * FROM profissionais ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Profissionais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .ficha {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            background-color: white;
            margin: 10px;
            text-align: center;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        .ficha img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }
        .container-fichas {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .acoes {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .acoes a {
            margin-left: 5px;
            color: #333;
            text-decoration: none;
        }
        .acoes a:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">Lista de Profissionais</h2>
    <div class="container-fichas">
        <?php while($row = mysqli_fetch_assoc($res)) : ?>
            <div class="ficha">
                <div class="acoes">
                    <a href="editar_profissional.php?id=<?php echo $row['id']; ?>" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="excluir_profissional.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('Deseja realmente excluir este profissional?');" 
                       title="Excluir">
                        <i class="bi bi-trash3"></i>
                    </a>
                </div>
                <img src="<?php echo htmlspecialchars($row['foto_url']); ?>" alt="Foto">
                <h5 class="mt-2"><?php echo htmlspecialchars($row['nome']); ?></h5>
                <p><?php echo htmlspecialchars($row['email']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="mt-4">
        <a href="cadastrar_profissional.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Cadastrar Novo
        </a>
        <a href="index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>
</div>

</body>
</html>
