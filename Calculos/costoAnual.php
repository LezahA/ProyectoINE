<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto Ingenieria de Negocios</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
      body {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        min-height: 100vh;
      }
      .main-card {
        background: rgba(30, 41, 59, 0.97);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.28);
        padding: 2.5rem 2rem;
        max-width: 600px;
        margin: 40px auto;
        border: 1.5px solid #334155;
      }
      .display-5 { color:#c4a371; letter-spacing: 1px; }
      .lead { color: #cbd5e1; }
      .modern-btn {
        font-size: 1rem; padding: 0.75rem 1rem; width: 80%;
        max-width: 95%; min-width: 220px;
        text-align: center;
      }
      .modern-btn:hover, .modern-btn:focus {
        transform: translateY(-3px) scale(1.04);
      }
    </style>
  </head>
  <body>
    <?php include '../estructura/cabecera.php'; ?>
    <?php include '../estructura/navbar.php'; ?>

    <div class="main-content container-fluid py-5">
      <div class="main-card">
        <div class="text-center mb-4">
          <h1 class="display-5 fw-bold mb-3">Costo Anual</h1>
          <p class="lead mb-4">Elija el método para calcular el costo anual</p>
        </div>
        <div class="d-flex flex-column align-items-center">
          <a href="./costoAnual/lineaRecta.php" class="btn btn-primary rounded-pill shadow-sm modern-btn mb-3">
            <i class="fas fa-slash"></i> Línea Recta (LR)
          </a>
          <a href="./costoAnual/saldoDecreciente.php" class="btn btn-secondary rounded-pill shadow-sm modern-btn mb-3">
            <i class="fas fa-arrow-down"></i> Saldo Decreciente (SD)
          </a>
          <a href="./costoAnual/sda.php" class="btn btn-success rounded-pill shadow-sm modern-btn mb-3">
            <i class="fas fa-calculator"></i> Suma de los Dígitos de los Años (SDA)
          </a>
          <a href="./costoAnual/tirVan.php" class="btn btn-warning rounded-pill shadow-sm modern-btn">
            <i class="fas fa-percent"></i> Tasa de Rendimiento (TIR y VAN)
          </a>
        </div>
      </div>
    </div>

    <?php include '../estructura/footer.php'; ?>
  </body>
</html>
