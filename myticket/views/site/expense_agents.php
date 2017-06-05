<?php
    // use yii\jui\AutoComplete;
    // use yii\web\JsExpression;     
	 use yii\helpers\Html;
     use dosamigos\datepicker\DatePicker;
     $this->title = 'Оплата кассиров|MyTicket';	
     $responce_param = ['prompt' => 'Все','class'=>'form-control','id'=>'agent_id_filter'];
     $pay_responce_param = ['class'=>'form-control','id'=>'input-name-id'];
     $payment_methods_param= ['class'=>'form-control','id'=>'pay_method_id'];
     $payment_methods_param_edit= ['class'=>'form-control','id'=>'edit_pay_method_id','style'=>'width: 95%;margin: 0 auto;'];
?>
<div class="agents-details" id="agents-details">
<div style="height: 40px;"></div>
<table class="table-agents-expense" id="table-agents-expense">
<body>
<thead>
<tr>
  <th>Кассир</th>
  <th>Сумма оплаты</th>
  <th>Сумма расхода</th>
  <th>Примечания</th>
  <th>Метод оплаты</th>
  <th>Дата</th>
</tr>
</thead>
<tr class="agent-items">
<td title="Имя кассира">
<?= Html::dropDownList('agenta-pay-name',[],$agents_filter,$pay_responce_param);
/*	echo AutoComplete::widget([ 
    'id'=>'input_name',   
    'class'=>'input-name',    
    'clientOptions' => [
    'source' => $agents,
    'minLength'=>'0',
    'autoFill'=>true,
        'select' => new JsExpression("function( event, ui ) {
        $('#input-name-id').val(ui.item.id);
     }" )],]);  */                             
?>
<?= Html::input('text','','',['style'=>'display: none','id'=>'input-name-id','maxlength'=>'10']);?>
</td> 
<td><?= Html::input('text','','',['class'=>'input-pay','id'=>'input-pay','maxlength'=>'10']);?></td>
<td><?= Html::input('text','','',['class'=>'input-expense','id'=>'input-expense','maxlength'=>'10']);?></td>
<td><?= Html::textarea('note','',['class'=>'text-note','id'=>'text-note','maxlength'=>'240','rows'=>'1']);?></td>
<td><?= Html::dropDownList('agenta-pay-method',[],$payment_methods,$payment_methods_param);?></td>
<td><div style="width: 90%;margin: 0 auto;"> <?= DatePicker::widget([
        'value'=>date('Y-m-d'),
        'name'=>'date',
        'input_class'=>'date-expense',
        'language' => 'ru',
        'input_id'=>'date_expense',
        'clientOptions' => [
            'autoclose' => true,
             'format' => 'yyyy-mm-dd',
        ]
]);?></td></div>
</tr>
<body>
</table>
<div style="height: 80px;width: 1024px;margin: 0px auto;text-align: center;">
<div style="height: 21px;"><span style="color: #018606;"id="status-agent-pay"></span><span style="color: #f3050e" id="error-agent-pay"></span></div>
<div style="position: relative;width: 200px;margin: 0 auto;">
<button  <?=(count($agents)==0)?"style='display: none;'":""?> type="button" id="expense_btn" class="button add_expense_btn">Сохранить</button>
<div id="loader-agent-pay" class="cssload-speeding-wheel loader-agent-pay" style="display: none;"></div>
</div>
</div>
<div class="filter-div" style="margin-top: 20px;">
<div class="div-filter" style="height: 36px;width: 75%;">
<div style="width: 25%;"> <?= DatePicker::widget([
        'value'=>date('Y-m-01'),
        'name'=>'date',
        'language' => 'ru',
        'input_id'=>'date_start_pay',
        'clientOptions' => [
            'autoclose' => true,
             'format' => 'yyyy-mm-dd',
        ]
]);?></div>
<div style="width: 25%;"><?= DatePicker::widget([
        'value'=>date('Y-m-d'),
        'name'=>'date',
        'language' => 'ru',
        'input_id'=>'date_end_pay',
        'clientOptions' => [
            'autoclose' => true,
             'format' => 'yyyy-mm-dd',
        ]
]);?>
</div><div style="width: 25%;">
<?= Html::dropDownList('filter-agents',[],$agents_filter,$responce_param) ?>
</div>
<div style="position: relative;width: 15%;">
<button type="button" id="filter_expense_btn" class="button filter_send_btn">Найти</button>
<div id="loader_agent_pay_filter" class="cssload-speeding-wheel loader-agent-pay" style="display: none;"></div>
</div>
</div>
</div>
<table class="table-agents-payments" id="table-agents-payments">
<?=$this->render('table_expense_agents',['payments'=>$payments])?> 
</table>
<div style="display: none;"><?= Html::input('text','',count($payments),['id'=>'count_record_payagent']);?></div>
<div id="navigator"></div>
</div>
<div class="sweet-overlay" id="sweet-overlay" tabindex="-1" style="opacity: 0; display: none;"></div>
<div class="sweet-alert edit_pay_agent hideSweetAlert" id="sweet-edit-agent-pay" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span id="add-agent-title" style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 24px;">Редактирование данных по оплате</span>
<div style="width: 100%;margin-top: 30px;color: #20303c;font-family: ProximaNova Reg;font-size: 20px;">
<table class="table_edit_agent_pay" id="table_edit_agent_pay" style="width: 100%;height: 100%;margin-bottom: 20px;">    
<body>
<thead>
<tr>
  <th>Кассир</th>
  <th>Сумма оплаты</th>
  <th>Сумма расхода</th>
  <th>Примечания</th>
  <th>Метод оплаты</th>
  <th>Дата</th>
