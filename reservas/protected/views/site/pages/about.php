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

$this->pageTitle=Yii::app()->name . ' - Sobre';
$this->breadcrumbs=array(
	'Sobre',
);
?>
<h1>Sobre</h1>

<p>O <?php echo CHtml::encode(Yii::app()->name); ?> está em versão Beta</p>
<p>Em desenvolvimento by Tarlis Portela (tarlis.portela @ ifpr.edu.br).</p>
