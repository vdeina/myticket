<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    $this->title = 'Главная|MyTicket';
    $periods=array('1'=>'за сегодня','2'=>'за 3 дня','3'=>'за неделю','4'=>'за месяц');
    //$agents=array('1'=>'АЙСУЛУУ','2'=>'АЛЬМИРА','3'=>'АСЕЛЬ','4'=>'АСЫЛКАН');
    //$tickets=array();
    $cur=array('KGS'=>'KGS','USD'=>'USD','KZT'=>'KZT','EUR'=>'EUR');
 ?>
<div class="fast-edit">
<div class="view-tickets-div">
<div class="controllers">
 <?php $form = ActiveForm::begin(['id' => 'fast-search-form','action' => ['/action-tickets'],'fieldConfig' => [
        'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,]]); ?>
                    <?= Html::submitButton('',['class' => 'button refresh_btn','id'=>'fast-search-button', 'name' => 'fast-search-button']) ?>
                    <?= $form->field($search_model, 'period')->dropDownList($periods,['class'=>'period-view'])->label(false);?>
                    <?=$form->field($search_model, 'search_word')->textInput(['class'=>'sb-search -active','placeholder'=>'Напр.: PNR,ФИО или № билета'])->label(false);?>                   
                    <?= Html::input('text','actions','get_airfile_list',['style'=>'display: none']);?>
           <?php ActiveForm::end(); ?> 
           <div id="view-loader" class="cssload-speeding-wheel" style="display: none;"></div>
           <div id="div-ticket-count">
            <div class="ticket-count" title="Количество билетов"><span id="tickets-count"><?=count($tickets)?></span></div>
 <svg class="sbs-stroke -absolute" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" aria-labelledby="Toggle"> 
    <circle id="sbs-circle"class="sbs-circle" cx="35" cy="35" r="30" stroke="#459fed" stroke-width="2"></circle>
  </svg>
  </div>
 </div>
 <div class="office_div">
 <table class="fast_view_table" id="fast_view_table">
  <?=$this->render('fast_edit_tickets_table',['tickets'=>$tickets])?> 
  </table>
 </div>
</div>
</div>
<div class="edit-ticket-div">
<div class="edit-title">
  <span>Билет</span>
</div>

 <?php $form = ActiveForm::begin(['id' => 'fast-edit-form','action' => ['/action-tickets'],'fieldConfig' => [
        'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                    'enableClientValidation' => true,
                    'validateOnBlur' => true,
                    'validateOnType' => true,
                    'validateOnChange' => true,]]); ?>
                    <table id="table-form-edit">
                    <tr><td class="button-lable"><label>&nbsp;</label></td>
                    <td class="lable-off"><span>Инфо. билета</span></td>
                    <td class="field-off"><input  readonly="" id="ticket-info" type="text" name="ticket-info"/></td>                 
                    </tr>
                    <tr>
                    <td class="button-lable"><label>&nbsp;</label></td>
                    <td class="lable"><span>Кассир</span></td>
                    <td class="field"><?= $form->field($edit_model, 'agent')->dropDownList($agents,['class'=>'agents'])->label(false);?></td>                 
                   </tr>
                   <tr>
                    <td class="button-lable"><label>&nbsp;</label></td>
                    <td class="lable"><span>Сер. сбор</span></td>
                    <td class="field"><?=$form->field($edit_model, 'sf')->textInput(['class'=>'my','onkeypress'=>'return event.keyCode != 13;'])->label(false);?></td>                 
                   </tr>
                    <tr>
                    <td class="button-lable"><label>&nbsp;</label></td>
                    <td class="lable"><span>Комиссия</span></td>
                    <td class="field"><?=$form->field($edit_model, 'fm')->textInput(['class'=>'my','onkeypress'=>'return event.keyCode != 13;'])->label(false);?></td>                 
                   </tr>
                    <tr>
                    <td class="button-lable"><label>&nbsp;</label></td>
                    <td class="lable"><span>Скидка</span></td>
                    <td class="field"><?=$form->field($edit_model, 'dis')->textInput(['class'=>'my','onkeypress'=>'return event.keyCode != 13;'])->label(false);?></td>                 
                   </tr>    
                     <tr>
                    <td class="button-lable"><label>&nbsp;</label></td>
                    <td class="lable"><span>Валюта</span></td>
                    <td class="field"><?=$form->field($edit_model, 'cur_rate')->textInput(['class'=>'my','onkeypress'=>'return event.keyCode != 13;','style'=>"width: 46%;float: left;"])->label(false);?>
                    <?= $form->field($edit_model, 'cur')->textInput(['class'=>'cur','readonly'=>"",'style'=>"width: 46%;float: right;"])->label(false);?></td>                 
                   </tr>       
                   <tr><td class="field-btn" colspan="3"><div style="width: 250px;margin: 0 auto;position: relative;"><?= Html::submitButton('Обновить',['class' => 'button edit_btn','id'=>'fast-edit-button', 'name' => 'fast-edit-button']) ?><div id="view-edit-loader" class="cssload-speeding-wheel loader-update"  style="display: none;"></div></div></td>
                   <td> <?= Html::input('text','actions','update_airfile',['style'=>'display: none']);?><?= Html::input('text','ticket-id','',['style'=>'display: none','id'=>'ticket-id-update']);?></td></tr>
          </table>
                  
           <?php ActiveForm::end(); ?> 

</div>
</div>
    <?php
$script = <<< JS
    $('#table-form-edit tr').hover(function() {
     var td = $(this).find(".lable"); 
     td.addClass('label-hover');
     var input = $(this).find(".field").find('input');
     if(input.length>0)
     input.addClass('input-hover');
     var select = $(this).find(".field").find('select');
     if(select.length>0)
     select.addClass('input-hover');      
}, function() {
     var td = $(this).find(".lable"); 
     td.removeClass('label-hover');
      var input = $(this).find(".field").find('input');
      if(input.length>0)
      input.removeClass('input-hover');
      var select = $(this).find(".field").find('select');
      if(select.length>0)
      select.removeClass('input-hover');    
});
$('.ticket-count').hover(function() {
     $(this).addClass('ticket-count-hover');  
     $('#sbs-circle').addClass('circle-hover');  
}, function() {
     $(this).removeClass('ticket-count-hover');  
     $('#sbs-circle').removeClass('circle-hover');  
});
    $("#fastviewform-period").change(btnClick);    
    function btnClick()
     {  
       $('#fast-search-button').click();
     }
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY)
?>;