</tr>
</thead>
<tr>
<td><span id="edit_agent_name"></span></td>
<td><?= Html::input('text','','',['class'=>'input-pay','id'=>'input_pay_edit','maxlength'=>'10']);?></td>
<td><?= Html::input('text','','',['class'=>'input-expense','id'=>'input_expense_edit','maxlength'=>'10']);?></td>
<td><?= Html::textarea('note','',['class'=>'text-note','id'=>'edit_text-note','maxlength'=>'240','rows'=>'1']);?></td>
<td><?= Html::dropDownList('agenta-pay-method',[],$payment_methods,$payment_methods_param_edit);?></td>
<td><div style="width: 95%;margin: 0 auto;"> <?= DatePicker::widget([
        'value'=>date('Y-m-d'),
        'name'=>'date',
        'input_class'=>'date-expense',
        'language' => 'ru',
        'input_id'=>'date_expense_edit',
        'clientOptions' => [
            'autoclose' => true,
             'format' => 'yyyy-mm-dd',
        ]
]);?>

<span id="edit_time_pay" style="display: none;"></span>
</td></div>
</tr>
</body>
</table>
</div>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="agent_editpay_error"></span></div>
<div style="width: 100%;height: 60px;padding: 10px 0px;">
<div style="display: none;"><?= Html::input('text','','',['id'=>'agent_editpay_action','maxlength'=>'30']);?></div>
<div style="display: none;"><?= Html::input('text','','',['id'=>'edit_pay_id']);?></div>
<button type="button" id="edit-pay-agent-button" class="button edit-add-agent-button">Сохранить</button>
<button type="button" id="cencel-editpay-agent-button" class="button cencel-add-agent-button">Отмена</button></div>
</div>


<div class="sweet-alert remove_agent hideSweetAlert" id="sweet_remove_agent_pay" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span id="add-agent-title" style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 20px;">Вы действительно хотите удалить запись?</span>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="pay_agent_remove_error"></span></div>
<div style="width: 100%;height: 65px;padding: 20px 0px;">
<div style="display: none;"><?= Html::input('text','','remove_agent_pay',['id'=>'agent_pay_remove_action','maxlength'=>'30']);?></div>
<div style="display: none;"><?= Html::input('text','','',['id'=>'remove_agent_pay_id']);?></div>
<button type="button" id="pay-remove-agent-button" class="button edit-remove-agent-button">Удалить</button>
<button type="button" id="pay-cancel-agent-button" class="button cencel-remove-agent-button">Отмена</button></div>
</div>
<?php
$script = <<< JS
 jQuery(document).ready(function($) {
paginatorPayAgent();
});
JS;
$this->registerJs($script, yii\web\View::POS_READY)
?>;