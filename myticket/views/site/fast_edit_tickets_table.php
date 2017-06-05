<?php
	use yii\helpers\Url;
?>
<?php
	if(count($tickets)>0):
?>
<thead>
<tr>
  <th>Кассир</th>
  <th>№ Билета</th>
  <th>PNR</th>
  <th>ФИО</th>
  <th>VC</th>
  <th>Статус</th>
  <th>Всего</th>
  <th>Валюта</th>
  <th>Дата</th>
</tr>
</thead>
<body>
<?php foreach($tickets as $ticket):?>
<tr class="tr-ticket-items" id="<?=$ticket['ID']?>">
<td class="agent"><?=($ticket['name']=="")?'ADMIN':$ticket['name']?></td>
<td class="doc-num"><a class="txtlink" target="_blank" href="<?=Url::to(["ticket-details","record"=>$ticket['ID']])?>"><?=$ticket['DOCUMENT_NUMBER']?></a></td>
<td class="pnr"><?=$ticket['RECORD_LOCATOR']?></td>
<td><span title="<?=$ticket['LAST_NAME']." ".$ticket['FIRST_NAME']?>" class="catcher"><?=$ticket['LAST_NAME']." ".$ticket['FIRST_NAME']?></span></td> 
<td class="vc"><?=$ticket['VALIDATING_CARRIER']?></td>
<td class="status"><?=$ticket['STATUS']?></td>
<td class="total"><?=$ticket['TOTAL']?></td>
<td class="cur_view"><?=$ticket['CURRENCY']?></td>
<td class="doc_issued" title="<?=date('dMy H:i',strtotime($ticket['DOCUMENT_ISSUED']))?>"><?=date('dMy',strtotime($ticket['DOCUMENT_ISSUED']))?></td>
<td class="responce" style="display: none;"><?=($ticket['RESPONSIBLE']=="")?'4':$ticket['RESPONSIBLE']?></td>
<td class="sf" style="display: none;"><?=$ticket['SERVICE_FEE']?></td>
<td class="fm" style="display: none;"><?=(Yii::$app->user->identity->hide_fees_pegasus & $ticket['TYPE']=="ПЕГАСУС")?"0":$ticket['COMMISSION']?></td>
<td class="dis" style="display: none;"><?=$ticket['DISCOUNT']?></td>
<td class="cur_rate" style="display: none;"><?=($ticket['CURRENCY_RATE']=="0")?'':$ticket['CURRENCY_RATE']?></td>
<td class="cur" style="display: none;"><?=$ticket['CURRENCY']?></td>
</tr>
<?php endforeach; ?>
</body>
<? else: ?>
 <thead>
<tr>
    <th class="no-tickets">Не найдено</th>
</tr>
 </thead>
<?endif;?>
