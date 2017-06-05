<?php
    use yii\helpers\Html;
   	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;
    $status=array('ISSUED'=>'ISSUED','REISSUED'=>'REISSUED','REFUNDED'=>'REFUNDED','VOIDED'=>'VOIDED');
    $dom_int=array('DOM'=>'DOM','INT'=>'INT');
    $dom_int_param = ['options' =>[ $ticket['DOM_INT'] => ['Selected' => true]],'class'=>'input_value_edit hide'];
    $status_param = ['options' =>[ $ticket['STATUS'] => ['Selected' => true]],'class'=>'input_value_edit hide'];
    $responce_param = ['options' =>[ $ticket['RESPONSIBLE'] => ['Selected' => true]],'class'=>'input_value_edit hide'];
    $carriers_param = ['options' =>[ $ticket['ID_CARRIER'] => ['Selected' => true]],'class'=>'input_value_edit hide'];
    $cur=array('KGS'=>'KGS','USD'=>'USD','KZT'=>'KZT','EUR'=>'EUR');
    $cur_param = ['options' =>[ $ticket['CURRENCY'] => ['Selected' => true]],'class'=>'input_value_edit hide'];
?>
<div class="ticket-details" id="ticket-details">
<?php $form = ActiveForm::begin(['id' => 'edit-ticket-form','fieldConfig' => [
        'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",]]); ?>
<div style="width: 100%;height: 60px;padding: 10px 0px;">
<?= Html::button('Удалить',['class' => 'button edit_cencel_btn','id'=>'delete-on-button','onclick'=>'removeTicket();']) ?>
<?= Html::button('Изменить',['class' => 'button edit_on_btn','id'=>'edit-on-button']) ?>
<?= Html::button('Отмена',['class' => 'button edit_cencel_btn hide','id'=>'cencel-edit-button']) ?>
<?= Html::submitButton('Сохранить',['class' => 'button edit_send_btn hide','id'=>'send-edit-button']) ?>
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
<span class="value rec_loc"><?=$ticket['RECORD_LOCATOR']?></span>
<?=$form->field($edit_model, 'recloc')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['RECORD_LOCATOR']])->label(false);?>
<?=$form->field($edit_model, 'record')->textInput(['style'=>'display: none;','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['ID']])->label(false);?>
<?= Html::input('text','actions','update_all_data_airfile',['style'=>'display: none']);?>
</td>
<td><label class="lable-field">Статус</label></td>
<td><span class="value status"><?=$ticket['STATUS']?></span>
<?= $form->field($edit_model, 'status')->dropDownList($status,$status_param)->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Номер документа</label></td>
<td>
<span class="value"><?=$ticket['DOCUMENT_NUMBER']?></span>
<?=$form->field($edit_model, 'doc_num')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['DOCUMENT_NUMBER']])->label(false);?>
</td>
<td><label class="lable-field">Дата Создания</label></td>
<td><span class="value"><?=$ticket['DOCUMENT_ISSUED']?></span>
<?=$form->field($edit_model, 'doc_issued')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return false;','value'=>$ticket['DOCUMENT_ISSUED']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Сайн выписавшего</label></td>
<td>
<span class="value"><?=$ticket['TICKETING_SINE']?></span>
<?=$form->field($edit_model, 'sine')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TICKETING_SINE']])->label(false);?>
</td>
</td>
<td><label class="lable-field">Ответственный</label></td>
<td><span class="value"><?=($ticket['name']=="")?"Admin":$ticket['name']?></span>
<?= $form->field($edit_model, 'respon')->dropDownList($agents,$responce_param)->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Имя</label></td>
<td>
<span class="value"><?=$ticket['FIRST_NAME']?></span>
<?=$form->field($edit_model, 'first_name')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['FIRST_NAME']])->label(false);?>
</td>
<td><label class="lable-field">Фамилия</label></td>
<td>
<span class="value"><?=$ticket['LAST_NAME']?></span>
<?=$form->field($edit_model, 'last_name')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['LAST_NAME']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Тип Пассажира</label></td>
<td>
<span class="value"><?=$ticket['TITLE']?></span>
<?=$form->field($edit_model, 'title')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TITLE']])->label(false);?>
</td>
<td><label class="lable-field">Номер паспорта</label></td>
<td>
<span class="value"><?=$ticket['PASSPORT']?></span>
<?=$form->field($edit_model, 'passport')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['PASSPORT']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Телефон клиента</label></td>
<td>
<span class="value"><?=$ticket['PHONE']?></span>
<?=$form->field($edit_model, 'phone')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['PHONE']])->label(false);?>
</td>
<td><label class="lable-field">E-mail клиента</label></td>
<td>
<span class="value"><?=$ticket['EMAIL']?></span>
<?=$form->field($edit_model, 'email')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['EMAIL']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Маршрут</label></td>
<td><span class="value"><?=$ticket['ROUTE']?></span>
<?=$form->field($edit_model, 'route')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['ROUTE']])->label(false);?>
</td>
<td><label class="lable-field">Валидирующий п-к</label></td>
<td><span class="value"><?=$ticket['VALIDATING_CARRIER']?></span>
<?=$form->field($edit_model, 'val_car')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['VALIDATING_CARRIER']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Маркетинговый п-к</label></td>
<td><span class="value"><?=$ticket['MARKETING_CARRIER']?></span>
<?=$form->field($edit_model, 'mark_car')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['MARKETING_CARRIER']])->label(false);?>
</td>
<td><label class="lable-field">Обслуживающий п-к</label></td>
<td><span class="value"><?=$ticket['OPERATING_CARRIER']?></span>
<?=$form->field($edit_model, 'oper_car')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['OPERATING_CARRIER']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Дата Вылета</label></td>
<td><span class="value"><?=$ticket['DEPARTURE_DATE']?></span>
<?=$form->field($edit_model, 'dep_date')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['DEPARTURE_DATE']])->label(false);?>
</td>
<td><label class="lable-field">Классы бронирования</label></td>
<td><span class="value"><?=$ticket['BOOKING_CLASSES']?></span>
<?=$form->field($edit_model, 'booking_class')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['BOOKING_CLASSES']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Вид тарифа</label></td>
<td><span class="value"><?=$ticket['FARE_BASISES']?></span>
<?=$form->field($edit_model, 'fare_basises')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['FARE_BASISES']])->label(false);?>
</td>
<td><label class="lable-field">Номера рейсов</label></td>
<td><span class="value"><?=$ticket['FLIGHT_NUMBERS']?></span>
<?=$form->field($edit_model, 'flight_numbers')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['FLIGHT_NUMBERS']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Номер первонач. билета</label></td>
<td><span class="value"><?=(strlen(trim($ticket['FO_NUMBER']))>0) ?"<a class='txtlink' target='_blank' href='".Url::to(["ticket-details","record"=>$fonumber_id])."'>".$ticket['FO_NUMBER']."</a>":"" ?></span>
<?=$form->field($edit_model, 'fo_number')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['FO_NUMBER']])->label(false);?>
</td>
<td><label class="lable-field">Норма провоза багажа</label></td>
<td><span class="value"><?=$ticket['BAGGAGE']?></span>
<?=$form->field($edit_model, 'baggage')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['BAGGAGE']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Страны по маршруту</label></td>
<td><span class="value"><?=$ticket['ROU_CNT']?></span>
<?=$form->field($edit_model, 'rou_cnt')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['ROU_CNT']])->label(false);?>
</td>
<td><label class="lable-field">внут-й/междун-й</label></td>
<td><span class="value"><?=$ticket['DOM_INT']?></span>
<?= $form->field($edit_model, 'dom_int')->dropDownList($dom_int,$dom_int_param)->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Ремарка</label></td>
<td><span class="value"><?=$ticket['REMARK1']?></span>
<?=$form->field($edit_model, 'rem')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['REMARK1']])->label(false);?>
</td>
<td><label class="lable-field">Источник</label></td>
<td><span class="value"><?=$ticket['TYPE']?></span>
<?= $form->field($edit_model, 'type')->dropDownList($carriers,$carriers_param)->label(false);?>
</td>
</tr>
</tbody>
</table>
<table class="detailview-table" id="issued-table" <?=($ticket['STATUS']=='REFUNDED')? 'style="display: none;"':''?>>
<thead>
<tr>
  <th colspan="4" >Финансовая информация по билету</th>
