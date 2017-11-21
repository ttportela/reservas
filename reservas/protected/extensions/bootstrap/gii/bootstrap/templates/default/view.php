<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label="\$this->modelName";//$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	$label=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Cadastrar')),
	array('label'=>'','url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>), 'icon'=>'icon-edit', 'itemOptions'=>array('title'=>'Alterar')),
	array('label'=>'','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Tem certeza que deseja excluir este item?'), 'icon'=>'icon-remove', 'itemOptions'=>array('title'=>'Excluir')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1><?php echo " #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	if ($column->isForeignKey) {
		echo "\t\tarray(\n".
			"\t\t\t'visible'=>\$model->".$column->name." == null ? false : true,\n".
			"\t\t\t'name'=>'".$column->name."',\n".
			"\t\t\t'value'=>\$model->".$column->name."\n\t\t),\n";
	} else {
		echo "\t\t'".$column->name."',\n";
	} 

?>
	),
)); ?>
