<?php
	 use yii\helpers\Html;
?>
<body>
<thead>
<tr>
  <th>Кассир</th>
  <th>Сумма оплаты</th>
  <th>Сумма расхода</th>
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
<td><span id="value_name_id<?=$payment['id']?>"><?=$payment['name']?></span></td> 
<td><span id="value_pay_id<?=$payment['id']?>"><?=$payment['value_pay']?></span></td> 
<td><span id="value_exp_id<?=$payment['id']?>"><?=$payment['value_exp']?></span></td> 
<td><textarea class="exp-text" id="value_note_id<?=$payment['id']?>"><?=$payment['text']?></textarea ></td> 
<td><span id="value_pay_met_id<?=$payment['id']?>"><?=$payment['method']?></span><span id="edit_method_id<?=$payment['id']?>" style="display: none;"><?=$payment['method_id']?></span></td> 
<td><span id="date_id<?=$payment['id']?>"><?=$payment['date']?></span></td> 
<td><div><button type="submit" id="edit-agent-button-id<?=$payment['id']?>" onclick="editAgentPay(this.id);"  class="button edit_agent_btn">Редактировать</button></div><div><button type="button" id="remove-agent-button-id<?=$payment['id']?>" onclick="removeAgentPayment(this.id);" class="button agent_cencel_btn">Удалить</button></div></td>
</tr>
<?php endforeach; ?>
<? else: ?>
<tr style="border: none;"><td colspan="5">Не найдено</td></tr>
<?endif;?>
</body>