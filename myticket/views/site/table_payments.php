<?php
	 use yii\helpers\Html;
?>
<body>
<?php
	if(count($payments)>0):
?>
<thead>
<tr>
  <th>Формы оплаты</th>
</tr>
</thead>
<?php foreach($payments as $payment):?>
<tr class="agent-items tr-hover" id="<?=$payment['id']?>">
<td><span id="method_nameid<?=$payment['id']?>"><?=$payment['method']?></span><span class="icon icon_edit" id="form_editid<?=$payment['id']?>" onclick="editForPayment(this.id);"></span><span id="form_removeid<?=$payment['id']?>" class="icon icon_remove" onclick="removeForPayment(this.id);"></span></td> 
</tr>
<?php endforeach; ?>
<? else: ?>
<tr style="border: none;"><td>У Вас не зарегистрировано ни одной формы оплаты</td></tr>
<?endif;?>
</body>