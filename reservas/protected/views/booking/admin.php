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
	array('label'=>'Cadastrar Booking','url'=>array('create')),
	array('label'=>'Gerenciar Booking','url'=>array('admin')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('booking-grid', {
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
	'id'=>'booking-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			//'header'=>'resources_id',
            'name'=>'resources_id',
			'value'=>'$data->resource->toString()',
		),
		array(
			//'header'=>'users_id',
            'name'=>'users_id',
			'value'=>'$data->user->toString()',
		),
		array(
			//'header'=>'from',
            'name'=>'from',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->from))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		array(
			//'header'=>'to',
            'name'=>'to',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->to))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		array(
			//'header'=>'users_id',
            'name'=>'approved',
			'value'=>'($data->approved? "Aprovada" : "Aguardando Aprovação")',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions' => array('width' => '70px'),
            'template'=>'{approve}{disapprove}{view}{update}{delete}',
            'buttons'=>array(
                'approve' => array(
                    'label'=>'Aprovar',
                    'icon' => 'icon-ok-circle',
	                'url'=>'Yii::app()->createUrl("booking/approve", array("id"=>$data->id))',
                ),
                'disapprove' => array(
                    'label'=>'Reprovar',
                    'icon' => 'icon-ban-circle',
	                'url'=>'Yii::app()->createUrl("booking/disapprove", array("id"=>$data->id))',
                ),
            ),
		),
	),
)); ?>
