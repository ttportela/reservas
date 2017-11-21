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
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="container well well-lg">
    <div class="row">
        <div class="col-xs-6 pull-left">
            <img src ="<?php echo Yii::app() -> request -> baseUrl; ?>/images/<?php echo Yii::app()->params['logo'];?>" alt='LOGO IFPR' />
        </div>
        <div class="col-xs-6 pull-right">
                <h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
                <p>Aplicação para reservas de laboratórios no IFPR - Campus Palmas.</p>
                <p>*Para uso de professores e técnicos administrativos do IFPR - Palmas.</p>
                <p>
                  <?php if (Yii::app()->user->isGuest) echo CHtml::link('Cadastre-se', array('user/new'), array('class'=>'btn btn-primary btn-lg', 'role'=>'button')); ?>
                  <?php if (Yii::app()->user->isGuest) echo CHtml::link('Login', array('site/login'), array('class'=>'btn btn-default btn-lg', 'role'=>'button')); ?>
                  <?php if (!Yii::app()->user->isGuest) echo CHtml::link('Reserve uma Sala', array('booking/create'), array('class'=>'btn btn-success btn-lg', 'role'=>'button')); ?>
                </p>
        </div>
    </div>
</div>