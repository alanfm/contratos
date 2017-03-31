<section class="row">
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Clientes</h3>
            </div>
            <div class="panel-body">Total de Clientes Cadastrados: 010</div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> Contratos</h3>
            </div>
            <div class="panel-body">Total de Contratos Cadastrados: 015</div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-braille" aria-hidden="true"></i> Quadras</h3>
            </div>
            <div class="panel-body">Total de Quadras Cadastrados: 015</div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-square-o" aria-hidden="true"></i> Lotes</h3>
            </div>
            <div class="panel-body">Total de Lotes Cadastrados: 015</div>
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
                    <th>Terreno</th>
                    <th>Quadra</th>
                    <th>Dimenssões LxC</th>
                    <th>Valor</th>
                    <th>Situação</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 10; $i++): ?>
                <tr>
                    <td><?=str_pad((string)rand(1, 999), 4, "0", STR_PAD_LEFT)?></td>
                    <td>0252</td>
                    <td>0021</td>
                    <td>6.00 x 25.00</td>
                    <td>R$ 12.000,00</td>
                    <td><?=rand(0,1)? 'Aberto': 'Vendido';?></td>
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
</div>