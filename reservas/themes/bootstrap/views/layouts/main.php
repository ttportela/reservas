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
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo Yii::app()->name; ?></title>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo Yii::app()->params['logo'];?>" type="image/x-icon"  />
	
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.ba-bbq.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.yii.js'); ?>
	<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.js'); ?>
	
	<?php Yii::app()->bootstrap->register(); ?>

	<?php $this->widget('ext.tooltipster.tooltipster'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
	
	
	<!-- Input Masks -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mask.min.js" type="text/javascript"></script>
	
	<!-- Extras -->
	<script src="//cdn.ckeditor.com/4.5.8/full/ckeditor.js"></script>	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<style type="text/css">
		.navbar .brand {
			padding: 0 !important;
			padding-top: 3px !important;
		}
		
		.navbar .brand img {
			width: 34px;
			height: 34px;
		}
		
		.row {
			margin: 0;
		}
	</style>
	
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/diario.css">

</head>

<body>

<!-- Google Analytics - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  -->
<?php include_once("_analyticstracking.php") ?>
<!--  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - - - -->

<!-- <?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Contact', 'url'=>array('/site/contact')),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
    ),
)); ?> -->
<?php include_once("_menu.php") ?>

<div class="container" id="page" style="width: 95%;">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	
	<?php include_once('_action_menu.php'); ?>
	
	<?php 
	    $this->widget('bootstrap.widgets.TbAlert', array(
		    'block'=>true, // display a larger alert block?
		    'fade'=>true, // use transitions?
		    // 'closeText'=>true, // close link text - if set to false, no close link is displayed
		    'id'=>'ihome-flash',
		    'alerts'=>array( // configurations per alert type
		    	'success'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
		        'info'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
		        'warning'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
		        'error'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
		        'danger'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
		    ),
		)); ?>
		
		<script language="JavaScript">
			window.setTimeout(function() { $(".alert-warning,.alert-success").alert('close'); }, 5000);
		</script><!-- messages -->

	<?php echo $content; ?>

	<div class="clear"></div>

	<!--div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
