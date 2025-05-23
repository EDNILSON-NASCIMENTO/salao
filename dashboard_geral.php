<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

// Define o mês e o ano atual
$mes = date('m');
$ano = date('Y');

// Primeiro e último dia do mês
$primeiro_dia = date('Y-m-01');
$ultimo_dia = date('Y-m-t');

// Descobre o dia da semana do primeiro dia do mês (0=Domingo, 6=Sábado)
$dia_semana_inicio = date('w', strtotime($primeiro_dia));

// Recupera os agendamentos do mês atual
$query = "
    SELECT a.id, p.nome AS profissional, s.nome AS servico, a.hora_inicio, a.hora_fim, a.data
    FROM agenda a
    JOIN profissionais p ON a.profissional_id = p.id
    JOIN servicos s ON a.servico_id = s.id
    WHERE a.data BETWEEN '$primeiro_dia' AND '$ultimo_dia'
    ORDER BY a.data ASC, a.hora_inicio ASC
";
$res = mysqli_query($conn, $query);

// Organiza os agendamentos por data
$agendamentos = [];
while ($row = mysqli_fetch_assoc($res)) {
    $agendamentos[$row['data']][] = $row;
}

// Dias da semana
$dias_semana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calendário de Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .calendario {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }
        .dia {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px;
            min-height: 120px;
            background-color: #f9f9f9;
        }
        .dia h6 {
            margin-top: 0;
            font-weight: bold;
        }
        .agendamento {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 4px 6px;
            margin-bottom: 4px;
            font-size: 0.85em;
        }
        .agendamento strong {
            display: block;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Calendário de Agendamentos - <?php echo date('m/Y'); ?></h2>

    <div class="calendario">
        <!-- Cabeçalho dos dias da semana -->
        <?php foreach ($dias_semana as $ds) : ?>
            <div class="text-center fw-bold"><?php echo $ds; ?></div>
        <?php endforeach; ?>

        <!-- Espaços vazios até o primeiro dia do mês -->
        <?php for ($i = 0; $i < $dia_semana_inicio; $i++) : ?>
            <div></div>
        <?php endfor; ?>

        <!-- Dias do mês -->
        <?php
        $total_dias = date('t');

        for ($dia = 1; $dia <= $total_dias; $dia++) :
            $data_atual = date('Y-m-d', strtotime("$ano-$mes-$dia"));
            $dia_semana = date('w', strtotime($data_atual));
        ?>
            <div class="dia">
                <h6><?php echo $dia . ' (' . $dias_semana[$dia_semana] . ')'; ?></h6>

                <?php if (isset($agendamentos[$data_atual])) : ?>
                    <?php foreach ($agendamentos[$data_atual] as $ag) : ?>
                        <div class="agendamento">
                            <strong><?php echo htmlspecialchars($ag['profissional']); ?></strong>
                            <?php echo htmlspecialchars($ag['servico']); ?><br>
                            <?php echo substr($ag['hora_inicio'], 0, 5) . ' - ' . substr($ag['hora_fim'], 0, 5); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>

    <div class="mt-4">
        <a href="dashboard.php" class="btn btn-secondary">
            Voltar
        </a>
    </div>
</div>
</body>
</html>
