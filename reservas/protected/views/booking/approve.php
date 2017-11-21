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
	$this->modelName=>array('admin'),
	'Aprovar Reservas',
);

?>

<h1>Aprovar <?php echo $this->modelName; ?></h1>


<?php 
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'approve-form',
	'enableAjaxValidation'=>false,
));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'submit',
    'type'=>'primary',
    //'name' => 'ApproveButton',
    'label'=>'Aprovar Selecionadas',
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'booking-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows' => 2,
	'columns'=>array(
//        array(
//            'header'=>' ',
//            'class'=>'CDataColumn',
//            'type'=>'raw',
//            'htmlOptions'=>array('style'=>'text-align:center'),
//            'value' => 'CHtml::checkBox("selectedIds[]", $data->id, array("value"=>$data->id,"id"=>"selectedIds_".$data->id))',
//        ),
        array(
            'id' => 'selectedIds',
            'class' => 'CCheckBoxColumn'
        ),
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
            'template'=>'{approve}{disapprove}',
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

<?php $this->endWidget(); ?>