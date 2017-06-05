<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
$this->title = 'Билеты|MyTicket';
$responce_param = ['options' =>[($filter_arr["responsible"]=="")?'': $filter_arr["responsible"] => ['Selected' => true]],'prompt' => 'Все'];
$carriers_param = ['options' =>[($filter_arr["val_car"]=="")?'': $filter_arr["val_car"] => ['Selected' => true]],'prompt' => 'Все'];
$procedure_param = ['options' =>[($filter_arr["procedure"]=="")?'': $filter_arr["procedure"] => ['Selected' => true]],'prompt' => 'Все'];
$procedure=array('ISSUED'=>'ISSUED','REISSUED'=>'REISSUED','REFUNDED'=>'REFUNDED','VOIDED'=>'VOIDED');
?>
<div class="tickets">
<div class="tickets-controller">
<button  type="button" id="add_record_btn" class="button add_record_btn">Добавить запись</button>
<div class="showfilterdetails" id="showfilterdetails" title="Фильтр"><div class="filter_active" title="Установлен фильтр" <?=($filter_arr["first_period"]!="" ||$filter_arr["second_period"]!="" || $filter_arr['val_car']!="" || $filter_arr["responsible"]!="" || $filter_arr["procedure"]!="" || $filter_arr["pnr_ticket_pax"]!="")?"":"style='display: none;'"?>></div></div>
<div class="div-export-excel">
<?php $form = ActiveForm::begin(['id' => 'export-excel','fieldConfig' => [
        'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",]]); ?>
              <?= Html::input('text','actions','excel_export',['style'=>'display: none']);?>
<?= Html::submitButton('Excel',['class' => 'button excel_export_btn','id'=>'excel_export_btn']) ?>
<?php ActiveForm::end(); ?> 
</div>
<div style="float: right;">
<?php

    echo LinkPager::widget([
    'pagination' => $pagination,    
]);
?>
<div style="
    float: left;
    margin: 22px 5px;
    color: #337ab7;
">
<span><?php
    $PageSize=$pagination->getPageSize();
    $totalCount=$pagination->totalCount;
	if($totalCount>$PageSize)
    { 
       $current_count=$pagination->getPage()*$pagination->getPageSize()+count($tickets);
       echo $current_count.' из '. $pagination->totalCount;
    }
?></span></div>
</div>
</div>
<div class="filterdetails" id="filterdetails">
 <?php $form = ActiveForm::begin(['id' => 'filters-form','action' => ['/tickets'],'fieldConfig' => [
        'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,]]); ?>
                    <div class="filter-div">
                     <div class="div-filter"> 
                    <div class="filter-title"><span>Период</span></div>
                     <?= $form->field($filter_model, 'first_period')->widget(
                        DatePicker::className(), [
                            'def_value'=>$filter_arr["first_period"],
                            'language' => 'ru',
                            'clientOptions' => [
                                'autoclose' => true,
                                'class'=>'myclass',
                                'format' => 'yyyy-mm-dd',

                            ]
                    ])->label(false);?>
                     <?= $form->field($filter_model, 'second_period')->widget(
                        DatePicker::className(), [
                            'def_value'=>$filter_arr["second_period"],
                            'language' => 'ru',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',

                            ]
                    ])->label(false);?>
                                        
                     <div class="filter-title"><span>Кассир</span></div>
                     <?= $form->field($filter_model, 'responsible')->dropDownList($agents,$responce_param)->label(false);?> 
                     <div class="filter-title"><span>Авиа п-к</span></div>
                     <?=$form->field($filter_model, 'val_car')->dropDownList($carriers,$carriers_param)->label(false);?>
                     <div class="clear-filters" id="clearfilters" title="Очистить фильтры"></div> 
                     </div> </div>
                      <div class="filter-div"> 
                        <div class="div-filter" style="width: 600px;"> 
                      <div class="filter-title"><span>Операция</span></div>
                      <?= $form->field($filter_model, 'procedure')->dropDownList($procedure,$procedure_param)->label(false);?> 
                      <?=$form->field($filter_model, 'pnr_ticket_pax')->textInput(['class'=>'filter-search','placeholder'=>'PNR, ФИО или № билета','value'=>$filter_arr['pnr_ticket_pax']])->label(false);?>                     
                     </div> </div>
                     <div class="filter-div"> 
                      <?= Html::submitButton('Обновитиь',['class' => 'button filter_send_btn','id'=>'send-edit-button']) ?> 
                      
                     </div>                  
                     <?= Html::input('text','actions','filters_details',['style'=>'display: none']);?>
           <?php ActiveForm::end(); ?> 
</div>
<table class="tickets_view_table" id="tickets_view_table">
<?=$this->render('view_tickets_table',['tickets'=>$tickets])?> 
</table>
</div>
  <?php
$script = <<< JS
 jQuery(document).ready(function($) {
     $("#add_record_btn").click(function() {
        window.open("/add-record", '_blank');
    });
    $(".ticket-items").click(function() {
        window.open($(this).data("href"), '_blank');
    });
    $("#showfilterdetails").click(function(){
        $("#filterdetails").slideToggle();
    });
     $("#clearfilters").click(function(){
        $("#filterticketsform-val_car").val('');
        $("#filterticketsform-responsible").val('');
        $("#filterticketsform-first_period").val('');
        $("#filterticketsform-second_period").val('');
        $("#filterticketsform-procedure").val('');
        $("#filterticketsform-pnr_ticket_pax").val('');
    });
    $('.export-excel').hover(function() {
     $("#sbs-circle").addClass('circle-hover');  
     $('.export-excel').addClass('ticket-count-hover');  
    }, function() {
     $("#sbs-circle").removeClass('circle-hover');  
     $('.export-excel').removeClass('ticket-count-hover');  
});
});
JS;
$this->registerJs($script, yii\web\View::POS_READY)
?>;