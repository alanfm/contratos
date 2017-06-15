<?php
if (isset($_SESSION['authenticated']) &&
    $_SESSION['authenticated'] === md5($_SERVER['HTTP_USER_AGENT'])) {
    \System\Utilities::redirect('');
}
?>
<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <base href="<?=URL_BASE?>">
        <meta charset="UTF-8">
        <title>SGCP - Contratos e Prestações</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="public/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
        <style type="text/css">
            html {
                position: relative;
                min-height: 100%;
            }
            body{
                font-family: 'Dosis', sans-serif;
                /* Margin bottom by footer height */
                margin-bottom: 60px;
            }
            .title {
                margin-top: 6rem;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="well title">
                        <h4 class="text-center">SGCP - Sistema de Gerencimento de Contratos e Prestações</h4>
                    </div>
                    <div class="well">
                        <?php if (isset($_SESSION['alert'])): ?>
                        <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
                        </div>
                        <?php endif;?>
                        <form action="<?=self::link('autenticacao/entrar')?>" method="post">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" class="form-control input-lg" id="email" placeholder="E-mail do usuário" autocomplete="off" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" name="senha" class="form-control input-lg" id="senha" placeholder="Senha" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-default btn-lg">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
        <script src="public/js/jquery-3.1.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>
    </body>
</html>