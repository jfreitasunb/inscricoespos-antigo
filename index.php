<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>

    <link rel="stylesheet" href="css/login.css" />
    <script type="text/javascript" src="js/remove_caracteres.js"></script>

  </head>

  <body>
    <div class="background">
     <form method="post" action="logar.php">
        <dl>
          <dt>Nome de Usuário:</dt>
          <dd><input autofocus type="text" name="usuario"/></dd>

          <dt>Senha:</dt>
          <dd><input type="password" name="senha"/></dd>

          <dt></dt>
          <dd><input  type= "submit" value="Entrar" /></dd>
        </dl>
     </form>

      <ul>
        <li><a href="mudarsenha/esqueceusenha.php">Esqueceu ou quer mudar senha ?</a></li>
        <?php
        include_once("config/config.php");
        if (($abertura_inscricoes <= date("Ymd")) and (date("Ymd") <= $encerramento_inscricaoes)) {
          echo '<li><a href="cadastro/novo-cadastroentrada.php">Criar uma conta e fazer inscrição</a></li>';
        }else{
          echo '<li><a href="encerramento.php">Criar uma conta e fazer inscrição</a></li>';
        }
        ?>
        
      </ul>
    </div>
  </body>
</html>

