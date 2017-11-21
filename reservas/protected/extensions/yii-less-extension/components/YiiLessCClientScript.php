<?php
/**
 * YiiLessCClientScript class file.
 *
 * @author Devadatta Sahoo <devadatta.sahoo@nettantra.com>
 * @link http://www.nettantra.com/
 * @copyright Copyright &copy; 2012-2013 NetTantra Technologies (India) Private Limited
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * YiiLessCClientScript manages CSS stylesheets for views with support for LESS.
 */

require_once(dirname(dirname(__FILE__))."/lib/lessphp/lessc.inc.php");

class YiiLessCClientScript extends CClientScript {
  public $cache = true;
  
  public function registerLessFile($url, $media='') {
    $this->hasScripts=true;
    $lessUrl = $url;
    
    $uniqid = md5($lessUrl);
    
    $lessFileName = basename($lessUrl);
    $cssFileName = preg_replace('/\.less$/i', '', $lessFileName).".css";
    $tempCachePath = Yii::getPathOfAlias('application.runtime.cache') . "/yiiless/{$uniqid}";
    @mkdir($tempCachePath, 0777, true);
    $cssFilePath = "{$tempCachePath}/{$cssFileName}";
    
    if(preg_match('/^https?\:\/\//', $lessUrl)) {
      $lessFilePath = "{$tempCachePath}/{$lessFileName}";
    } else if(file_exists( Yii::getPathOfAlias('webroot')."/{$lessUrl}" )) {
      $lessFilePath = Yii::getPathOfAlias('webroot')."/{$lessUrl}";
    } else if(file_exists($lessUrl)) {
      $lessFilePath = $lessUrl;
    } else {
      $lessFilePath = $_SERVER['DOCUMENT_ROOT'] ."/". $lessUrl;
    }
    
    $lessCompiler = new lessc();
    
    if ($this->cache === false) {
      $lessCompiler->compileFile($lessFilePath, $cssFilePath);
    } else {
      $lessCompiler->checkedCompile($lessFilePath, $cssFilePath);
    }
    
    $cssUrl = Yii::app()->getAssetManager()->publish($cssFilePath);
    
    $this->cssFiles[$cssUrl]=$media;
    $params=func_get_args();
    
    $this->recordCachingAction('clientScript', 'registerLessFile', $params);
    return $this;
  }
  public function registerLess($id, $less, $media='') {
    $lessCompiler = new lessc();
    $css = $lessCompiler->compile($less, $id);
    return parent::registerCss($id, $css, $media);
  }
}

