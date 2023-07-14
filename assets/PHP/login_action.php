<?php
require_once 'db_connect.php';
session_start();

// verificando se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // obtendo os valores do formulário
  $email = $_POST["email"];
  $password = $_POST["password"];

  // verificando se o usuário existe como síndico ou morador
  $query = "SELECT * FROM usuario WHERE usu_email = ? LIMIT 1";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) == 1) {
    $dados = mysqli_fetch_array($result);

    // verificando se o e-mail informado corresponde ao e-mail do registro retornado
    if ($dados['usu_email'] === $email) {
      // obtendo a senha hash do usuário
      $hash = $dados['usu_senha'];
      // verificando se a senha fornecida pelo usuário corresponde à senha hash
      if (password_verify($password, $hash)) {
        // obtendo o tipo de usuário
        $usu_tipo = $dados["usu_tipo"];

        $_SESSION['email'] = $email;
        $id = $dados['usu_id'];
        $_SESSION['id'] = $id;

        // redirecionando para a página apropriada
        if ($usu_tipo == "sindico") {
          header("Location: ../../dashboard_manager.php");
          exit();
        } elseif ($usu_tipo == "morador") {
          header("Location: ../../dashboard_resident.php");
          exit();
        } elseif ($usu_tipo == "admin") {
          header("Location: ../../admin.php");
          exit();
        }
      }
    }
  }
  // redirecionando de volta para a página de login com mensagem de erro na sessão
  $_SESSION["error"] = "Email ou senha incorretos!";
  header("Location: ../../index.php");
  exit();

}