</tr>
</thead>
<tbody>
<tr>
<td><label class="lable-field">Тариф</label></td>
<td><span class="value"><?=$ticket['FARE']?></span>
<?=$form->field($edit_model, 'fare')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['FARE']])->label(false);?>
</td>
<td><label class="lable-field">Итого таксы</label></td>
<td><span class="value"><?=$ticket['TAXES_TOTAL']?></span>
<?=$form->field($edit_model, 'taxes_total')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TAXES_TOTAL']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Сервисный Сбор</label></td>
<td><span class="value"><?=$ticket['SERVICE_FEE']?></span>
<?=$form->field($edit_model, 'sf')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['SERVICE_FEE']])->label(false);?>
</td>
<td><label class="lable-field">Таксы</label></td>
<td><span class="value"><?=$ticket['TAXES']?></span>
<?=$form->field($edit_model, 'taxes')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TAXES']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Комиссия</label></td>
<td><span class="value"><?=$ticket['COMMISSION']?></span>
<?=$form->field($edit_model, 'commis')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['COMMISSION']])->label(false);?>
</td>
<td><label class="lable-field">Сумма комиссии</label></td>
<td><span class="value"><?=$ticket['COMMISSION_AMOUNT']?></span>
<?=$form->field($edit_model, 'commis_amount')->textInput(['class'=>'input_value_edit hide','readonly'=>"",'onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['COMMISSION_AMOUNT']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Скидка</label></td>
<td><span class="value"><?=$ticket['DISCOUNT']?></span>
<?=$form->field($edit_model, 'dis')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['DISCOUNT']])->label(false);?>
</td>
<td><label class="lable-field">Сумма скидки</label></td>
<td><span class="value"><?=$ticket['DISCOUNT_AMOUNT']?></span>
<?=$form->field($edit_model, 'dis_amount')->textInput(['class'=>'input_value_edit hide','readonly'=>"",'onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['DISCOUNT_AMOUNT']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Общий итог</label></td>
<td><span class="value"><?=$ticket['TOTAL']?></span>
<?=$form->field($edit_model, 'total')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TOTAL']])->label(false);?>
</td>
<td><label class="lable-field">Итого перевозчику</label></td>
<td><span class="value"><?=$ticket['TOTAL_CAR']?></span>
<?=$form->field($edit_model, 'total_car')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TOTAL_CAR']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Валюта</label></td>
<td><span class="value"><?=$ticket['CURRENCY']?></span>
<?= $form->field($edit_model, 'cur')->dropDownList($cur,$cur_param)->label(false);?>
</td>
<td><label class="lable-field" >Курс валюты</label></td>
<td><span class="value"><?=$ticket['CURRENCY_RATE']?></span>
<?=$form->field($edit_model, 'cur_rate')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['CURRENCY_RATE']])->label(false);?>
</td>
</tr>
</tbody>
</table>
<table class="detailview-table" id="refund-table" <?=($ticket['STATUS']!='REFUNDED')? 'style="display: none;"':''?>>
<thead>
<tr>
  <th colspan="4" >Финансовая информация по билету</th>
