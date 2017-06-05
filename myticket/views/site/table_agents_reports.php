<?php
	 use yii\helpers\Html;
     
     if(count($tickets)>0):
?>
<thead>
    <tr>
        <th>Кассир</th>
        <th>Продажа</th>
        <th>Оплата</th>
        <th>Сервисный сбор</th>
        <th>Скидка</th>
        <th>Расход</th>
        <th>Долг/Переплата</th>
    </tr>
</thead>
<tbody>
<?php foreach($tickets as $ticket):?>
    <tr>
        <td><?=$ticket['agent']?></td>
        <td><?=$ticket['total_ticket']?></td>
        <td><?=$ticket['payment']?></td>
        <td><?=$ticket['service_fee']?></td>
        <td><?=$ticket['discount']?></td>
        <td><?=$ticket['expense']?></td>
        <td><?=$ticket['total_ticket'] - $ticket['payment'] - $ticket['expense']?></td>    
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