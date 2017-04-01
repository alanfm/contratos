<!DOCTYPE html>
    <html lang="en">
    <head>
        <base href="<?=URL_BASE?>">
        <meta charset="UTF-8">
        <title>SGCP - Erro 404</title>        
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
                margin-top: 6rem;
            }
        </style>
    </head>
    <body>
        <main class="container-fluid">
            <section class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <aside class="jumbotron text-center">
                        <h2 class="text-danger"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i></h2>
                        <h1>Erro 404</h1>
                        <p>Página não encontrada! Tente novamente mais tarde!</p>
                        <p>
                            <a href="#" class="btn btn-lg btn-default" onclick="history.go(-1);" title="Voltar"><i class="fa fa-chevron-left fa-lg" aria-hidden="true"></i></a>
                            <a href="<?=self::correntURL()?>" class="btn btn-lg btn-default" title="Recarregar"><i class="fa fa-refresh fa-lg" aria-hidden="true"></i></a>
                            <a href="<?=self::link('')?>" class="btn btn-lg btn-default" title="Página Inicial"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a>
                        </p>
                    </aside>
                </div>
            </section>
        </main>
    </body>
</html>