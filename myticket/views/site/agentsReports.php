<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
 $this->title = 'Отчет по кассирам|MyTicket';
$responce_param = ['options' =>[($filter_arr["responsible"]=="")?'': $filter_arr["responsible"] => ['Selected' => true]],'prompt' => 'Все'];
?>
<div class="agents-details" id="agents-details">
<div class="showfilterdetails" id="showfilterdetails" title="Фильтр">
    <div class="filter_active" title="Установлен фильтр" <?=($filter_arr["first_period"]!="" || $filter_arr["second_period"]!="" || $filter_arr["responsible"]!="")?"":"style='display: none;'"?>>
    </div>
</div>
<div class="div-export-excel">
<?= Html::submitButton('Excel',['class' => 'button excel_export_btn','id'=>'excel_export_btn']) ?>
</div>
<div style="height: 55px;"></div>
<div class="filterdetails" id="filterdetails">
<?php $form = ActiveForm::begin(['id' => 'filters-form','action' => ['/agents-reports'],'fieldConfig' => [
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
             
              <?= Html::submitButton('Обновитиь',['class' => 'button filter_send_btn','id'=>'send-edit-button']) ?> 
              </div>
             </div>                  
             <?= Html::input('text','actions','filters_details',['style'=>'display: none', 'id'=>'actions']);?>
<?php ActiveForm::end(); ?>
</div>
<table class="table-agents-reports" id="table-agents-reports">
<?=$this->render('table_agents_reports',['tickets'=>$tickets])?> 
</table>
</div>
 <?php
$script = <<< JS
    $('#showfilterdetails').click(function(){
        $('#filterdetails').toggle();
    });
    $('#excel_export_btn').click(function(){
         $('#actions').val('excel_export');
         $('#filters-form').submit();
    });
    $('#send-edit-button').click(function(){
         $('#actions').val('filters_details');
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY)
?>;