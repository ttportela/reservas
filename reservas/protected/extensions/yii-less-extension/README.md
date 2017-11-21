Yii Less Extension 0.5
======================

Yii Less Extension gives a _VERY_ simple and straight forward way to include LESS files in your Yii view files. Yii Less Extension adds a method to the `CClientScript` class, namely `registerLessFile` which is very similary to the `registerCssFile` method, to directly link LESS files in your Yii view files.

##Requirements

Requires Yii 1.1 or above.

##Usage
* Download and extract the extension package to `protected/extensions` directory of your application.
* Make the following modifications to your `protected/config/main.php` under the components section of the config:
~~~
<?php 
    return array(
        // .....
        'components'=>array(
            // .....
            'clientScript' => array(
                'class' => 'ext.yii-less-extension.components.YiiLessCClientScript',
                'cache' => true, // Optional parameter to enable or disable LESS File Caching
            ),
            // .....
        ),
        // .....
    ),
?>
~~~

* In any of your view files just include your less file using `Yii::app()->clientScript->registerLessFile("full-or-relative-path-to-your-less-file/style.less");`

##Examples


* Adding the following in your `layouts/main.php` will render `<web-application-root>/less-files/site.less` file as `site.css` delivered from your assets.
~~~
<?php Yii::app()->clientScript->registerLessFile(Yii::getPathOfAlias("less-files/site.less")); ?>
~~~

* The following code will render its corresponding CSS as shown
~~~
<?php Yii::app()->clientScript->registerLess('sample-less', '
    body {
        padding: 0px;
        .container {
            margin: 10px;
        }
    }
'); ?>
~~~
generates:
~~~
<style type="text/css">
/*<![CDATA[*/
    body {
        padding: 0px;
    }
    body .container {
        margin: 0px;
    }
/*]]>*/
</style>
~~~

##Resources

 * [LESS CSS](http://lesscss.org/)
 * [LESS for PHP](http://leafo.net/lessphp/)

