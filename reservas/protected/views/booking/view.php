<?php /**
    This file is part of Sistema de Reservas.
    Copyright (C) 2017  Tarlis Tortelli Portela <tarlis@tarlis.com.br>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/?>
<?php
$this->breadcrumbs=array(
	$this->modelName=>array('index'),
	$model->toString(),
);

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Cadastrar')),
	array('label'=>'','url'=>array('update','id'=>$model->id), 'icon'=>'icon-edit', 'itemOptions'=>array('title'=>'Alterar')),
	array('label'=>'','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Tem certeza que deseja excluir este item?'), 'icon'=>'icon-remove', 'itemOptions'=>array('title'=>'Excluir')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1>Reserva #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'visible'=>$model->resources_id == null ? false : true,
			'name'=>'resources_id',
			'value'=>$model->resource->toString()
		),
		array(
			'visible'=>$model->users_id == null ? false : true,
			'name'=>'users_id',
			'value'=>$model->user->toString()
		),
		'from',
		'to',
		array(
			//'header'=>'users_id',
            'name'=>'approved',
			'value'=>($model->approved? "Aprovada" : "Aguardando Aprovação"),
		),
	),
)); ?>
