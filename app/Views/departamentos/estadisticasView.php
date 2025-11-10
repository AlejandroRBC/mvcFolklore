<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas Departamentos</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 2px; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .badge { background-color: #007bff; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; }
        .stat-card { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-item { background: white; padding: 15px; border-radius: 5px; text-align: center; border: 1px solid #dee2e6; }
        .stat-number { font-size: 24px; font-weight: bold; color: #007bff; }
        .stat-label { font-size: 14px; color: #6c757d; }
    </style>
</head>
<body>
    <h2>Estadísticas de Departamentos</h2>
    <a href="index.php?controller=departamentoController&funcion=listar" class="btn btn-secondary">Volver al Listado</a>
    
    <div class="stat-card">
        <h3>Resumen General</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number"><?php echo count($infoParaVer["datos"]['departamentos'] ?? []); ?></div>
                <div class="stat-label">Total Departamentos</div>
            </div>
            <?php
            $totalBailes = 0;
            $totalFraternidades = 0;
            if(isset($infoParaVer["datos"]['departamentos'])) {
                foreach($infoParaVer["datos"]['departamentos'] as $depto) {
                    $totalBailes += $depto['total_bailes'] ?? 0;
                    $totalFraternidades += $depto['total_fraternidades'] ?? 0;
                }
            }
           