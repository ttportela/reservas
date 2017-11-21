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
	'Cadastro',
);

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1>Cadastro</h1>

<?php 

if (!$confirmed) {

    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'user-form',
        'enableAjaxValidation'=>false,
    )); ?>

	<p class="help-block">Informe o seu usuário do e-mail institucional do IFPR.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
        <div class="input-group">
          <?php echo $form->textField($model,'user',array('class'=>'span5 form-control', 'aria-describedby'=>'basic-addon2','maxlength'=>20)); ?>
          <span class="input-group-addon" id="basic-addon2"><b>@ifpr.edu.br</b></span>
        </div>
		<?php echo $form->error($model,'user'); ?>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Enviar',
		)); ?>
	</div>

<?php $this->endWidget(); 
} else { ?>

    <p><?php echo CHtml::link('<< Voltar', array('user/new'), array('class'=>'btn btn-warning', 'role'=>'button')); ?></p>
    
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'user-form',
        'enableAjaxValidation'=>false,
    )); ?>

	<p class="help-block">Um e-mail foi enviado para você, digite o código de confirmação recebido e
        preencha se cadastro.</p>

    <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'verification',array('class'=>'span5','maxlength'=>20)); ?>

    <hr/>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'user',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->passwordFieldRow($model,'repeat_password',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>

    <?php $this->endWidget();
    
} ?>
