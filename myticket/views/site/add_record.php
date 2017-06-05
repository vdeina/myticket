<?php
    use yii\helpers\Html;
    use dosamigos\datepicker\DatePicker;
   	use yii\bootstrap\ActiveForm;
    $this->title = 'Добавить билет|MyTicket';
    $status=array('ISSUED'=>'ISSUED','REISSUED'=>'REISSUED','REFUNDED'=>'REFUNDED','VOIDED'=>'VOIDED');
    $dom_int=array('DOM'=>'DOM','INT'=>'INT');
    $dom_int_param = ['options' =>[ 'DOM' => ['Selected' => true]],'class'=>'input_value_edit'];
    $status_param = ['options' =>[ 'ISSUED' => ['Selected' => true]],'class'=>'input_value_edit'];
    $responce_param = ['options' =>[ "admin" => ['Selected' => true]],'class'=>'input_value_edit'];
    $carriers_param = ['class'=>'input_value_edit'];
    $cur=array('KGS'=>'KGS','USD'=>'USD','KZT'=>'KZT','EUR'=>'EUR');
    $cur_param = ['options' =>[ 'KGS' => ['Selected' => true]],'class'=>'input_value_edit'];
?>
<div class="ticket-details" id="ticket-details">
<?php $form = ActiveForm::begin(['id' => 'add-ticket-form','fieldConfig' => [
        'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",'enableClientValidation' => true,
                    'validateOnBlur' => true,
                    'validateOnType' => true,
                    'validateOnChange' => true,]]); ?>
<div style="width: 100%;height: 60px;padding: 10px 0px;">
<?= Html::submitButton('Сохранить',['class' => 'button edit_send_btn','id'=>'add-edit-button']) ?>
</div>
<table class="detailview-table">
<thead>
<tr>
  <th colspan="4" >Информация по билету</th>
