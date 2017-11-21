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
	'Gerenciar',
);

/*$this->menu=array(
	array('label'=>'Cadastrar User','url'=>array('create')),
	array('label'=>'Gerenciar User','url'=>array('admin')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gerenciar <?php echo $this->modelName; ?></h1>

<!-- <p>
Você pode, opcionalmente, incluir um operador de comparação (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
ou <b>=</b>) antes de cada campo de pesquisa.
</p> -->

<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			//'header'=>'name',
            'type'=>'raw',
            'name'=>'name',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->name)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			//'header'=>'user',
            'type'=>'raw',
            'name'=>'user',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->user)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
