<?php
	use yii\helpers\Url;
?>
<thead>
<tr>
  <th>PNR</th>
  <th style="width: 132px;">№ Билета</th> 
  <th>VC</th>
  <th>ФИО</th> 
  <th>Валюта</th>
  <th>Курс вал.</th>
  <th>Комиссия</th>
  <th>Сер. сбор</th>
  <th>Скидка</th>
  <th>Всего</th>
  <th>Всего АК</th>
  <th>Статус</th> 
  <th>Кассир</th> 
  <th>Дата</th>
  <th>Источник</th>
</tr>
</thead>
<?php
	if(count($tickets)>0):
?>
<body>
<?php foreach($tickets as $ticket):?>
<tr class="ticket-items" id="<?=$ticket['ID']?>"  data-href="<?=Url::to(['ticket-details','record'=>$ticket['ID']])?>">
<td><?=$ticket['RECORD_LOCATOR']?></td> 
<td><?=$ticket['DOCUMENT_NUMBER']?></td> 
<td><?=$ticket['VALIDATING_CARRIER']?></td> 
<td><span title="<?=$ticket['LAST_NAME']." ".$ticket['FIRST_NAME']?>" class="catcher"><?=$ticket['LAST_NAME']." ".$ticket['FIRST_NAME']?></span></td> 
<td><?=$ticket['CURRENCY']?></td> 
<td><?=$ticket['CURRENCY_RATE']?></td> 
<td><?=(Yii::$app->user->identity->hide_fees_pegasus & $ticket['TYPE']=="ПЕГАСУС")?"0":$ticket['COMMISSION_AMOUNT']?></td> 
<td><?=$ticket['SERVICE_FEE']?></td> 
<td><?=$ticket['DISCOUNT_AMOUNT']?></td> 
<td><?=$ticket['TOTAL']?></td> 
<td><?=(Yii::$app->user->identity->hide_fees_pegasus & $ticket['TYPE']=="ПЕГАСУС")?"0":$ticket['TOTAL_CAR']?></td> 
<td><?=$ticket['STATUS']?></td> 
<td><?=($ticket['name']=="")?"Admin":$ticket['name']?></td> 
<td><?=date('dMy H:i',strtotime($ticket['DOCUMENT_ISSUED']))?></td> 
<td><?=$ticket['TYPE']?></td> 
</tr>
<?php endforeach; ?>
</body>
<? else: ?>
<tr>
    <td  colspan="15" class="no-tickets">Не найдено</td>
</tr>
<?endif;?>
