<?php
	 use yii\helpers\Html;
     use dosamigos\datepicker\DatePicker;
?>
<body>
<thead>
<tr>
  <th>Авиакомпания</th>
  <th>Сумма оплаты</th>
  <th>Примечания</th>
  <th>Метод оплаты</th>
  <th>Дата</th>
  <th>Редактировать</th>
</tr>
</thead>
<?php
	if(count($payments)>0):
?>
<?php foreach($payments as $payment):?>
<tr class="agent-items tr-hover" id="<?=$payment['id']?>">
<td><span id="value_carname_id<?=$payment['id']?>"><?=$payment['name']?></span></td> 
<td><span id="value_carpay_id<?=$payment['id']?>"><?=$payment['value_pay']?></span></td>
<td><textarea class="exp-text" id="value_note_id<?=$payment['id']?>"><?=$payment['text']?></textarea ></td> 
<td><span id="value_pay_met_id<?=$payment['id']?>"><?=$payment['method']?></span><span id="edit_method_id<?=$payment['id']?>" style="display: none;"><?=$payment['method_id']?></span></td> 
<td><span id="value_cardate_id<?=$payment['id']?>"><?=$payment['date']?></span></td>
<td><div style="margin: 0 auto;width: 246px;"><button type="button" id="remove-agent-button-id<?=$payment['id']?>" onclick="removeCarPayment(this.id);" class="button agent_cencel_btn">Удалить</button><button type="submit" id="edit-agent-button-id<?=$payment['id']?>" onclick="editCarPay(this.id);"  class="button edit_agent_btn">Редактировать</button></div></td>
</tr>
<?php endforeach; ?>
<? else: ?>
<tr style="border: none;"><td colspan="6">Не найдено</td></tr>
<?endif;?>
</body>