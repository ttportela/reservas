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
class Multiselect extends CWidget
{
	
	public $form;
	public $model;
	public $attribute;
	public $data;
	public $htmlOptions = array();
	
    public function init()
    {
    	$path = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.multiselect', -1, false));
        $file= $path . '/assets/css/multi-select.css';
		Yii::app()->clientScript->registerCssFile($file);
        
        $file=$path.'/assets/js/jquery.multi-select.js';
        Yii::app()->clientScript->registerScriptFile($file);
        
        parent::init();
    }
	
	 /**
     * Run this widget.
     * renders the needed HTML code.
     */
    public function run() {
    	
		// array_merge($this->htmlOptions, array(
						// 'multiple'=>true, 
						// 'id'=>'multiselect-'.$this->attribute
					// ));
					
		$this->htmlOptions['multiple'] = true;
		$this->htmlOptions['mulidtiple'] = 'multiselect-'.$this->attribute;
		
        echo '<div>
				<legend>' . $this->form->labelEx($this->model,$this->attribute) . '</legend>'.
				$this->form->dropDownList($this->model, $this->attribute, $this->data,
					$this->htmlOptions
				) .
				$this->form->error($this->model,$this->attribute). '
			    <script language="javascript">$("#multiselect-'.$this->attribute.'").multiSelect();</script>
			  </div>';
    }
}