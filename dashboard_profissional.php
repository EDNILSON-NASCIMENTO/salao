<?php
include 'conexao.php';

// Verifica se foi selecionado um profissional
$id_profissional = isset($_POST['id_profissional']) ? intval($_POST['id_profissional']) : 0;

// Consulta para listar os profissionais
$query_profissionais = "SELECT id, nome FROM profissionais ORDER BY nome";
$result_profissionais = mysqli_query($conn, $query_profissionais);

// Se selecionado, busca os agendamentos
$agendamentos = [];

if ($id_profissional > 0) {
    $query_agendamentos = "
        SELECT a.id, a.data, a.hora_inicio, a.hora_fim, s.nome AS servico
        FROM agenda a
        JOIN servicos s ON a.servico_id = s.id
        WHERE a.profissional_id = $id_profissional
        ORDER BY a.data, a.hora_inicio
    ";

    $result_agendamentos = mysqli_query($conn, $query_agendamentos);

    while ($row = mysqli_fetch_assoc($result_agendamentos)) {
        $agendamentos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos por Profissional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Consultar Agendamentos por Profissional</h2>

    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="id_profissional" class="form-label">Selecione o Profissional:</label>
            <select name="id_profissional" id="id_profissional" class="form-select" required>
                <option value="">-- Selecione --</option>
                <?php while ($prof = mysqli_fetch_assoc($result_profissionais)) { ?>
                    <option value="<?php echo $prof['id']; ?>" <?php if($id_profissional == $prof['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($prof['nome']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Consultar</button>
        </div>
    </form>

    <?php if ($id_profissional > 0) { ?>
        <h4>Agendamentos</h4>
        <?php if (count($agendamentos) > 0) { ?>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Hora Início</th>
                        <th>Hora Fim</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $ag) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ag['servico']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($ag['data'])); ?></td>
                            <td><?php echo substr($ag['hora_inicio'], 0, 5); ?></td>
                            <td><?php echo substr($ag['hora_fim'], 0, 5); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-info">Nenhum agendamento encontrado para este profissional.</div>
        <?php } ?>
    <?php } ?>
</div>
<div class="container mt-5">
  <a href="dashboard.php" class="btn btn-secondary btn-voltar">
    <i class="bi bi-arrow-left"></i> Voltar
  </a>      
</div>
</body>
</html>
