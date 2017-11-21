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
Yii::import('web.widgets.CWidget');
 
class LookupDialog extends CWidget
{

    public $title='Pesquisar';
	public $form;
	public $model;
    public $attribute;
    public $htmlOptions;
	public $displayFields = array(
		array(
			'header'=>'Selecione:',
            'name'=>'globalSearch',
			'value'=>'$data->toString()',
			// 'htmlOptions' => array('style' => 'text-align:center;'),
		),
	);
	public $display;
	public $value;
	public $provider;
	public $showLabel;
	
	public function init() {
  	}
 
    public function run()
    {
    	$dialogId = 'lookup-dialog-'.$this->attribute;
    	$attr = $this->attribute;
        $this->htmlOptions['disabled'] = 'true';
		$this->htmlOptions['class'] .= ' form-control';
		if (!isset($this->htmlOptions['placeholder'])) $this->htmlOptions['placeholder'] = 'Selecionar...';
		$this->htmlOptions['value'] = $this->display;
		
		echo 
		(($this->showLabel)? $this->form->labelEx($this->model,$this->attribute).
		'<div class="input-group span5">' : '').
			CHtml::textField($this->attribute, $this->display, $this->htmlOptions).
	      '<span class="input-group-btn">'.
	        '<input class="btn btn-default btn-icon-search" type="image" src="images/search.ico" id="'.$dialogId.'-btn" />'.
	        //isset($create)? 
	        //	CHtml::Link("", $create, array('target'=>'_blank', 'class'=>'btn btn-default icon-plus', 'title'=>'Adicionar', 'style'=>'margin-left: -1px;'))
			//	: "" .
	        // '<input class="btn btn-default btn-icon-plus" type="image" id="'.$dialogId.'-btn-add" />'.
	      '</span>'.//icon-search
	    (($this->showLabel)? '</div><!-- /input-group -->' : '').
	    $this->form->error($this->model,$this->attribute).
	    $this->form->hiddenField($this->model,$this->attribute,array('value'=>$this->value));
		
		echo ('
		<script type="text/javascript">
		function onSelectionChange_ld_'.$this->attribute.'()
		{
		        var keys = $("#lookup-dialog-'.$this->attribute.' div.keys > span");
		
		        $("#lookup-dialog-'.$this->attribute.' table tbody > tr").each(function(i)
		        {
		                if($(this).hasClass("selected"))
		                {
		        			$("#'.get_class($this->model).'_'.$this->attribute.'").val($(keys[i]).text());
		                    $("#'.$this->attribute.'").val($(this).children(":nth-child(1)").text());
		                }
		        });
				
				$("#'.$dialogId.'").dialog("close");
		}
		$("#'.$dialogId.'-btn").click(function(event) {
		    event.preventDefault();
		    $("#'.$dialogId.'").dialog("open");
			$("#'.$dialogId.' .filter-container input").focus();
		});
		</script>
		<style type="text/css">
			#lookup-dialog-'.$this->attribute.' table.items th, .table td {line-height: 10px;}
			#lookup-dialog-'.$this->attribute.' table.items tr:hover td {background: #eeeeee;}
			#lookup-dialog-'.$this->attribute.' table.items tr td {background-color: transparent;}
		</style>
		');
		
		$this->form->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'lookup-dialog-'.$this->attribute,
            'options'=>array(
                'title'=>$this->title,
                'width' => 'auto',
                'autoOpen'=>false,
        		'modal'=>true,
        		'close'=>'$\'#'.$dialogId.'\').dialog(\'close\');' ,
            ),
        ));
		
        // $this->form->widget('zii.widgets.grid.CGridView', array(
        $this->form->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'lookup-dialog-'.$this->attribute.'-tbl',
			'dataProvider'=>$this->provider->search(),
			'filter'=>$this->provider,
            'columns' => $this->displayFields,
            'htmlOptions' => array(
                'style'=>'cursor: pointer;',
            ),                   
            'selectionChanged'=>'js:function(id){ onSelectionChange_ld_'.$this->attribute.'(); }',
        ));

        $this->form->endWidget('zii.widgets.jui.CJuiDialog');
    }
}