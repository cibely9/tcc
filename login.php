<!DOCTYPE html>
<html lang="en">

<?php

    session_start();

    $senha = "yohannalinda";
    $taErrado = false;
    if(isset($_POST['senha'])) {
        if($_POST['senha'] == $senha) {
            $_SESSION['senha'] = $senha;
            header("Location: /registro.php");
        } else {
            $taErrado = true;
        }
    }


?>

<?php include("./components/head.html"); ?>

<body>

<?php include("./components/navbar.html"); ?>
    <div id="container" style="display: flex; flex-direction: column; gap: 1rem;">
        <?php if($taErrado == true) { 
            echo "<h1 style='color: red;'>Senha inválida</h1>";
        } 
        ?>
        <form id="form" action="login.php" method="POST">
            <label for="senha">Digite a senha de acesso:</label>
            <input type="password" id="senha" name="senha" />
            <input type="submit" />
        </form>
    </div>

</body>

</html>