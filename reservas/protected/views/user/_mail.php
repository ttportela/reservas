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
<html><head>
 <title>Reservas IFPR - Palmas</title>
</head>
<body>
<style type="text/css">
    
    div, p, h3 {
        font-family: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; line-height: 1.1;
    }
        
.flex-container {
    display: -webkit-flex;
    display: flex;  
    -webkit-flex-flow: row wrap;
    flex-flow: row wrap;
}

.flex-container > * {
    padding: 15px;
    -webkit-flex: 1 100%;
    flex: 1 100%;
}

</style>
<div class="flex-container">
    <div style="font-weight:900; font-size: 10px; text-transform: uppercase; padding:10px; margin-bottom: 15px;color:#000;background-color: #bbebbb;color:#444;text-align: center;">
      <h1>Reservas IFPR - Campus Palmas</h1>
    </div>

    <h3 style="margin-bottom:15px; color:#000;">Olá, <?php echo $model->user; ?></h3>
    <p class="lead" style="margin-bottom:15px; color:#000;font-size:17px;">Para fazer o seu cadastro copie e cole o código abaixo no campo "Código de Verificação" da página de cadastro:</p>

    <p style="text-align: center;color:#000;font-weight: normal; font-size:14px; line-height:1.6;padding:15px;background-color:#ECF8FF;margin-bottom: 15px;font-weight:bold;"><?php echo $_SESSION['verification']; ?></p>


    <p align="center">
        <a href="http://palmas.ifpr.edu.br" style="color: #2BA6CB;">IFPR-Palmas</a> |
        <a href="http://reservas.tarlis.com.br" style="color: #2BA6CB;">Sistema de Reservas</a>
    </p>
</div>

</body></html>