<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label="\$this->modelName";//$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	$label,
);\n";
?>

/*$this->menu=array(
	array('label'=>'Cadastrar <?php echo $this->modelClass; ?>','url'=>array('create')),
	array('label'=>'Gerenciar <?php echo $this->modelClass; ?>','url'=>array('admin')),
);*/


/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<h1><?php echo "<?php echo \$this->modelName; ?>";//$this->pluralize($this->class2name($this->modelClass)); ?></h1>

<!-- <p>
Você pode, opcionalmente, incluir um operador de comparação (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
ou <b>=</b>) antes de cada campo de pesquisa.
</p> 

<?php echo "<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button btn')); ?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement || $column->name == 'password')
		continue;
	
	if(++$count==7)
		echo "\t\t/*\n";
	if ($column->name == 'id') {
		echo "\t\t//'".$column->name."',\n";
	} else if ($column->isForeignKey) {
?>
		array(
			//'header'=>'<?php echo $column->name; ?>',
            'name'=>'<?php echo $column->name; ?>',
			'value'=>'$data-><?php echo str_replace('_id', '', $column->name); ?>->toString()',
		),
<?php		
	} else if (stristr($column->dbType, 'date') != false || stristr($column->dbType, 'datetime') != false) {
?>
		array(
			//'header'=>'<?php echo $column->name; ?>',
            'name'=>'<?php echo $column->name; ?>',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data-><?php echo $column->name; ?>))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
<?php	
	} else if (stristr($column->dbType, 'float') != false || stristr($column->dbType, 'decimal') != false || stristr($column->dbType, 'double') != false) {
?>
		array(
			//'header'=>'<?php echo $column->name; ?>',
            'name'=>'<?php echo $column->name; ?>',
			'value'=>'Yii::app()->helper->formatNumber($data-><?php echo $column->name; ?>, 2)',
			'htmlOptions' => array('style' => 'text-align:right;'),
		),
<?php	
	} else if (stristr($column->dbType, 'text') != false) {
?>
		array(
			//'header'=>'<?php echo $column->name; ?>',
            'type'=>'raw',
            'name'=>'<?php echo $column->name; ?>',
			'value'=>'str_replace(PHP_EOL, "<br />", $data-><?php echo $column->name; ?>)',
			'htmlOptions' => array('max-width' => '30%'),
		),
<?php	
	} else {
		echo "\t\t'".$column->name."',\n";
	}

}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
