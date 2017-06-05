<?php
	 use yii\helpers\Html;
?>
<body>
<?php
	if(count($carriers)>0):
?>
<thead>
<tr>
  <th>Авиакомпания</th>
</tr>
</thead>
<?php foreach($carriers as $carrier):?>
<tr class="agent-items tr-hover" id="<?=$carrier['id']?>">
<td><span><?=$carrier['name']?></span></td> 
</tr>
<?php endforeach; ?>
<? else: ?>
<tr style="border: none;"><td>У Вас не зарегистрировано ни одной авиакомпании</td></tr>
<?endif;?>
</body>