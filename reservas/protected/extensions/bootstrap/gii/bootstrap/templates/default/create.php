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
	$label=>array('index'),
	'Novo',
);\n";
?>

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1>Cadastro</h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
