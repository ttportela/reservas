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

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Reservas - IFPR Palmas',
    'theme' => 'bootstrap',
    'language'=>'pt',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.document.*',
        'application.extensions.CJuiDateTimePicker.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
//        'gii' => array(
//            'class' => 'system.gii.GiiModule',
//            'password' => 'qwe123',
//            // If removed, Gii defaults to localhost only. Edit carefully to taste.
//            'ipFilters' => array('127.0.0.1', '::1', '200.17.101.98'),
//            'generatorPaths' => array(
//                'bootstrap.gii',
//            ),
//        ),
    ),
    'catchAllRequest'=> (Yii::app()->params['maintenance'] == true && !Yii::app()->helper->isAdmin()? array('site/page', 'view'=>'maintenance') : null),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'authManager'=>array(
		    'class'=>'CPhpAuthManager',
		    // 'defaultRoles'=>array('authenticated'),
		),
        'helper' => array(
		            'class' => 'application.components.Helper',
		),
		// 'clientScript' => array(
            // 'class' => 'ext.yii-less-extension.components.YiiLessCClientScript',
            // 'cache' => true, // Optional parameter to enable or disable LESS File Caching
        // ),
		'format'=>array(
	        'class'=>'application.components.Formatter',
	    ),
		'doc'=>array(
	        'class'=>'application.components.document.DocumentHelper',
	    ),
	    'ePdf' => array(
	        'class'         => 'ext.yii-pdf.EYiiPdf',
	        'params'        => array(
	            'mpdf'     => array(
	                'librarySourcePath' => 'application.vendor.mpdf.*',
	                'constants'         => array(
	                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
	                ),
	                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
	                'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
	                    'mode'              => '', //  This parameter specifies the mode of the new document.
	                    'format'            => 'A4', // format A4, A5, ...
	                    'default_font_size' => 0, // Sets the default document font size in points (pt)
	                    'default_font'      => 'Arial', // Sets the default font-family for the new document.
	                    'mgl'               => 30, // margin_left. Sets the page margins for the new document.
	                    'mgr'               => 20, // margin_right
	                    'mgt'               => 47, // margin_top
	                    'mgb'               => 27, // margin_bottom
	                    'mgh'               => 10, // margin_header
	                    'mgf'               => 10, // margin_footer
	                    'orientation'       => 'P', // landscape or portrait orientation
	                )
	            ),
	            'HTML2PDF' => array(
	                'librarySourcePath' => 'application.vendor.html2pdf.*',
	                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
	                /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
	                    'orientation' => 'P', // landscape or portrait orientation
	                    'format'      => 'A4', // format A4, A5, ...
	                    'language'    => 'en', // language: fr, en, it ...
	                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
	                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
	                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
	                )*/
	            )
	        ),
	    ),
		'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=reservas',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
		            'class'=>'CFileLogRoute',
		            'levels'=>'trace, info, error, warning, vardump',
		        ),
		        array(
		            'class'=>'CWebLogRoute',
		            'enabled' => YII_DEBUG,
		            'levels'=>'error, warning, trace, log, vardump',
		            'categories' => 'application,vardump',
		            'showInFireBug'=>YII_DEBUG,
		        ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'si.palmas@ifpr.edu.br',
		'tablePrefix' => '',
        'maintenance' => false,
//        'maintenance' => true,
		//'logo' => 'icon-2.ico',
//		'logo' => 'icon.ico',
        'logo' => 'ifpr.png',
    ),
);
