<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Comparador de Proyectos - TIR y VAN</title>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
      color: #fff;
    }

    .main-card {
      background: rgba(30, 41, 59, 0.97);
      border-radius: 1.5rem;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.28);
      padding: 2rem;
      max-width: 1100px;
      margin: 40px auto;
      border: 1.5px solid #334155;
    }

    label {
      font-weight: 600;
    }
  </style>
</head>

<body>
  <?php include '../../estructura/cabecera.php'; ?>
  <?php include '../../estructura/navbarSubniveles.php'; ?>

  <div class="main-content container py-5">
    <h2 class="display-5 text-center mb-4 amarillo">Comparador de Proyectos - TIR y VAN</h2>
    <div class="main-card">

      <form method="POST">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Inversión inicial (A)</label>
            <input type="number" name="inv_a" class="form-control" required value="<?= $_POST['inv_a'] ?? '' ?>">
          </div>
          <div class="form-group col-md-4">
            <label>Inversión inicial (B)</label>
            <input type="number" name="inv_b" class="form-control" required value="<?= $_POST['inv_b'] ?? '' ?>">
          </div>
          <div class="form-group col-md-4">
            <label>Número de años</label>
            <input type="number" name="anios" class="form-control" required value="<?= $_POST['anios'] ?? '' ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Tasa mínima aceptable de retorno - Proyecto A (%)</label>
            <input type="number" name="tasa_a" class="form-control" required step="0.01" value="<?= $_POST['tasa_a'] ?? '' ?>">
          </div>
          <div class="form-group col-md-6">
            <label>Tasa mínima aceptable de retorno - Proyecto B (%)</label>
            <input type="number" name="tasa_b" class="form-control" required step="0.01" value="<?= $_POST['tasa_b'] ?? '' ?>">
          </div>
        </div>

        <?php
        $mostrarCampos = isset($_POST['solicitar']) || isset($_POST['calcular']);

        if ($mostrarCampos) {
          $anios = intval($_POST['anios']);
          echo "<hr><h5>Flujos de cada proyecto</h5><div class='row'>";
          for ($i = 1; $i <= $anios; $i++) {
            echo "
            <div class='col-md-3'>
              <label>Año $i - Ingreso A</label>
              <input type='number' name='ingresoA_$i' class='form-control' value='" . ($_POST["ingresoA_$i"] ?? '') . "' required>
            </div>
            <div class='col-md-3'>
              <label>Año $i - Egreso A</label>
              <input type='number' name='egresoA_$i' class='form-control' value='" . ($_POST["egresoA_$i"] ?? '') . "' required>
            </div>
            <div class='col-md-3'>
              <label>Año $i - Ingreso B</label>
              <input type='number' name='ingresoB_$i' class='form-control' value='" . ($_POST["ingresoB_$i"] ?? '') . "' required>
            </div>
            <div class='col-md-3'>
              <label>Año $i - Egreso B</label>
              <input type='number' name='egresoB_$i' class='form-control' value='" . ($_POST["egresoB_$i"] ?? '') . "' required>
            </div>";
          }
          echo "</div><br><button type='submit' name='calcular' class='btn btn-success btn-block'>Calcular Comparación</button>";
        } else {
          echo "<button type='submit' name='solicitar' class='btn btn-warning btn-block'>Solicitar flujos</button>";
        }
        ?>
      </form>

      <?php
      // Calcular VAN - Descuento desde año 1 (exponente 1)
      function calcularVAN($flujos, $tasa)
      {
        $van = 0;
        foreach ($flujos as $indice => $flujo) {
          $periodo = $indice + 1; // Año 1 => exponente 1
          $van += $flujo / pow(1 + $tasa, $periodo);
        }
        return $van;
      }

      // Calcular TIR - usando la función calcularVAN normal (aquí no hay cambio)
      function calcularTIR($flujos)
      {
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

      if (isset($_POST['calcular'])) {
        $invA = floatval($_POST['inv_a']);
        $invB = floatval($_POST['inv_b']);
        $anios = intval($_POST['anios']);

        $tasaA = floatval($_POST['tasa_a']) / 100;
        $tasaB = floatval($_POST['tasa_b']) / 100;

        $flujosA = [-$invA];
        $flujosB = [-$invB];

        echo "<hr><h5 class='mb-3'>Resumen de flujos netos</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-dark text-center'>
        <thead class='thead-light'>
          <tr>
            <th>Año</th>
            <th>Proyecto A (Ingreso - Egreso)</th>
            <th>Proyecto B (Ingreso - Egreso)</th>
          </tr>
        </thead>
        <tbody>";
        for ($i = 1; $i <= $anios; $i++) {
          $ingA = floatval($_POST["ingresoA_$i"]);
          $egrA = floatval($_POST["egresoA_$i"]);
          $netA = $ingA - $egrA;

          $ingB = floatval($_POST["ingresoB_$i"]);
          $egrB = floatval($_POST["egresoB_$i"]);
          $netB = $ingB - $egrB;

          $flujosA[] = $netA;
          $flujosB[] = $netB;

          echo "<tr>
          <td>$i</td>
          <td>$" . number_format($netA, 2) . "</td>
          <td>$" . number_format($netB, 2) . "</td>
        </tr>";
        }
        echo "</tbody></table></div>";


        $vanA = calcularVAN(array_slice($flujosA, 1), $tasaA) + $flujosA[0];
        $vanB = calcularVAN(array_slice($flujosB, 1), $tasaB) + $flujosB[0];
        $tirA = calcularTIR($flujosA);
        $tirB = calcularTIR($flujosB);

        echo "<div class='alert alert-info mt-4'><h4>Resultados</h4>
        <p><strong>Proyecto A - VAN (" . number_format($tasaA * 100, 2) . "%):</strong> $" . number_format($vanA, 2) . " | <strong>TIR:</strong> " . number_format($tirA, 2) . "%</p>
        <p><strong>Proyecto B - VAN (" . number_format($tasaB * 100, 2) . "%):</strong> $" . number_format($vanB, 2) . " | <strong>TIR:</strong> " . number_format($tirB, 2) . "%</p>";


        if ($tirA > $tirB) {
          echo "<hr><p><strong>Conclusión:</strong> El <strong>Proyecto A</strong> ofrece un mejor retorno (TIR).</p>";
        } elseif ($tirB > $tirA) {
          echo "<hr><p><strong>Conclusión:</strong> El <strong>Proyecto B</strong> ofrece un mejor retorno (TIR).</p>";
        } else {
          echo "<hr><p><strong>Conclusión:</strong> Ambos proyectos tienen el mismo retorno estimado.</p>";
        }

        echo "</div>";
      }
      ?>
    </div>
  </div>

  <?php include '../../estructura/footer.php'; ?>
</body>

</html>