</tr>
</thead>
<tbody>
<tr>
<td><label class="lable-field">Номер PNR</label></td>
<td>
<?=$form->field($edit_model, 'recloc')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
<?= Html::input('text','actions','add_new_record',['style'=>'display: none']);?>
</td>
<td><label class="lable-field">Статус</label></td>
<td>
<?= $form->field($edit_model, 'status')->dropDownList($status,$status_param)->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Номер документа</label></td>
<td>
<?=$form->field($edit_model, 'doc_num')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Дата Создания</label></td>
<td>
<?=$form->field($edit_model, 'doc_issued')->textInput(['class'=>'input_value_edit','onkeypress'=>'return false;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Сайн выписавшего</label></td>
<td>
<?=$form->field($edit_model, 'sine')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</td>
<td><label class="lable-field">Ответственный</label></td>
<td>
<?= $form->field($edit_model, 'respon')->dropDownList($agents,$responce_param)->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Имя</label></td>
<td>
<?=$form->field($edit_model, 'first_name')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Фамилия</label></td>
<td>
<?=$form->field($edit_model, 'last_name')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Тип Пассажира</label></td>
<td>
<?=$form->field($edit_model, 'title')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Номер паспорта</label></td>
<td>
<?=$form->field($edit_model, 'passport')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Телефон клиента</label></td>
<td>
<?=$form->field($edit_model, 'phone')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">E-mail клиента</label></td>
<td>
<?=$form->field($edit_model, 'email')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Маршрут</label></td>
<td>
<?=$form->field($edit_model, 'route')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Валидирующий п-к</label></td>
<td>
<?=$form->field($edit_model, 'val_car')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Маркетинговый п-к</label></td>
<td>
<?=$form->field($edit_model, 'mark_car')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Обслуживающий п-к</label></td>
<td>
<?=$form->field($edit_model, 'oper_car')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Дата Вылета</label></td>
<td>
<?=$form->field($edit_model, 'dep_date')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Классы бронирования</label></td>
<td>
<?=$form->field($edit_model, 'booking_class')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Вид тарифа</label></td>
<td>
<?=$form->field($edit_model, 'fare_basises')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Номера рейсов</label></td>
<td>
<?=$form->field($edit_model, 'flight_numbers')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Номер первонач. билета</label></td>
<td>
<?=$form->field($edit_model, 'fo_number')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Норма провоза багажа</label></td>
<td>
<?=$form->field($edit_model, 'baggage')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Страны по маршруту</label></td>
<td>
<?=$form->field($edit_model, 'rou_cnt')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">внут-й/междун-й</label></td>
<td>
<?= $form->field($edit_model, 'dom_int')->dropDownList($dom_int,$dom_int_param)->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Ремарка</label></td>
<td>
<?=$form->field($edit_model, 'rem')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
<td><label class="lable-field">Источник</label></td>
<td>
<?= $form->field($edit_model, 'type')->dropDownList($carriers,$carriers_param)->label(false);?>
</td>
</tr>
</tbody>
</table>
<table class="detailview-table" id="issued-table">
<thead>
<tr>
  <th colspan="4" >Финансовая информация по билету</th>
</tr>
</thead>
<tbody>
<tr>
<td><label class="lable-field">Тариф</label></td>
<td>
<?=$form->field($edit_model, 'fare')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Итого таксы</label></td>
<td>
<?=$form->field($edit_model, 'taxes_total')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Сервисный Сбор</label></td>
<td>
<?=$form->field($edit_model, 'sf')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Таксы</label></td>
<td>
<?=$form->field($edit_model, 'taxes')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Комиссия</label></td>
<td>
<?=$form->field($edit_model, 'commis')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Сумма комиссии</label></td>
<td>
<?=$form->field($edit_model, 'commis_amount')->textInput(['class'=>'input_value_edit','readonly'=>"",'onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Скидка</label></td>
<td>
<?=$form->field($edit_model, 'dis')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Сумма скидки</label></td>
<td>
<?=$form->field($edit_model, 'dis_amount')->textInput(['class'=>'input_value_edit','readonly'=>"",'onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Общий итог</label></td>
<td>
<?=$form->field($edit_model, 'total')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Итого перевозчику</label></td>
<td>
<?=$form->field($edit_model, 'total_car')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Валюта</label></td>
<td>
<?=$form->field($edit_model, 'cur')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'KGS'])->label(false);?>
</td>
<td><label class="lable-field" >Курс валюты</label></td>
<td>
<?=$form->field($edit_model, 'cur_rate')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
</tbody>
</table>
<table class="detailview-table" id="refund-table" style="display: none;">
<thead>
<tr>
  <th colspan="4" >Финансовая информация по билету</th>
</tr>
</thead>
<tbody>
<tr>
<td><label class="lable-field">Тариф к возврату</label></td>
<td>
<?=$form->field($edit_model, 'fare_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Таксы к возврату</label></td>
<td><span class="value"><?=$ticket['TAXES_TOTAL']?></span>
<?=$form->field($edit_model, 'taxes_total_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Штраф за возврат</label></td>
<td>
<?=$form->field($edit_model, 'cancel_fee')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Итого к возврату</label></td>
<td>
<?=$form->field($edit_model, 'total_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Итого перевозчику</label></td>
<td>
<?=$form->field($edit_model, 'total_car_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Валюта</label></td>
<td>
<?=$form->field($edit_model, 'cur_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'KGS'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Комиссия к возврату</label></td>
<td>
<?=$form->field($edit_model, 'commis_amount_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
<td><label class="lable-field">Курс валюты</label></td>
<td>
<?=$form->field($edit_model, 'cur_rate_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Сервисный Сбор</label>
</td>
<td>
<?=$form->field($edit_model, 'sf_ref')->textInput(['class'=>'input_value_edit','onkeypress'=>'return event.keyCode != 13;','value'=>'0'])->label(false);?>
</td>
</tr>
</tbody>
</table>
<?php ActiveForm::end(); ?> 
<div style="width: 100%;height: 60px;padding: 10px 0px;" id="div-clon-btn">
<button type="submit" id="send-edit-button2" class="button edit_send_btn">Сохранить</button></div>
</div> 
<?php 
$script.= <<< JS


  $( "#send-edit-button2" ).click(function() {
    $( "#add-edit-button" ).click();
  });
 jQuery('#ticketeditform-doc_issued').datetimepicker({
 format:'Y-m-d H:i'}
 );
 $('#ticketeditform-commis').on('input',function(e){
     commissioChanged();
    });
    $('#ticketeditform-dis').on('input',function(e){
    disChanged();  
    });  
   $('#ticketeditform-sf').on('input',function(e){
    var sf=parseFloat($(this).val());
    if(!sf) sf=0;
    var fare=parseFloat($('#ticketeditform-fare').val());
    if(!fare) fare=0;
    var taxes=parseFloat($('#ticketeditform-taxes_total').val()); 
    if(!taxes) taxes=0;
    var dis=parseFloat($('#ticketeditform-dis_amount').val()); 
    if(!dis) dis=0; 
    var total=(fare+taxes+sf-dis).toFixed(2);
    $('#ticketeditform-total').val(total);  
    });   
    $('#ticketeditform-fare').on('input',function(e){
        commissioChanged();
        disChanged();
    });   
     $('#ticketeditform-taxes_total').on('input',function(e){
        commissioChanged();
        disChanged();
    });   
   function commissioChanged()
    {
        var com=$("#ticketeditform-commis").val();
        if(!com) com='0';
        var fare=parseFloat($('#ticketeditform-fare').val());
        if(!fare) fare=0;
        var taxes=parseFloat($('#ticketeditform-taxes_total').val());
        if(!taxes) taxes=0;
        if ( com.indexOf('%') !== -1 ) {
            com=com.replace(/%/gi, "");
            com=(fare*com/100).toFixed(2);
            }
        $('#ticketeditform-commis_amount').val(com);    
        var tot_car=(fare+taxes-com).toFixed(2);
        if(isNaN(tot_car))tot_car='0.00'
        $('#ticketeditform-total_car').val(tot_car);  
    }
    function disChanged()
    {
    var dis=$("#ticketeditform-dis").val();
    if(!dis) dis='0';
    var fare=parseFloat($('#ticketeditform-fare').val());
    if(!fare) fare=0;
    var sf=parseFloat($('#ticketeditform-sf').val());
    if(!sf) sf=0;
    var taxes=parseFloat($('#ticketeditform-taxes_total').val());
     if(!taxes) taxes=0;
    if ( dis.indexOf('%') !== -1 ) {
        dis=dis.replace(/%/gi, "");
        dis=((fare+taxes+sf)*dis/100).toFixed(2);
    }
    $('#ticketeditform-dis_amount').val(dis);    
    var total=(fare+taxes+sf-dis).toFixed(2);
     if(isNaN(total))total='0.00'
    $('#ticketeditform-total').val(total);
        }
   $('#ticketeditform-status').on('change', function() {
    if(this.value=="REFUNDED")
    {
        showTableReF();
    }
    else{
     showTableIssued();}
   });
    function showTableIssued()
   {
     var element = $('#issued-table');
     if(!$('#issued-table').is(':visible') )
      {
        $('#refund-table').hide();
        var has_error = $('#refund-table').find('.has-error');
        if(has_error.length>0)
        {
        
          var has_error_input = has_error.find(':input');
          has_error_input.val('0');
          has_error.removeClass('has-error');
        }
        element.show();
      }
     
   }
   function showTableReF()
   {    
     var element = $('#refund-table');
     if(!$('#refund-table').is(':visible') )
      {
        $('#issued-table').hide();
        var has_error = $('#issued-table').find('.has-error');
        if(has_error.length>0)
        {
        
          var has_error_input = has_error.find(':input');
          has_error_input.val('0');
          has_error.removeClass('has-error');        
        }
        element.show();
      }    
   }
/* $('#ticketeditform-fare_ref').on('input',function(e){
        financeRefChanged();
    });
    $('#ticketeditform-taxes_total_ref').on('input',function(e){
        financeRefChanged();
    });
    $('#ticketeditform-cancel_fee').on('input',function(e){
        financeRefChanged();
    });
     $('#ticketeditform-commis_amount_ref').on('input',function(e){
        financeRefChanged();
    });*/
    function financeRefChanged()
    {
        var fare=parseFloat($('#ticketeditform-fare_ref').val());
        if(!fare) fare=0;
        var taxes=parseFloat($('#ticketeditform-taxes_total_ref').val());
        if(!taxes) taxes=0;
        var c_fee=parseFloat($('#ticketeditform-cancel_fee').val());
        if(!c_fee) c_fee=0;
        var com_ref=parseFloat($('#ticketeditform-commis_amount_ref').val());
        if(!com_ref) com_ref=0;
        $('#ticketeditform-total_ref').val((fare+taxes-c_fee)); 
        $('#ticketeditform-total_car_ref').val((fare+taxes-com_ref-c_fee)); 
        
    }
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY)
?>;
 