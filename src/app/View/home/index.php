<section class="row">
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-user-circle-o fa-lg" aria-hidden="true"></i> Clientes
                    <a href="<?=self::link('clientes')?>" class="btn btn-default btn-xs pull-right" title="Novo"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                </h3>
            </div>
            <div class="panel-body"><h3>Clientes Cadastrados: <?=$clientes_count;?></h3></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-file-text-o fa-lg" aria-hidden="true"></i> Contratos
                </h3>
            </div>
            <div class="panel-body"><h3>Contratos Cadastrados: <?=$contratos_count;?></h3></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-plus-square-o fa-lg" aria-hidden="true"></i> Quadras
                    <a href="<?=self::link('terrenos/quadras')?>" class="btn btn-default btn-xs pull-right" title="Novo"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                </h3>
            </div>
            <div class="panel-body"><h3>Quadras Cadastrados: <?=$quadras_count;?></h3></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-square-o fa-lg" aria-hidden="true"></i> Lotes
                    <a href="<?=self::link('terrenos/lotes')?>" class="btn btn-default btn-xs pull-right" title="Novo"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
                </h3>
            </div>
            <div class="panel-body"><h3>Lotes Cadastrados: <?=$lotes_count;?></h3></div>
        </div>
    </div>
</section>
<div class="row">
    <section class="col-lg-6">
        <h3>Contratos</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Data do contrato</th>
                    <th>Prestações</th>
                    <th>Quadra/Terreno</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 10; $i++): ?>
                <tr>
                    <td><?=str_pad((string)rand(1, 999), 4, "0", STR_PAD_LEFT)?></td>
                    <td>Fulano dos Anzois Pereira</td>
                    <td>03/05/2016</td>
                    <td>36x</td>
                    <td>002/016</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="#" class="btn btn-info btn-xs" title="Mais Informações"><i class="fa fa-info-circle fa-lg" aria-hidden="true"></i></a>
                            <a href="#" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                            <a href="#" class="btn btn-danger btn-xs" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
    </section>
    <section class="col-lg-6">
        <h3>Terrenos</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lote</th>
                    <th>Dimenssões LxC</th>
                    <th>Valor</th>
                    <th>Situação</th>
                    <th>Quadra</th>
                    <th>Terreno</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lotes as $lote): ?>
                <tr>
                    <td><?=str_pad((string) $lote->id, 3, "0", STR_PAD_LEFT)?></td>
                    <td><?=$lote->descricao?></td>
                    <td><?=$lote->largura . 'x' . $lote->comprimento?></td>
                    <td><?=$lote->valor?></td>
                    <td><?=ucfirst($lote->situacao)?></td>
                    <td><?=$lote->quadra?></td>
                    <td><?=$lote->terreno?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="#" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                            <a href="#" class="btn btn-danger btn-xs" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </section>
</div>