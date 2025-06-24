<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Proyecto Ingenieria de Negocios</title>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="../../estilosTablas.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
        <style>
              body {
              background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
              color: #fff;
            }
            .main-card {
              background: rgba(30, 41, 59, 0.97);
              border-radius: 1.5rem;
              box-shadow: 0 8px 32px rgba(0,0,0,0.28);
              padding: 2rem;
              max-width: 800px;
              margin: 40px auto;
              border: 1.5px solid #334155;
            }
        </style>      
    </head>
    <body>  
        <!-- Cabecera y barra de navegacion -->
        <?php include '../../estructura/cabecera.php'; ?>
        <?php include '../../estructura/navbarSubniveles.php'; ?>

        <div class="main-content container py-5" id="tirPDF">
          <h2 class="display-5 text-center mb-4 amarillo">Calculadora TIR y VAN</h2>

          <div class="main-card">

          <form method="POST">
            <div class="form-group">
              <label for="inversion">Inversión inicial (año 0)</label>
              <input type="number" class="form-control" name="inversion" id="inversion" value="<?= isset($_POST['inversion']) ? $_POST['inversion'] : '' ?>" required>
            </div>
            <div class="form-group">
              <label for="anios">Número de años</label>
              <input type="number" class="form-control" name="anios" id="anios" value="<?= isset($_POST['anios']) ? $_POST['anios'] : '' ?>" required>
            </div>
            <div class="form-group">
              <label for="tasa">Tasa mínima aceptable de retorno (%)</label>
              <input type="number" class="form-control" name="tasa" id="tasa" value="<?= isset($_POST['tasa']) ? $_POST['tasa'] : '' ?>" step="0.01" required>
            </div>

            <?php
            $mostrarCampos = false;

            if (isset($_POST['solicitar']) || isset($_POST['calcular'])) {
                $mostrarCampos = true;
            }

            if ($mostrarCampos) {
                $anios = intval($_POST['anios']);
                echo "<hr><h5>Ingresos y Egresos por año</h5><br><div class='row'>";
                for ($i = 1; $i <= $anios; $i++) {
                    $ing = $_POST["ingreso_$i"] ?? '';
                    $egr = $_POST["egreso_$i"] ?? '';
                    echo "
                    <div class='col-md-6'>
                        <label>Año $i - Ingreso</label>
                        <input type='number' class='form-control' name='ingreso_$i' value='$ing' required>
                    </div>
                    <div class='col-md-6'>
                        <label>Año $i - Egreso</label>
                        <input type='number' class='form-control' name='egreso_$i' value='$egr' required>
                    </div>";
                }
                echo "</div><br><button type='submit' name='calcular' class='btn btn-success btn-block'>Calcular</button>";
            } else {
                echo "<button type='submit' name='solicitar' class='btn btn-warning btn-block'>Solicitar flujos</button>";
            }
            ?>
          </form>

      <?php
      if (isset($_POST['calcular'])) {
          $inversion = floatval($_POST['inversion']);
          $tasa_min = floatval($_POST['tasa']) / 100;
          $anios = intval($_POST['anios']);
          $flujos = [];

          echo "<hr><h5>Flujos netos por año:</h5><ul>";
          echo "<li><strong>Año 0:</strong> -$" . number_format($inversion, 2) . "</li>";
          $flujos[] = -$inversion;

          for ($i = 1; $i <= $anios; $i++) {
              $ing = isset($_POST["ingreso_$i"]) ? floatval($_POST["ingreso_$i"]) : 0;
              $egr = isset($_POST["egreso_$i"]) ? floatval($_POST["egreso_$i"]) : 0;
              $neto = $ing - $egr;
              $flujos[] = $neto;
              echo "<li><strong>Año $i:</strong> Ingreso = $" . number_format($ing, 2) . ", Egreso = $" . number_format($egr, 2) . ", Neto = $" . number_format($neto, 2) . "</li>";
          }
          echo "</ul>";

          // Calcular VAN - Descuento desde año 1 (exponente 1)
          function calcularVAN($flujos, $tasa) {
              $van = 0;
              foreach ($flujos as $indice => $flujo) {
                  $periodo = $indice + 1; // Año 1 => exponente 1
                  $van += $flujo / pow(1 + $tasa, $periodo);
              }
              return $van;
          }

          // Calcular TIR - usando la función calcularVAN normal (aquí no hay cambio)
          function calcularTIR($flujos) {
              $mejorTasa = null;
              $mejorVAN = INF;
              for ($t = -0.99; $t <= 1; $t += 0.0001) {
                  $van = 0;
                  foreach ($flujos as $n => $f) {
                      $van += $f / pow(1 + $t, $n);
                  }
                  if (abs($van) < abs($mejorVAN)) {
                      $mejorVAN = $van;
                      $mejorTasa = $t;
                  }
              }
              return $mejorTasa * 100;
          }

          // VAN: VNA años 1 a N + año 0
          $van = calcularVAN(array_slice($flujos, 1), $tasa_min) + $flujos[0];

          // TIR sobre todos los flujos (0 a N)
          $tir = calcularTIR($flujos);

            // Botón para exportar
            echo '<br><form id="exportarPDF" action="../../exportar_pdf.php" method="post" target="_blank">
                <input type="hidden" name="tabla_html" id="tabla_html">
                <button type="button" class="btn btn-danger" onclick="enviarTabla()">Exportar a PDF</button>
            </form>
            <br>
            <div >';

          // Mostrar resultados
          echo "<div class='alert alert-info mt-4'>
                  <h4>Resultados</h4>
                  <p><strong>VAN (VNA - Inversión):</strong> $" . number_format($van, 2) . "</p>
                  <p><strong>TIR estimada:</strong> " . number_format($tir, 2) . "%</p>
              </div>";
      }
      ?>
      </div>
    </div>
    <script>
      function enviarTabla() {
        // Captura el HTML de la tabla y lo envía al formulario
        document.getElementById('tabla_html').value = document.getElementById('tirPDF').innerHTML;
        document.getElementById('exportarPDF').submit();
      }
  </script>
<?php include '../../estructura/footer.php'; ?>
</body>
</html>