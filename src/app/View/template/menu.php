<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=self::link('')?>" title="Sistema de Gerenciamento de Contratos e Prestações">SGCP - Contratos e Prestações</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li><a href="<?=self::link('')?>">Principal</a></li>
                    <li><a href="<?=self::link('clientes')?>">Clientes</a></li>
                    <?php if (App\Controller\Authentication::is_manager()):?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Terrenos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=self::link('terrenos')?>">Terrenos</a></li>
                                <li><a href="<?=self::link('terrenos/quadras')?>">Quadra</a></li>
                                <li><a href="<?=self::link('terrenos/lotes')?>">Lotes</a></li>
                            </ul>
                        </li>
                    <?php endif;?>
                    <?php if (App\Controller\Authentication::is_manager()):?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=self::link('relatorios/parcelas')?>">Parcelas</a></li>
                                <li><a href="<?=self::link('relatorios/contratos')?>">Contratos</a></li>
                                <li><a href="<?=self::link('relatorios/clientes')?>">Clientes</a></li>
                                <li><a href="<?=self::link('relatorios/usuarios')?>">Usuários</a></li>
                            </ul>
                        </li>
                    <?php endif;?>
                    <?php if (App\Controller\Authentication::is_admin()):?>
                        <li><a href="<?=self::link('usuarios')?>">Usuários</a></li>
                    <?php endif;?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?=self::link('usuarios/perfil')?>">Bem vindo <strong><?=$_SESSION['user_nome']?></strong></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=self::link('usuarios/perfil')?>">Perfil de Usuário</a></li>
                            <?php if (App\Controller\Authentication::is_admin()):?>
                                <li><a href="<?=self::link('configuracoes')?>">Configurações</a></li>
                            <?php endif;?>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=self::link('autenticacao/sair')?>">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="container-fluid">