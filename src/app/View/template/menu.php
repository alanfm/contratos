<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <section class="navbar-header">
                <a class="navbar-brand" href="<?=self::link('')?>" title="Sistema de Gerenciamento de Contratos e Prestações">SGCP - Contratos e Prestações</a>
            </section>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?=self::link('')?>">Principal</a></li>
                    <li><a href="<?=self::link('clientes')?>">Clientes</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Terrenos <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=self::link('terrenos')?>">Terrenos</a></li>
                            <li><a href="<?=self::link('terrenos/quadras')?>">Quadra</a></li>
                            <li><a href="<?=self::link('terrenos/lotes')?>">Lotes</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=self::link('relatorios/parcelas')?>">Parcelas</a></li>
                            <li><a href="<?=self::link('relatorios/contratos')?>">Contratos</a></li>
                            <li><a href="<?=self::link('relatorios/clientes')?>">Clientes</a></li>
                        </ul>
                    </li>
                    <li><a href="<?=self::link('usuarios')?>">Usuários</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=self::link('usuarios/perfil')?>">Perfil de Usuário</a></li>
                            <li><a href="<?=self::link('configuracoes')?>">Configurações</a></li>
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