</tr>
</thead>
<tbody>
<tr>
<td><label class="lable-field">Тариф к возврату</label></td>
<td><span class="value"><?=$ticket['FARE']?></span>
<?=$form->field($edit_model, 'fare_ref')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['FARE']])->label(false);?>
</td>
<td><label class="lable-field">Таксы к возврату</label></td>
<td><span class="value"><?=$ticket['TAXES_TOTAL']?></span>
<?=$form->field($edit_model, 'taxes_total_ref')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TAXES_TOTAL']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Штраф за возврат</label></td>
<td><span class="value"><?=$ticket['CANCELLATION_FEE']?></span>
<?=$form->field($edit_model, 'cancel_fee')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['CANCELLATION_FEE']])->label(false);?>
</td>
<td><label class="lable-field">Итого к возврату</label></td>
<td><span class="value"><?=$ticket['TOTAL']?></span>
<?=$form->field($edit_model, 'total_ref')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TOTAL']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Итого перевозчику</label></td>
<td><span class="value"><?=$ticket['TOTAL_CAR']?></span>
<?=$form->field($edit_model, 'total_car_ref')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['TOTAL_CAR']])->label(false);?>
</td>
<td><label class="lable-field">Валюта</label></td>
<td><span class="value"><?=$ticket['CURRENCY']?></span>
<?= $form->field($edit_model, 'cur_ref')->dropDownList($cur,$cur_param)->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Комиссия к возврату</label></td>
<td><span id="commis_amount_ref" class="value"><?=$ticket['COMMISSION_AMOUNT']?></span>
<?=$form->field($edit_model, 'commis_amount_ref')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['COMMISSION_AMOUNT']])->label(false);?>
</td>
<td><label class="lable-field">Курс валюты</label></td>
<td><span class="value"><?=$ticket['CURRENCY_RATE']?></span>
<?=$form->field($edit_model, 'cur_rate_ref')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['CURRENCY_RATE']])->label(false);?>
</td>
</tr>
<tr>
<td><label class="lable-field">Сервисный Сбор</label></td>
<td><span id="sf_ref" class="value"><?=$ticket['SERVICE_FEE']?></span>
<?=$form->field($edit_model, 'sf_ref')->textInput(['class'=>'input_value_edit hide','onkeypress'=>'return event.keyCode != 13;','value'=>$ticket['SERVICE_FEE']])->label(false);?>
</td>
</tr>
</tbody>
</table>
<?php ActiveForm::end(); ?> 
<div style="width: 100%;height: 60px;padding: 10px 0px;" id="div-clon-btn" class="hide">
<button type="button" id="cencel-edit-button2" class="button edit_cencel_btn">Отмена</button><button type="submit" id="send-edit-button2" class="button edit_send_btn">Сохранить</button></div>
</div> 
<div class="sweet-overlay" id="sweet-overlay" tabindex="-1" style="opacity: 0; display: none;"></div>
<div class="sweet-alert remove_agent hideSweetAlert" id="sweet_remove_ticket" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span id="add-agent-title" style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 20px;">Вы действительно хотите удалить билет ?</span>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="pay_car_remove_error"></span></div>
<div style="width: 100%;height: 65px;padding: 20px 0px;">
<button type="button" id="ticket-remove-button" class="button edit-remove-agent-button">Удалить</button>
<button type="button" id="ticket-cancel-button" class="button cencel-remove-agent-button">Отмена</button></div>
</div>

    <?php
 $script='function setDefVal(){
    $("#ticketeditform-recloc").val("'.$ticket['RECORD_LOCATOR'].'");
    $("#ticketeditform-status").val("'.$ticket['STATUS'].'");
    $("#ticketeditform-doc_num").val("'.$ticket['DOCUMENT_NUMBER'].'");
    $("#ticketeditform-doc_issued").val("'.$ticket['DOCUMENT_ISSUED'].'");    
    $("#ticketeditform-sine").val("'.$ticket['TICKETING_SINE'].'");
    $("#ticketeditform-respon").val("'.$ticket['RESPONSIBLE'].'");    
    $("#ticketeditform-first_name").val("'.$ticket['FIRST_NAME'].'");
    $("#ticketeditform-last_name").val("'.$ticket['LAST_NAME'].'");
    $("#ticketeditform-title").val("'.$ticket['TITLE'].'");
    $("#ticketeditform-passport").val("'.$ticket['PASSPORT'].'");    
    $("#ticketeditform-phone").val("'.$ticket['PHONE'].'");
    $("#ticketeditform-email").val("'.$ticket['EMAIL'].'");    
    $("#ticketeditform-route").val("'.$ticket['ROUTE'].'");
    $("#ticketeditform-val_car").val("'.$ticket['VALIDATING_CARRIER'].'");    
    $("#ticketeditform-mark_car").val("'.$ticket['MARKETING_CARRIER'].'");
    $("#ticketeditform-oper_car").val("'.$ticket['OPERATING_CARRIER'].'");    
    $("#ticketeditform-dep_date").val("'.$ticket['DEPARTURE_DATE'].'");
    $("#ticketeditform-booking_class").val("'.$ticket['BOOKING_CLASSES'].'");    
    $("#ticketeditform-fare_basises").val("'.$ticket['FARE_BASISES'].'");
    $("#ticketeditform-flight_numbers").val("'.$ticket['FLIGHT_NUMBERS'].'");    
    $("#ticketeditform-fo_number").val("'.$ticket['FO_NUMBER'].'");
    $("#ticketeditform-baggage").val("'.$ticket['BAGGAGE'].'");    
    $("#ticketeditform-fo_number").val("'.$ticket['FO_NUMBER'].'");
    $("#ticketeditform-baggage").val("'.$ticket['BAGGAGE'].'");    
    $("#ticketeditform-rou_cnt").val("'.$ticket['ROU_CNT'].'");
    $("#ticketeditform-dom_int").val("'.$ticket['DOM_INT'].'");    
    $("#ticketeditform-rem").val("'.$ticket['REMARK1'].'");
    $("#ticketeditform-type").val("'.$ticket['ID_CARRIER'].'");
    
    }
 '; 
 $script.='function setDefFinanceVal(){
    if("'.$ticket['STATUS'].'"=="ISSUED" || "'.$ticket['STATUS'].'"=="REISSUED" )
    { 
      showTableIssued();
      setIssuedVal();
    }
    else if("'.$ticket['STATUS'].'"=="REFUNDED")
    {
       showTableReF();
       setRefundedVal(); 
    }
    else
    { 
     showTableIssued();
     setVoidVal();
    }
    }
    function setIssuedVal()
     {
        if("'.$ticket['STATUS'].'"=="ISSUED" || "'.$ticket['STATUS'].'"=="REISSUED" )
            {
           
            $("#ticketeditform-fare").val("'.$ticket['FARE'].'");
            $("#ticketeditform-taxes_total").val("'.$ticket['TAXES_TOTAL'].'");
            $("#ticketeditform-sf").val("'.$ticket['SERVICE_FEE'].'");
            $("#ticketeditform-taxes").val("'.$ticket['TAXES'].'");      
            $("#ticketeditform-commis").val("'.$ticket['COMMISSION'].'");
            $("#ticketeditform-commis_amount").val("'.$ticket['COMMISSION_AMOUNT'].'");       
            $("#ticketeditform-dis").val("'.$ticket['DISCOUNT'].'");
            $("#ticketeditform-dis_amount").val("'.$ticket['DISCOUNT_AMOUNT'].'");
            $("#ticketeditform-total").val("'.$ticket['TOTAL'].'");
            $("#ticketeditform-total_car").val("'.$ticket['TOTAL_CAR'].'");   
            $("#ticketeditform-cur").val("'.$ticket['CURRENCY'].'");
            $("#ticketeditform-cur_rate").val("'.$ticket['CURRENCY_RATE'].'");
            }
            else
            {
              setVoidVal();  
            }
        }
    function setRefundedVal()
     {
       
      if("'.$ticket['STATUS'].'"=="REFUNDED")
        {
        $("#ticketeditform-fare_ref").val("'.$ticket['FARE'].'");
        $("#ticketeditform-taxes_total_ref").val("'.$ticket['TAXES_TOTAL'].'");
        $("#ticketeditform-total_ref").val("'.$ticket['TOTAL'].'");
        $("#ticketeditform-total_car_ref").val("'.$ticket['TOTAL_CAR'].'");   
        $("#ticketeditform-cur_ref").val("'.$ticket['CURRENCY'].'");
        $("#ticketeditform-cur_rate_ref").val("'.$ticket['CURRENCY_RATE'].'");
        $("#ticketeditform-sf_ref").val("'.$ticket['SERVICE_FEE'].'");
        }
        else
        {
            $("#ticketeditform-fare_ref").val("'.$ticket['FARE'].'");
            $("#ticketeditform-taxes_total_ref").val("'.$ticket['TAXES_TOTAL'].'");
            $("#ticketeditform-total_ref").val("0");
            $("#ticketeditform-total_car_ref").val("0");   
            $("#ticketeditform-cur_ref").val("'.$ticket['CURRENCY'].'");
            $("#ticketeditform-cur_rate_ref").val("'.$ticket['CURRENCY_RATE'].'"); 
        }
     }
   function setVoidVal()
   {
    $("#ticketeditform-fare").val("0");
    $("#ticketeditform-taxes_total").val("0");
    $("#ticketeditform-sf").val("0");
    $("#ticketeditform-taxes").val("");      
    $("#ticketeditform-commis").val("0");
    $("#ticketeditform-commis_amount").val("0");       
    $("#ticketeditform-dis").val("0");
    $("#ticketeditform-dis_amount").val("0");
    $("#ticketeditform-total").val("0");
    $("#ticketeditform-total_car").val("0");   
    $("#ticketeditform-cur").val("'.$ticket['CURRENCY'].'");
    $("#ticketeditform-cur_rate").val("'.$ticket['CURRENCY_RATE'].'"); 
   } 
    
 ';    
 
