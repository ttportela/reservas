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
            
    if ((!isset($this->menu) || empty($this->menu)) && Yii::app()->controller->id != 'site')     
    if (Yii::app()->controller->action->id == 'admin') {
    	$this->menu=array(
			array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Lista')),
			array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Novo')),
		);
    } else if (Yii::app()->controller->action->id == 'create') {
    	$this->menu=array(
			array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Lista')),
			array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar'), 'visible'=>(Yii::app()->helper->isAdmin())),
		);
    } else if (Yii::app()->controller->action->id == 'index') {
		$this->menu=array(
			array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Novo')),
			array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar'), 'visible'=>(Yii::app()->helper->isAdmin())),
		);
    } else if (Yii::app()->controller->action->id == 'update') {
    	$this->menu=array(
			array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Lista')),
			array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Novo')),
			array('label'=>'','url'=>array('view','id'=>$_GET['id']), 'icon'=>'icon-info-sign', 'itemOptions'=>array('title'=>'Detalhes')),
			array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar'), 'visible'=>(Yii::app()->helper->isAdmin())),
		);
    } else if (Yii::app()->controller->action->id == 'view') {
    	$this->menu=array(
			array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Lista')),
			array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Novo')),
			array('label'=>'','url'=>array('update','id'=>$_GET['id']), 'icon'=>'icon-edit', 'itemOptions'=>array('title'=>'Editar')),
			array('label'=>'','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$_GET['id']),'confirm'=>'Tem certeza que deseja excluir este item?'), 'icon'=>'icon-remove', 'itemOptions'=>array('title'=>'Excluir'), 'visible'=>(Yii::app()->helper->isAdmin())),
			array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar'), 'visible'=>(Yii::app()->helper->isAdmin())),
		);
    } //else if (Yii::app()->controller->action->id == 'admin') {
//     	
    // }
    
    if (isset($this->menu_add) || !empty($this->menu_add)) {
    	$this->menu = array_merge($this->menu, $this->menu_add);
    }
	       
    $this->beginWidget('zii.widgets.CPortlet', array(
        //'title'=>'Ações',
        'title'=>'',
    ));
    $this->widget('bootstrap.widgets.TbMenu', array(
        'items'=>$this->menu,
        'stacked' => false,
        'htmlOptions'=>array('class'=>'operations nav nav-pills'),
    ));
    $this->endWidget();
			
?>