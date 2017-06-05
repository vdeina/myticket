<?php
	 use yii\helpers\Html;
     
     if(count($tickets)>0):
?>
<thead>
    <tr>
        <th>Авиакомпания</th>
        <th>Продажа</th>
        <th>Комиссия</th>
        <th>Продажа без комиссии</th>
        <th>Оплата</th>
        <th>Долг/Переплата</th>
    </tr>
</thead>
<tbody>
<?php foreach($tickets as $ticket):?>
    <tr>
        <td><?=$ticket['aviacompany']?></td>
        <td><?=$ticket['total']?></td>
        <td><?=$ticket['comission']?></td>
        <td><?=$ticket['total'] - $ticket['comission']?></td>
        <td><?=$ticket['payment']?></td>
        <td><?=$ticket['total'] - $ticket['comission'] - $ticket['payment']?></td>    
    </tr>
<?php 
    endforeach;
?>

</tbody>
<?php else: ?>
<tbody>
    <tr style="border: none;">
        <td>За текущий период отчетов не найдено.</td>
    </tr>
</tbody>
<?php endif;?>