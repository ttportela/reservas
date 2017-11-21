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

if ($model->isNewRecord) {
    $model->from_date = date("Y-m-d");
    $model->from = date("00:00");
    $model->to = date("00:00");
}

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'booking-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->uneditableRow($model,'users_id', Yii::app()->user->user, array('class'=>'span5','maxlength'=>20)); ?>

    <?php echo $form->selectorRow($model,'resources_id', 
			$model->resources_id, (Yii::app()->helper->set($model->resource)? $model->resource->toString():''),
			(Resource::model()), null); ?>
    
    <?php echo $form->dateRow($model, 'from_date', array('class' => 'control-label')); ?>

	<?php echo $form->radioButtonListInlineRow($model, 'repeat_periods', 
                array('M'=>'Manhã', 'T'=>'Tarde', 'N'=>'Noite')); ?>

    <?php echo $form->checkBoxListInlineRow($model, 'repeat_periods_class', 
                array('P'=>'Primeiras', 'U'=>'Últimas')); ?>

    <?php echo $form->timeRow($model, 'from', array('class' => 'control-label')); ?>

    <?php echo $form->timeRow($model, 'to', array('class' => 'control-label')); ?>

    <hr/>

    <h4>Repetir Reserva por (opcional):</h4>

	<?php echo $form->checkBoxListInlineRow($model, 'repeat_days', 
                array('1'=>'Segunda', '2'=>'Terça', '3'=>'Quarta', '4'=>'Quinta', '5'=>'Sexta', '6'=>'Sábado')); ?>

    <?php echo $form->dateRow($model, 'repeat_to', array('class' => 'control-label')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    
    $( "input[name='Booking[repeat_periods]']" ).on('change',function() {
      periodsChanged();
    });
    $( "input[name='Booking[repeat_periods_class][]']" ).on('change',function() {
      periodsChanged();
    });

    function periodsChanged() {
        var M = false, T = false, N = false, P = false, U = false;
        var periods = document.getElementsByName('Booking[repeat_periods]');
        var classes = document.getElementsByName('Booking[repeat_periods_class][]');
        for (var i = 0; i < periods.length; i++) {
            //if (periods[i].value == ck.value) periods[i] = ck;
            //alert(periods[i].checked);
            if (periods[i].checked) {
                if (periods[i].value == 'M') M = true;
                if (periods[i].value == 'T') T = true;
                if (periods[i].value == 'N') N = true;
            }
        }
        
        for (var i = 0; i < classes.length; i++) {
            //if (periods[i].value == ck.value) periods[i] = ck;
            //alert(periods[i].checked);
            if (classes[i].checked) {
                if (classes[i].value == 'P') P = true;
                if (classes[i].value == 'U') U = true;
            }
        }
        
        //alert(M+"-"+T+"-"+N);
        
        var start = '00:00', end = '00:00';
        
        if (N) {start = (U && !P? '21:25' : '19:30')};
        if (T) {start = (U && !P? '16:10' : '13:30')};
        if (M) {start = (U && !P? '10:10' : '07:30')};
        
        if (M) {end = (P && !U? '09:45' : '11:40')};
        if (T) {end = (P && !U? '15:45' : '17:40')};
        if (N) {end = (P && !U? '21:10' : '23:05')};
        
        var from = document.getElementById('Booking_from');
        var to = document.getElementById('Booking_to');
        
        from.value = from.value.substring(0, from.value.length - 5) + start;
        to.value = to.value.substring(0, to.value.length - 5) + end;
    }
    
</script>
