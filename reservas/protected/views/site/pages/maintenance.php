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
                <p>O site está em manutenção, volte mais tarde.</p>
        </div>
    </div>
</div>