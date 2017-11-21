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
	$model->id=>array('view','id'=>$model->toString()),
	'Alterar',
);

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Cadastrar')),
	array('label'=>'','url'=>array('view','id'=>$model->id), 'icon'=>'icon-info-sign', 'itemOptions'=>array('title'=>'Detalhes')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1><?php echo $model->toString(); ?></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'booking-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->uneditableRow($model,'users_id', Yii::app()->user->user, array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->selectorRow($model,'resources_id', 
			$model->resources_id, (Yii::app()->helper->set($model->resource)? $model->resource->toString():''),
			(Resource::model()), null); ?>

    <?php echo $form->dateTimeRow($model, 'from', array('class' => 'control-label')); ?>

    <?php echo $form->dateTimeRow($model, 'to', array('class' => 'control-label')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>