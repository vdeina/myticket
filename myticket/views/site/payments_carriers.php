<?php
  use yii\helpers\Html;
  use dosamigos\datepicker\DatePicker;
  $this->title = 'Оплата авиакомпаниям|MyTicket';	
  $pay_car_param = ['class'=>'form-control','id'=>'input-carriername-id'];
  $car_param = ['prompt' => 'Все','class'=>'form-control','id'=>'filter-carriers-id'];
  $pay_car_param = ['class'=>'form-control','id'=>'input-carriername-id'];
  $payment_methods_param= ['class'=>'form-control','id'=>'pay_method_id'];
  $payment_methods_param_edit= ['class'=>'form-control','id'=>'edit_pay_method_id','style'=>'width: 95%;margin: 0 auto;'];
?>
<div class="carriers-details" id="carriers-details">
<div style="height: 40px;"></div>
<table class="table-carriers-payments" id="table-carriers-payments">
<body>
<thead>
<tr>
  <th>Авиакомпания</th>
  <th>Сумма оплаты</th>
  <th>Примечания</th>
  <th>Метод оплаты</th>
  <th>Дата</th>
</tr>
</thead>
<tr class="agent-items" id="<?=$carrier['id']?>">
<td><?= Html::dropDownList('carrier-pay-name',[],$carriers,$pay_car_param);?></td> 
<td><?= Html::input('text','','',['class'=>'input-pay','id'=>'input-pay','maxlength'=>'10']);?></td>
<td><?= Html::textarea('note','',['class'=>'text-note','id'=>'text-note','maxlength'=>'240','rows'=>'1']);?></td>
<td><?= Html::dropDownList('agenta-pay-method',[],$payment_methods,$payment_methods_param);?></td>
<td><div style="width: 61%;margin: 0 auto;"> <?= DatePicker::widget([
        'value'=>date('Y-m-d'),
        'name'=>'date',
        'input_class'=>'date-expense',
        'language' => 'ru',
        'input_id'=>'date_pay',
        'clientOptions' => [
            'autoclose' => true,
             'format' => 'yyyy-mm-dd',
        ]
]);?></td></div>
</tr>
</body>
</table>
<div style="height: 80px;width: 1024px;margin: 0px auto;text-align: center;">
<div style="height: 21px;"><span style="color: #018606;"id="status-carrier-pay"></span><span style="color: #f3050e" id="error-carrier-pay"></span></div>
<div style="position: relative;width: 200px;margin: 0 auto;">
<button  type="button" id="payments_btn" class="button add_payments_btn">Сохранить</button>
<div id="loader-carriers-pay" class="cssload-speeding-wheel loader-carriers-pay" style="display: none;"></div>
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
<?= Html::dropDownList('filter-carriers',[],$carriers,$car_param) ?>
</div>
<div style="position: relative;width: 15%;">
<button type="button" id="filter_car_btn" class="button filter_send_btn">Найти</button>
<div id="loader_car_pay_filter" class="cssload-speeding-wheel loader-agent-pay" style="display: none;"></div>
</div>
</div>
</div>
<table class="table-carriers-payments" id="table_history_car_payments" style="width: 85%;">
<?=$this->render('table_payments_carriers',['payments'=>$payments])?> 
</table>
<div style="display: none;"><?= Html::input('text','',count($payments),['id'=>'count_record_payagent']);?></div>
<div id="navigator"></div>
</div>
<div class="sweet-overlay" id="sweet-overlay" tabindex="-1" style="opacity: 0; display: none;"></div>

<div class="sweet-alert edit_pay_agent hideSweetAlert" id="sweet-edit-car-pay" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span id="add-agent-title" style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 24px;">Редактирование данных по оплате</span>
<div style="width: 100%;margin-top: 30px;color: #20303c;font-family: ProximaNova Reg;font-size: 20px;">
<table class="table_edit_agent_pay" id="table_edit_car_pay" style="width: 100%;height: 100%;margin-bottom: 20px;">    
<body>
<thead>
<tr>
  <th>Авиакомпания</th>
  <th>Сумма оплаты</th>
  <th>Примечания</th>
  <th>Метод оплаты</th>
  <th>Дата</th>
</tr>
</thead>
<tr>
<td><span id="edit_car_name"></span></td>
<td><?= Html::input('text','','',['class'=>'input-pay','id'=>'input_pay_edit','maxlength'=>'10']);?></td>
<td><?= Html::textarea('note','',['class'=>'text-note','id'=>'edit_text-note','maxlength'=>'240','rows'=>'1']);?></td>
<td><?= Html::dropDownList('agenta-pay-method',[],$payment_methods,$payment_methods_param_edit);?></td>
<td><div style="margin: 0 auto;width: 71%;"> <?= DatePicker::widget([
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
<span id="edit_time_pay" style="display: none;"></span></td></div>
</tr>
</body>
</table>
</div>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="car_editpay_error"></span></div>
<div style="width: 100%;height: 60px;padding: 10px 0px;">
<div style="display: none;"><?= Html::input('text','','',['id'=>'agent_editpay_action','maxlength'=>'30']);?></div>
<div style="display: none;"><?= Html::input('text','','',['id'=>'edit_pay_id']);?></div>
<button type="button" id="edit-pay-car-button" class="button edit-add-agent-button">Сохранить</button>
<button type="button" id="cencel-editpay-car-button" class="button cencel-add-agent-button">Отмена</button></div>
</div>

<div class="sweet-alert remove_agent hideSweetAlert" id="sweet_remove_car_pay" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span id="add-agent-title" style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 20px;">Вы действительно хотите удалить запись?</span>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="pay_car_remove_error"></span></div>
<div style="width: 100%;height: 65px;padding: 20px 0px;">
<div style="display: none;"><?= Html::input('text','','remove_agent_pay',['id'=>'agent_pay_remove_action','maxlength'=>'30']);?></div>
<div style="display: none;"><?= Html::input('text','','',['id'=>'remove_car_pay_id']);?></div>
<button type="button" id="pay-remove-car-button" class="button edit-remove-agent-button">Удалить</button>
<button type="button" id="pay-cancel-car-button" class="button cencel-remove-agent-button">Отмена</button></div>
</div>

<?php
$script = <<< JS
 jQuery(document).ready(function($) {
paginatorPayCar();
});
JS;
$this->registerJs($script, yii\web\View::POS_READY)
?>; 