$script.= <<< JS


$( "#edit-on-button" ).click(function() {
   $('#edit-on-button').addClass('hide'); 
   $('#delete-on-button').addClass('hide'); 
   $('#cencel-edit-button').removeClass('hide'); 
   $('#send-edit-button').removeClass('hide'); 
   $('#div-clon-btn').removeClass('hide'); 
   var dataContainer = $('#edit-ticket-form');
   var dataElements = $('.value', dataContainer); 
   dataElements.addClass("hide");
   var data_edit_Elements = $('.input_value_edit', dataContainer); 
   data_edit_Elements.removeClass("hide");
 });
  $( "#cencel-edit-button2" ).click(function() {
    $( "#cencel-edit-button" ).click();
  });
  $( "#send-edit-button2" ).click(function() {
    $( "#send-edit-button" ).click();
  });
 $( "#cencel-edit-button" ).click(function() {
   $('#edit-on-button').removeClass('hide'); 
   $('#delete-on-button').removeClass('hide');
   $('#cencel-edit-button').addClass('hide'); 
   $('#send-edit-button').addClass('hide'); 
   $('#div-clon-btn').addClass('hide'); 
   var dataContainer = $('#edit-ticket-form');
   var dataElements = $('.value', dataContainer); 
   dataElements.removeClass("hide");
   var data_edit_Elements = $('.input_value_edit', dataContainer); 
   data_edit_Elements.addClass("hide");
   setDefVal();
   setDefFinanceVal();
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
    $('#ticketeditform-total').val(total);
        }
   $('#ticketeditform-status').on('change', function() {
    if(this.value=="VOIDED")
    {
      setVoidVal();
      showTableIssued(); 
    }
    else if(this.value=="REFUNDED")
    {
        setRefundedVal();       
        showTableReF(); 
        financeRefChanged();
    }
    else{
     showTableIssued();
     setIssuedVal();}
   });
    function showTableIssued()
   {
     var element = $('#issued-table');
     if(!$('#issued-table').is(':visible') )
      {
        $('#refund-table').hide();
        element.show();
      }
     
   }
   function showTableReF()
   {    
     var element = $('#refund-table');
     if(!$('#refund-table').is(':visible') )
      {
        $('#issued-table').hide();
        element.show();
      }    
   }
  /*  $('#ticketeditform-fare_ref').on('input',function(e){
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
        var all_com_ref=parseFloat($('#commis_amount_ref').text());
        if(!all_com_ref) all_com_ref=0;
        var com_ref=parseFloat($('#ticketeditform-commis_amount_ref').val());
        if(!com_ref) com_ref=0;
        $('#ticketeditform-total_ref').val((fare+taxes-c_fee-all_com_ref+com_ref).toFixed(2)); 
        $('#ticketeditform-total_car_ref').val((fare+taxes-c_fee-all_com_ref).toFixed(2)); 
        
    }
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY)
?>;
 