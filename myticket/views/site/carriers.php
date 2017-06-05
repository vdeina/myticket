<?php
	 use yii\helpers\Html;
     $this->title = 'Авиакомпании|MyTicket';
?>
<div class="carriers" id="carriers">
<div style="height: 40px;"></div>
<table class="table-carriers" id="table-carriers">
<?=$this->render('table_carriers',['carriers'=>$carriers])?> 
</table>
<div style="height: 40px;width: 1024px;margin: 30px auto;text-align: center;">
<div style="position: relative;width: 200px;margin: 0 auto;">
<button  type="button" id="add_carrier_btn" class="button add_payments_btn">Добавить</button>
</div>
</div>
</div>
<div class="sweet-overlay" id="sweet-overlay" tabindex="-1" style="opacity: 0; display: none;"></div>
<div class="sweet-alert hideSweetAlert" id="sweet-alert_car" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 24px;">Новая авиакомпания</span>
<div style="width: 100%;height: 70px;color: #20303c;font-family: Helveticaneuecyr Light;font-size: 22px;">
<table style="width: 100%;height: 100%;">    
<body>
<tr><td>
<span><?= Html::input('text','','',['class'=>'input-carrier','id'=>'input-carrier','maxlength'=>'20']);?></td></tr>
</body>
</table>
</div>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="cur_rate_error"></span></div>
<div style="width: 100%;height: 60px;padding: 10px 0px;">
<button type="button" id="add-carrier-button" class="button edit-cur-button">Сохранить</button>
<button type="button" id="cencel-add-carrier-button" class="button cencel-edit-cur-button">Отмена</button></div>
</div>
</div>