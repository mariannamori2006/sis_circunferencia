<?php
session_start();
require_once __DIR__ . '/../controller/AuthController.php';

$mensaje = '';
$correo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    if ($correo === '' || $clave === '') {
        $mensaje = 'Complete todos los campos';
    } else {
        $auth = new AuthController();

        if ($auth->login($correo, $clave)) {
            header('Location: home.php');
            exit;
        }

        $mensaje = 'Correo o clave incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Calculo del area y perimetro de la circunferencia">
    <meta name="keywords" content="circunferencia, sistema, base de datos">
    <meta name="author" content="Marianna Mori">

    <link rel="icon" href="../imagenes/icono.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,600&display=swap">
    <link rel="stylesheet" href="../assetes/css/style.css">

    <title>Circunferencia</title>
</head>
<body>
    <main>
        <div class="caja">

            <!-- Panel izquierdo -->
            <aside class="panel">
                <h2>Calcule el área y el perímetro de la circunferencia</h2>

                <div class="formulas">
                    <p>A = πr²</p>
                    <p>P = 2πr</p>
                </div>

                <svg class="dibujo" viewBox="0 0 300 300" aria-hidden="true">
                    <circle cx="150" cy="150" r="140"/>
                    <circle cx="150" cy="150" r="100"/>
                    <circle cx="150" cy="150" r="60"/>
                    <line x1="150" y1="150" x2="290" y2="150" class="radio"/>
                    <circle cx="150" cy="150" r="5" class="centro"/>
                    <text x="212" y="140">r</text>
                </svg>
            </aside>

            <!-- Formulario -->
            <form action="" method="post" id="frmLogin" novalidate>
                <img src="../imagenes/logo.jpg" alt="Logo de la institución">

                <h1>Bienvenida</h1>
                <p class="subtitulo">Ingrese con su correo y su clave.</p>

                <?php if ($mensaje !== '') : ?>
                    <div class="error" role="alert">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7.5v5.5M12 16.5v.01"/></svg>
                        <span><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                <?php endif; ?>

                <label class="campo" for="correo">
                    <span class="etiqueta">Correo</span>
                    <span class="entrada">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m4 8 8 5.5L20 8"/></svg>
                        <input type="email" name="correo" id="correo" placeholder="nombre@correo.com"
                               value="<?php echo htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'); ?>"
                               autocomplete="email" required>
                    </span>
                </label>

                <label class="campo" for="clave">
                    <span class="etiqueta">Clave</span>
                    <span class="entrada">
                        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9.5" rx="3"/><path d="M8.5 10.5V8a3.5 3.5 0 0 1 7 0v2.5"/></svg>
                        <input type="password" name="clave" id="clave" placeholder="Su clave"
                               autocomplete="current-password" required>
                        <button type="button" class="ojo" id="btnVer" aria-label="Mostrar clave">
                            <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="2.8"/></svg>
                        </button>
                    </span>
                </label>

                <button type="submit" id="btnIngresar">Ingresar</button>
            </form>
        </div>
    </main>

    <script>
        // Mostrar / ocultar clave
        const btnVer = document.getElementById('btnVer');
        const clave = document.getElementById('clave');
        btnVer.addEventListener('click', () => {
            const oculta = clave.type === 'password';
            clave.type = oculta ? 'text' : 'password';
            btnVer.setAttribute('aria-label', oculta ? 'Ocultar clave' : 'Mostrar clave');
            btnVer.classList.toggle('activo', oculta);
        });
    </script>
    <script src="../assetes/js/app.js"></script>
</body>
</html>