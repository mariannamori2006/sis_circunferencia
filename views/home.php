<?php
session_start();

require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/CircunferenciaController.php';

AuthController::verificarSesion();

$circunferenciaController = new CircunferenciaController();

$mensaje = $_GET['mensaje'] ?? '';
$mensajeFormulario = $circunferenciaController->procesarFormulario();

if ($mensajeFormulario !== '') {
    $mensaje = $mensajeFormulario;
}

$buscar = trim($_GET['buscar'] ?? '');
$registroEditar = null;

if (isset($_GET['editar'])) {
    $registroEditar = $circunferenciaController->obtenerParaEditar(
        (int) $_GET['editar']
    );
}

$registros = $circunferenciaController->listar($buscar);

$idActual = $registroEditar['id_circunferencia'] ?? '';
$radioActual = $registroEditar['radio'] ?? '';
$detalleActual = $registroEditar['detalle'] ?? '';
$areaActual = $registroEditar['area'] ?? '';
$perimetroActual = $registroEditar['perimetro'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="index,follow">
    <meta
        name="description"
        content="Sistema para calcular el área y perímetro de una circunferencia"
    >
    <meta
        name="keywords"
        content="circunferencia, radio, área, perímetro, matemáticas"
    >
    <meta name="author" content="BC TECH">

    <link rel="icon" href="../imagenes/icono.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,600&display=swap">
    <link rel="stylesheet" href="../assetes/css/style_home.css">

    <title>Circunferencia - Inicio</title>
</head>
<body>

<header class="headeerHome">
    <div class="lineaSup">
        <div class="logo-links">
            <div class="logo">
                <img src="../imagenes/logo.jpg" alt="Logo">
                <h1>Matemáticas</h1>
            </div>

            <a href="#">Quiénes somos</a>
        </div>

        <div class="buscarHeader">
            <form action="home.php" method="get" class="form1">
                <span class="campoBuscar">
                    <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4 4"/></svg>
                    <input
                        type="text"
                        name="buscar"
                        placeholder="Buscar por radio"
                        value="<?= htmlspecialchars($buscar, ENT_QUOTES, 'UTF-8') ?>"
                    >
                </span>

                <button type="submit" class="btnBuscar">Buscar</button>
            </form>
        </div>
    </div>

    <div class="lineaInf">
        <nav class="menu">
            <ul>
                <li><a href="home.php">Inicio</a></li>
                <li><a href="#">Nuestra historia</a></li>
                <li>
                    <a
                        href="logout.php"
                        onclick="return confirm('¿Desea cerrar sesión?');"
                    >
                        Cerrar sesión
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="datos">
        <div class="titulo">
            <h1>Área y perímetro de una circunferencia</h1>

            <p>
                Usuario:
                <?= htmlspecialchars(
                    (string) ($_SESSION['usuario'] ?? ''),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>
        </div>

        <?php if ($mensaje !== '') : ?>
            <p class="mensaje">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form
            action="home.php"
            method="post"
            class="form2"
            id="frmFormulario"
        >
            <input
                type="hidden"
                name="id_circunferencia"
                value="<?= htmlspecialchars((string) $idActual, ENT_QUOTES, 'UTF-8') ?>"
            >

            <div class="inputs">
                <label for="txtRadio">Radio</label>

                <input
                    class="inputHome"
                    type="number"
                    name="txtRadio"
                    id="txtRadio"
                    placeholder="Ingrese el radio"
                    min="0.000001"
                    step="any"
                    required
                    value="<?= htmlspecialchars((string) $radioActual, ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtDetalle">Comentario</label>

                <input
                    class="inputHome"
                    type="text"
                    name="txtDetalle"
                    id="txtDetalle"
                    placeholder="Opcional: un comentario"
                    value="<?= htmlspecialchars((string) $detalleActual, ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtA">Área</label>

                <input
                    class="inputHome"
                    type="text"
                    name="txtA"
                    id="txtA"
                    readonly
                    placeholder="Área calculada"
                    value="<?= htmlspecialchars((string) $areaActual, ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="inputs">
                <label for="txtP">Perímetro</label>

                <input
                    class="inputHome"
                    type="text"
                    name="txtP"
                    id="txtP"
                    readonly
                    placeholder="Perímetro calculado"
                    value="<?= htmlspecialchars((string) $perimetroActual, ENT_QUOTES, 'UTF-8') ?>"
                >
            </div>

            <div class="botones">
                <button
                    type="button"
                    class="btn btn-calcular"
                    onclick="calcularCircunferencia();"
                >
                    Calcular
                </button>

                <a class="btn-link cancelar" href="home.php">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-guardar"
                    name="accion"
                    value="guardar"
                >
                    <?= $idActual !== '' ? 'Actualizar' : 'Guardar' ?>
                </button>
            </div>
        </form>
    </div>

    <div class="buscar">
        <form action="home.php" method="get" id="frmBuscar">
            <span class="campoBuscar">
                <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 4 4"/></svg>
                <input
                    type="text"
                    name="buscar"
                    placeholder="Buscar por radio"
                    value="<?= htmlspecialchars($buscar, ENT_QUOTES, 'UTF-8') ?>"
                >
            </span>

            <button type="submit" class="btnBuscar">Buscar</button>

            <a class="btn-link limpiar" href="home.php">Limpiar</a>
        </form>
    </div>

    <div class="tabla">
        <h1>Historial de los cálculos</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Radio</th>
                    <th>Detalle</th>
                    <th>Área</th>
                    <th>Perímetro</th>
                    <th>Fecha y hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($registros) > 0) : ?>

                    <?php foreach ($registros as $fila) : ?>
                        <tr>
                            <td>
                                <?= (int) $fila['id_circunferencia'] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars((string) $fila['radio'], ENT_QUOTES, 'UTF-8') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars((string) ($fila['detalle'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars((string) $fila['area'], ENT_QUOTES, 'UTF-8') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars((string) $fila['perimetro'], ENT_QUOTES, 'UTF-8') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars((string) $fila['fecha_registro'], ENT_QUOTES, 'UTF-8') ?>
                            </td>

                            <td class="acciones">
                                <a
                                    class="btn-tabla editar"
                                    href="home.php?editar=<?= (int) $fila['id_circunferencia'] ?>"
                                >
                                    Editar
                                </a>

                                <form
                                    action="home.php"
                                    method="post"
                                    onsubmit="return confirm('¿Desea eliminar este registro?');"
                                >
                                    <input
                                        type="hidden"
                                        name="id_circunferencia"
                                        value="<?= (int) $fila['id_circunferencia'] ?>"
                                    >

                                    <button
                                        class="btn-tabla eliminar"
                                        type="submit"
                                        name="accion"
                                        value="eliminar"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="7">
                            No hay registros para mostrar.
                        </td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="../assetes/js/app.js?v=3"></script>

</body>
</html>