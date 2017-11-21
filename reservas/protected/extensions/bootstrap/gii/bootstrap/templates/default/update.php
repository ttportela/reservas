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
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Alterar',
);\n";
?>

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Cadastrar')),
	array('label'=>'','url'=>array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>), 'icon'=>'icon-info-sign', 'itemOptions'=>array('title'=>'Detalhes')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1><?php echo " <?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php echo \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>