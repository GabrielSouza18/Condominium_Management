<?php
require_once 'assets/PHP/db_connect.php';
session_start();


$email = $_SESSION["email"];


$sql = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_email = '$email'";
$resultado = mysqli_query($conn, $sql);
$dados = mysqli_fetch_array($resultado);


$usu_tipo = $dados["usu_tipo"];
$nome = $dados['usu_nome'];
$primeiroLogin = isset($dados["usu_primeiroLogin"]) ? $dados["usu_primeiroLogin"] : 0;
// verificando se é o primeiro login
if ($primeiroLogin == true) {
    // definindo a variável de sessão "primeiroLogin" como true
    $_SESSION["primeiroLogin"] = true;
}
// redirecionando para a página apropriada
if ($usu_tipo != "morador" && $usu_tipo != "admin") {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Tela Inicial - CM</title>
    <link rel="icon" type="image/png" sizes="500x500" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/cssIcons.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
</head>
<!-- Tela Inicial Sindico -->

<body style="background-color:#EEF1F4;">
    <!-- CONTEUDO PARA DESKTOPS-->
    <div class="d-none d-lg-block">
        <nav class="navbar navbar-expand-sm navbar-dark " style="height: 80px; background-color:#353535;">
            <div class="container-fluid h-100">
                <a class="navbar-brand " href="dashboard_resident.php">
                    <img src="assets/img/logo.png" style="max-width: 60px;border-radius: 50%;">
                    <span class="d-inline-block align-middle mx-3">Condominium Management</span>
                </a>
                <div class="navbar-nav ms-auto h-100">
                    <li class="nav-item dropdown h-100">
                        <a class="nav-link dropdown-toggle h-100" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src='assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>'
                                alt="Imagem do Usuário" class="rounded-circle" width="50" height="50">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile_resident.php">Perfil</a></li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="assets/PHP/logout.php">Sair</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </nav>

        <div class=" text-center">

            <?php
            // Obtendo o nome do usuário logado
            $nome = $dados["usu_nome"];

            // Obtendo a hora atual
            $agora = date('H');

            if ($agora >= 6 && $agora <= 12) {
                $saudacao = "Bom dia";
            } elseif ($agora > 12 && $agora <= 18) {
                $saudacao = "Boa tarde";
            } else {
                $saudacao = "Boa noite";
            }
            echo "<h3 class='text-dark mt-5'>{$saudacao}, {$nome}!</h3>";
            
            ?>



            <div class="row justify-content-center">

                <div class="col-md-6 col-xl-3 mb-4 mt-5 ">
                    <div class="card shadow border-start-primary py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                        <span>Abrir Chamados</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0"></div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#myModal">
                                        <i class="gg-user text-gray-300"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-start-primary py-2 mt-3">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-danger fw-bold text-xs mb-1">
                                        <span>Ver Chamados Abertos</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0"></div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#myModal2">
                                        <i class="gg-mail text-gray-300"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-start-primary py-2 mt-3">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                        <span>Ver Chamados Andamento</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0"></div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#myModal3">
                                        <i class="gg-time text-gray-300"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-start-primary py-2 mt-3">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                        <span>Ver Chamados Finalizados</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0"></div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#myModal4">
                                        <i class="gg-check text-gray-300"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Abrir chamado-->
                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Abrir Chamados</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="assets/PHP/open_ticket.php" method="POST">
                                    <div class="mb-3">
                                        <label for="tipo-chamado" class="form-label">Tipo de Chamado</label>
                                        <select class="form-select" name="tipoChamado">

                                            <option value="infraestrutura">Infraestrutura</option>
                                            <option value="som">Som</option>
                                            <option value="sugestoes">Sugestões</option>
                                            <option value="outros">Outros</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="problema" class="form-label">Problema</label>
                                        <textarea class="form-control" id="problema" rows="3"
                                            name="problema"></textarea>
                                    </div>
                                    <input type="hidden" value="aberto" name="statusChamado">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal para Ver Chamados Abertos abertos -->
                <div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Chamados Abertos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body overflow-auto" style="max-height: 300px;">
                                <span>
                                    <?php

                                    $usu_id = 1;

                                    // Seleciona apenas os chamados abertos do usuário logado
                                    $sql_ab = " SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_tipo = 'morador' AND cha_status = 'aberto'";
                                    $resultado = mysqli_query($conn, $sql_ab);
                                    // Exibe os chamados abertos do usuário logado
                                    if (mysqli_num_rows($resultado) > 0) {
                                        echo "<p align='center'>Clique no chamado para ve-lo</p>";
                                        echo "<ul class='list-group '>";
                                        while ($dados = mysqli_fetch_array($resultado)) {
                                            echo "<li class='list-group-item d-flex align-items-center'>";
                                            echo "<i class='gg-bell'></i>&nbsp;&nbsp;";
                                            echo "<a class='mb-1 mt-2 fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate' href='resident_reply_request.php?chamado_id=" . $dados['cha_id'] . "'>";
                                            echo $dados['cha_tipo'];
                                            echo "</a>";
                                            echo "</li>";
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo "<p>Nenhum chamado aberto encontrado.</p>";
                                    }
                                    ?>

                                </span>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal para ver as respostas -->
                <div class="modal fade" id="myModal3" tabindex="-1" aria-labelledby="modalResponderLabel3"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalResponderLabel">Chamados em Andamento</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fechar"></button>
                            </div>
                            <?php
                            $usu_id = 1;
                            $dados = null; // Inicializa a variável $dados
                            
                            // Seleciona apenas os chamados abertos do usuário logado
                            $sql_andamento = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_tipo = 'morador' AND cha_status = 'em_andamento' ";
                            $resultado = mysqli_query($conn, $sql_andamento);

                            // Verifica se há registros retornados
                            if (mysqli_num_rows($resultado) > 0) {
                                // Exibe os chamados abertos do usuário logado
                                echo "<p align='center'>Clique no chamado para vê-lo</p>";
                                echo "<ul class='list-group'>";

                                while ($dados = mysqli_fetch_array($resultado)) {
                                    echo "<li class='list-group-item d-flex align-items-center'>";
                                    echo "<i class='gg-bell'></i>&nbsp;&nbsp;";
                                    echo "<a class='mb-1 mt-2 fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate' href='resident_reply_request.php?chamado_id=" . $dados['cha_id'] . "'>";
                                    echo $dados['cha_tipo'];
                                    echo "</a>";
                                    echo "</li>";
                                }

                                echo "</ul>";
                            } else {
                                echo "<p>Nenhum chamado fechado ou em andamento encontrado.</p>";
                            }
                            ?>

                            <form action="assets/PHP/reply_request.php" method="POST">
                                <?php if ($dados !== null) { ?>
                                    <input type="hidden" name="chamado_id" value="<?php echo $dados['cha_id']; ?>">
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="profile_resident.php"><i class="gg-profile mx-2"></i></a>
                        <label>Perfil</label>
                    </div>
                </div>

                <!-- -------------------------------------------------- -->
                <div class="modal fade" id="myModal4" tabindex="-1" aria-labelledby="modalResponderLabel4"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalResponderLabel">Chamados Finalizados</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fechar"></button>
                            </div>
                            <?php
                            $usu_id = 1;
                            $dados = null; // Inicializa a variável $dados
                            
                            // Seleciona apenas os chamados abertos do usuário logado
                            $sql_andamento = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_tipo = 'morador' AND cha_status = 'fechado' ";
                            $resultado = mysqli_query($conn, $sql_andamento);

                            // Verifica se há registros retornados
                            if (mysqli_num_rows($resultado) > 0) {
                                // Exibe os chamados abertos do usuário logado
                            
                                echo "<p align='center'>Clique no chamado para vê-lo</p>";
                                echo "<ul class='list-group'>";

                                while ($dados = mysqli_fetch_array($resultado)) {
                                    echo "<li class='list-group-item d-flex align-items-center'>";
                                    echo "<i class='gg-bell'></i>&nbsp;&nbsp;";
                                    echo "<a class='mb-1 mt-2 fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate' href='resident_reply_request.php?chamado_id=" . $dados['cha_id'] . "'>";
                                    echo $dados['cha_tipo'];
                                    echo "</a>";
                                    echo "</li>";
                                }

                                echo "</ul>";
                            } else {
                                echo "<p>Nenhum chamado fechado encontrado.</p>";
                            }
                            ?>

                            <form action="assets/PHP/reply_request.php" method="POST">
                                <?php if ($dados !== null) { ?>
                                    <input type="hidden" name="chamado_id" value="<?php echo $dados['cha_id']; ?>">
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="profile_resident.php"><i class="gg-profile mx-2"></i></a>
                        <label>Perfil</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTEUDO PARA DISPOSITIVOS MOVEIS -->
    <div class="d-block d-sm-none">
        <div id="wrapper">
            <div id="content">
                <nav class="navbar navbar-dark navbar-expand shadow mb-0 mt-0 topbar static-top"
                    style="background-color: #353535;">
                    <a class="navbar-brand d-md-none mx-auto" href="dashboard_manager.php">
                        <img src="assets/img/logo.png" style="max-width: 60px;border-radius: 50%;">
                    </a>
                </nav>
                <div class="container-fluid mb-0 mt-0">
                    <div class="d-flex justify-content-end">
                        <nav class="d-md-none">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">

                                    <a class="nav-link dropdown-toggle btn-sm" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php
                                        $sql = "SELECT * FROM usuario WHERE usu_email = '$email'";
                                        $resultado = mysqli_query($conn, $sql);
                                        $dados = mysqli_fetch_array($resultado);
                                        ?>
                                        <img src="assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>"
                                            alt="Imagem do perfil do usuário" class="rounded-circle"
                                            style="max-width: 40px;">
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-end"
                                        aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="assets/PHP/logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="container-fluid mt-5 mb-0">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <?php

                        $sql = "SELECT * FROM usuario  WHERE usu_email = '$email'";
                        $resultado = mysqli_query($conn, $sql);
                        $dados = mysqli_fetch_array($resultado);

                        // Obtendo o nome do usuário logado
                        $nome = $dados["usu_nome"];

                        // Obtendo a hora atual
                        $agora = date('H');


                        if ($agora >= 6 || $agora < 12) {
                            $saudacao = "Bom dia";
                        } elseif ($agora >= 12 || $agora <= 18) {
                            $saudacao = "Boa tarde";
                        } else {
                            $saudacao = "Boa noite";
                        }
                        echo "<h5 class='text-dark mt-5'>{$saudacao}, {$nome}!</h5>";
                        ?>


                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                                <span>Abrir Chamado</span>
                                            </div>

                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-primary d-md-none d-block"
                                                data-bs-toggle="modal" data-bs-target="#myModalMobile"><i
                                                    class="gg-user text-gray-300"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow border-start-primary py-2 mt-3">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-danger fw-bold text-xs mb-1">
                                                <span>Ver Chamados Abertos</span>
                                            </div>
                                            <div class="text-dark fw-bold h5 mb-0"></div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#myModalMobile2">
                                                <i class="gg-mail text-gray-300"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow border-start-primary py-2 mt-3">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                                <span>Ver Chamados Andamento</span>
                                            </div>
                                            <div class="text-dark fw-bold h5 mb-0"></div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#myModalMobile3">
                                                <i class="gg-time text-gray-300"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow border-start-primary py-2 mt-3">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                                <span>Ver Chamados Finalizados</span>
                                            </div>
                                            <div class="text-dark fw-bold h5 mb-0"></div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#myModalMobile4">
                                                <i class="gg-check text-gray-300"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Modal Abrir chamado-->
                        <div class="modal fade" id="myModalMobile" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Abrir Chamados</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="assets/PHP/open_ticket.php" method="POST">
                                            <div class="mb-3">
                                                <label for="tipo-chamado" class="form-label">Tipo de Chamado</label>
                                                <select class="form-select" name="tipoChamado">
                                                    <option value="infraestrutura">Infraestrutura</option>
                                                    <option value="som">Perturbação do sossego</option>
                                                    <option value="sugestoes">Sugestões</option>
                                                    <option value="outros">Outros</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="problema" class="form-label">Problema</label>
                                                <textarea class="form-control" id="problema" rows="3"
                                                    name="problema"></textarea>
                                            </div>
                                            <input type="hidden" value="aberto" name="statusChamado">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal para Ver Chamados Abertos abertos -->
                        <div class="modal fade" id="myModalMobile2" tabindex="-1" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-white">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Chamados Abertos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body overflow-auto" style="max-height: 300px;">
                                        <span>
                                            <!-- olhar aqui -->
                                            <?php
                                            $usu_id = 1;
                                            // Seleciona apenas os chamados abertos do usuário logado
                                            $sql_ab = " SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_tipo = 'morador' AND cha_status = 'aberto'";
                                            $resultado = mysqli_query($conn, $sql_ab);
                                            // Exibe os chamados abertos do usuário logado
                                            if (mysqli_num_rows($resultado) > 0) {

                                                echo "<p align='center'>Clique no chamado para ve-lo</p>";
                                                echo "<ul class='list-group '>";
                                                while ($dados = mysqli_fetch_array($resultado)) {
                                                    echo "<li class='list-group-item d-flex align-items-center'>";
                                                    echo "<i class='gg-bell'></i>&nbsp;&nbsp;";
                                                    echo "<a class='mb-1 mt-2 fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate'href='resident_reply_request.php?chamado_id=" . $dados['cha_id'] . "'>";
                                                    echo $dados['cha_tipo'];
                                                    echo "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo "<p>Nenhum chamado aberto encontrado.</p>";
                                            }
                                            ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal para ver as respostas -->
                        <div class="modal fade" id="myModalMobile3" tabindex="-1" aria-labelledby="modalResponderLabel3"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalResponderLabel">Chamados em Andamento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fechar"></button>
                                    </div>

                                    <div class="modal-body overflow-auto" style="max-height: 300px;">
                                        <span>
                                            <?php

                                            $usu_id = 1;

                                            // Seleciona apenas os chamados abertos do usuário logado
                                            $sql_andamento = " SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_tipo = 'morador' AND cha_status = 'em_andamento'";
                                            $resultado = mysqli_query($conn, $sql_andamento);
                                            // Exibe os chamados abertos do usuário logado
                                            if (mysqli_num_rows($resultado) > 0) {

                                                echo "<p align='center'>Clique no chamado para ve-lo</p>";
                                                echo "<ul class='list-group '>";
                                                while ($dados = mysqli_fetch_array($resultado)) {
                                                    echo "<li class='list-group-item d-flex align-items-center'>";
                                                    echo "<i class='gg-bell'></i>&nbsp;&nbsp;";
                                                    echo "<a class='mb-1 mt-2 fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate'href='resident_reply_request.php?chamado_id=" . $dados['cha_id'] . "'>";
                                                    echo $dados['cha_tipo'];
                                                    echo "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo "<p>Nenhum chamado em andamento encontrado.</p>";
                                            }
                                            ?>

                                        </span>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="myModalMobile4" tabindex="-1" aria-labelledby="modalResponderLabel3"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalResponderLabel">Chamados Finalizados</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fechar"></button>
                                    </div>

                                    <div class="modal-body overflow-auto" style="max-height: 300px;">
                                        <span>
                                            <?php

                                            $usu_id = 1;

                                            // Seleciona apenas os chamados abertos do usuário logado
                                            $sql_andamento = " SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_tipo = 'morador' AND cha_status = 'fechado'";
                                            $resultado = mysqli_query($conn, $sql_andamento);
                                            // Exibe os chamados abertos do usuário logado
                                            if (mysqli_num_rows($resultado) > 0) {

                                                echo "<p align='center'>Clique no chamado para ve-lo</p>";
                                                echo "<ul class='list-group '>";
                                                while ($dados = mysqli_fetch_array($resultado)) {
                                                    echo "<li class='list-group-item d-flex align-items-center'>";
                                                    echo "<i class='gg-bell'></i>&nbsp;&nbsp;";
                                                    echo "<a class='mb-1 mt-2 fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate'href='resident_reply_request.php?chamado_id=" . $dados['cha_id'] . "'>";
                                                    echo $dados['cha_tipo'];
                                                    echo "</a>";
                                                    echo "</li>";
                                                }
                                                echo "</ul>";
                                            } else {
                                                echo "<p>Nenhum chamado finalizado encontrado.</p>";
                                            }
                                            ?>

                                        </span>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-md-none d-flex justify-content-center align-items-center">
                            <a href="profile_resident.php"><i class="gg-profile mx-2"></i></a>
                            <label>Perfil</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="alterar-dados-modal" tabindex="-1" aria-labelledby="alterar-dados-modal-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alterar-dados-modal-label">Alterar dados do usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form action="assets/PHP/first_login_resident.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['id'] ?>">
                            <p>Olá, altere seus dados de login!</p>
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto:</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF:</label>
                            <input type="text" class="form-control" id="cpf" name="cpf"
                                onkeyup="this.value = formatCPF(this.value)" maxlength="14" required>
                        </div>
                        <div class="mb-3">
                            <label for="telFixo" class="form-label">Tel. Fixo</label>
                            <input type="text" class="form-control" id="telFixo" name="telefonefixo"
                                onkeyup="this.value = formatTel(this.value)" maxlength="13" required>
                        </div>
                        <div class="mb-3">
                            <label for="telMovel" class="form-label">Tel. Movél</label>
                            <input type="text" class="form-control" id="telMovel" name="telefonemovel"
                                onkeyup="this.value = formatTelM(this.value)" maxlength="14" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    // verificando se é o primeiro login
    if ($primeiroLogin == true) {
        // incluindo o script para exibir o modal de alterar dados
        echo '<script>var modal = new bootstrap.Modal(document.getElementById("alterar-dados-modal"), {keyboard: false}); modal.show();</script>';


        // atualizando o valor da coluna "usu_primeiroLogin" no banco de dados para false
        $sql = "UPDATE usuario SET usu_primeiroLogin = false WHERE usu_email = '$email'";
        $resultado = mysqli_query($conn, $sql);
    }
    ?>

</body>


</html>