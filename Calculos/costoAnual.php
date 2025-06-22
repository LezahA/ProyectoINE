<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Proyecto Ingenieria de Negocios</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">

    <style>
      body {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        min-height: 100vh;
      }
      .main-card {
        background: rgba(30, 41, 59, 0.97); /* azul oscuro translúcido */
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.28);
        padding: 2.5rem 2rem;
        max-width: 600px;
        margin: 40px auto;
        transition: box-shadow 0.3s;
        border: 1.5px solid #334155;
      }
      .main-card:hover {
        box-shadow: 0 12px 36px rgba(0,0,0,0.40);
      }
      .display-5 {
        color:#c4a371;       
        letter-spacing: 1px;
      }
      .lead {
        color: #cbd5e1;
      }
      .modern-btn {
        white-space: normal;
        word-break: break-word;
        text-align: center;
        font-size: 1rem;
        padding: 0.75rem 1rem;
        max-width: 95%;
        min-width: 220px;
        width: auto;
      }
      .modern-btn.btn-primary {
        background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
        color: #fff;
      }
      .modern-btn.btn-primary:hover, .modern-btn.btn-primary:focus {
        background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%);
        color: #fff;
        transform: translateY(-3px) scale(1.04);
        box-shadow: 0 4px 16px rgba(59,130,246,0.18);
      }
      .modern-btn.btn-secondary {
        background: linear-gradient(90deg, #334155 0%, #64748b 100%);
        color: #e0e7ef;
      }
      .modern-btn.btn-secondary:hover, .modern-btn.btn-secondary:focus {
        background: linear-gradient(90deg,rgb(41, 56, 80) 0%, #334155 100%);
        color: #fff;
        transform: translateY(-3px) scale(1.04);
        box-shadow: 0 4px 16px rgba(51,65,85,0.18);
      }
      .modern-btn.btn-success {
        background: linear-gradient(90deg, #0ea5e9 0%,rgb(65, 168, 212) 100%);
        color: #fff;
      }
      .modern-btn.btn-success:hover, .modern-btn.btn-success:focus {
        background: linear-gradient(90deg, #0369a1 0%, #0ea5e9 100%);
        color: #fff;
        transform: translateY(-3px) scale(1.04);
        box-shadow: 0 4px 16px rgba(14,165,233,0.18);
      }
      .modern-btn i {
        font-size: 1.2em;
        vertical-align: middle;
        margin-right: 8px;
      }
      @media (max-width: 600px) {
        .main-card { padding: 1.2rem 0.5rem; }
        .display-5 { font-size: 2rem; }
      }
    </style>
  </head>
  <body>  
    <?php include '../estructura/cabecera.php'; ?>
    <?php include '../estructura/navbar.php'; ?>
    <!-- Contenido principal -->
    <div class="main-content container-fluid py-5">
      <div class="main-card">
        <div class="text-center mb-4">
          <h1 class="display-5 fw-bold mb-3">Costo Anual</h1>
          <p class="lead mb-4">Elija el método para calcular el costo anual</p>
        </div>
        <!-- Botones compactos y centrados -->
        <div class="d-flex flex-column align-items-center">
          <a href="./costoAnual/lineaRecta.php" class="btn btn-primary btn-lg rounded-pill shadow-sm modern-btn mb-3" style="width: 80%;">
            <i class="fas fa-slash"></i> Línea Recta (LR)
          </a>
          <a href="./costoAnual/saldoDecreciente.php" class="btn btn-secondary btn-lg rounded-pill shadow-sm modern-btn mb-3" style="width: 80%;">
            <i class="fas fa-arrow-down"></i> Saldo Decreciente (SD)
          </a>
          <a href="./costoAnual/sda.php" class="btn btn-success btn-lg rounded-pill shadow-sm modern-btn" style="width: 80%;">
            <i class="fas fa-calculator"></i> Suma de los Dígitos de los Años (SDA)
          </a>
        </div>
      </div>
    </div>

    <!-- Incluye Bootstrap Icons para los íconos en los botones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <?php include '../estructura/footer.php'; ?>

  </body>
</html>
