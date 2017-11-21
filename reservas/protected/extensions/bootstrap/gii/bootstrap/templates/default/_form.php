<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
	
	if ($column->isForeignKey) {
		
		echo "\t<div>\n\t\t<small><?php echo \$form->labelEx(\$model,'".$column->name."'); ?></small>\n".
		"\t\t<?php echo \$form->dropDownList(\$model, '".$column->name."', CHtml::listData(\n".
		"\t\t".$this->getRelationModelClass($column->name)."::model()->findAll(), 'id', 'id'), // Maybe you have to chage de value column to another\n".
		"\t\tarray('prompt' => '...','class'=>'span5')); ?>\n".
		"\t\t<?php echo \$form->error(\$model,'".$column->name."'); ?>\n\t</div>\n"; 
	
	} else if ($column->dbType == 'date' || $column->dbType == 'datetime') {
		
		echo "\t<div class='control-group'>\n".
		"\t\t<?php echo \$form -> labelEx(\$model, '".$column->name."', array('class' => 'control-label')); ?>\n".
		"\t\t<div class='controls'>\n\t\t<?php\n".
		"\t\t\t\$this->widget('zii.widgets.jui.CJuiDatePicker',array(\n".
		"\t\t\t\t'model'=>\$model,\n".
		"\t\t\t\t'attribute'=>'".$column->name."',\n".
		"\t\t\t\t'options'=>array(\n".
		"\t\t\t\t\t'dateFormat' => 'yy-mm-dd',\n".
		"\t\t\t\t\t'showAnim'=>'fold',\n".
		"\t\t\t\t),\n".
		"\t\t\t\t'htmlOptions'=>array(\n".
		"\t\t\t\t\t'style'=>'',\n".
		"\t\t\t\t\t'value'=>(isset(\$model->".$column->name.")? \$model->".$column->name." : date('Y-m-d')),\n".
		"\t\t\t\t),\n\t\t\t));\n\t\t?>\n\t\t</div>\n".
		"\t\t<?php echo \$form -> error(\$model, '".$column->name."'); ?>\n".
		"\t</div>\n\n";
	
	} else {

?>
	<?php echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; ?>

<?php
	}
}
?>
	<div class="form-actions">
		<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>\$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
