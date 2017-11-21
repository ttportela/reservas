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


$this->widget('bootstrap.widgets.TbNavbar', array(
	    'type'=>'null', // null or 'inverse'
	    // 'brand'=>CHtml::encode(Yii::app()->name),
	    'brand' => '<img src ="' .Yii::app()->request->baseUrl .'/images/'.Yii::app()->params['logo'].'" />',
		'brandUrl'=>Yii::app()->homeUrl,
	    'collapse'=>true, // requires bootstrap-responsive.css
	    // 'encodeLabels'=>false,
	    'items'=>array(
	        array(
	            'class'=>'bootstrap.widgets.TbMenu',
	            'items'=>array(
	                array('label'=>'Manutenção', 'url'=>'#', 'visible'=>Yii::app()->helper->isAdmin(), 'items'=>array(
	                    array('label'=>'Usuários', 'url'=>array('/user/admin'), 'icon'=>'icon-user'),
	                    array('label'=>'Salas', 'url'=>array('/resource/admin'), 'icon'=>'fa fa-university'),
	                    '---',
	                    array('label'=>'Reservas', 'url'=>array('/booking/admin'), 'icon'=>'fa fa-flag'),
	                ), 'icon'=>'fa fa-database'),
                    //array('label'=>'Aprovar', 'url'=>array('/booking/admin'), 'icon'=>'fa fa-check-square-o', 'visible'=>Yii::app()->helper->isAdmin()),
                    array('label'=>'Aprovar Reservas', 'url'=>array('/booking/approve'), 'icon'=>'icon-ok-circle', 'visible'=>Yii::app()->helper->isAdmin()),
	                array('label'=>'Reservas', 'url'=>array('/booking/index', 'Booking[users_id]'=>Yii::app()->user->id), 'icon'=>'fa fa-flag', 'visible'=>!Yii::app()->user->isGuest),
	                array('label'=>'Reservar', 'url'=>array('/booking/create'), 'icon'=>'icon-edit', 'visible'=>!Yii::app()->user->isGuest),
	                array('label'=>'Cadastrar', 'url'=>array('/user/new'), 'icon'=>'icon-user', 'visible'=>Yii::app()->user->isGuest),
	            ),
	        ),
	        array(
	            'class'=>'bootstrap.widgets.TbMenu',
	            'htmlOptions'=>array('class'=>'pull-right'),
	            'items'=>array(
	                array('label'=>'', 'url'=>array('/site/index'), 'icon'=>'fa fa-home', 'itemOptions'=>array('class'=>'tooltipster','title'=>'Início')), //,'linkOptions'=>array('style'=>'color: #ffffff !important;')
					array('label'=>'', 'url'=>array('/site/page', 'view'=>'about'), 'icon'=>'fa fa-info', 'itemOptions'=>array('class'=>'tooltipster','title'=>'Sobre')),
					array('label'=>'', 'url'=>array('/site/contact'), 'icon'=>'fa fa-envelope', 'itemOptions'=>array('class'=>'tooltipster','title'=>'Contato')),
					array('label'=>'', 'url'=>array('/site/login'), 'icon'=>'fa fa-sign-in', 'visible'=>Yii::app()->user->isGuest, 'itemOptions'=>array('class'=>'tooltipster','title'=>'Login')),
					array('label'=>'', 'icon'=>'fa fa-user', 'url'=>array('/user/update', 'id'=>Yii::app()->user->id), 'visible'=>!Yii::app()->user->isGuest, 'itemOptions'=>array('class'=>'tooltipster','title'=>'Meus Dados')),
					array('label'=>'', 'icon'=>'fa fa-sign-out', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'itemOptions'=>array('class'=>'tooltipster','title'=>'Logout ('.Yii::app()->user->name.')'))
	            ),
	        ),
	    ),
	)
);
		
?>