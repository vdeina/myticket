<body>
<?php
	if(count($agents)>0):
?>
<?php foreach($agents as $agent):?>
<tr class="agent-items tr-hover" id="<?=$agent['id_agent']?>">
<td class="agent-name" title="Имя кассира"><span><?=$agent['name']?></span></td> 
<td class="agent-sine" title="Сайны кассира"><span><?=$agent['sine']?></span></td> 
<td title="Дата создания"><span><?=$agent['datetime']?></span></td> 
<td style="width: 315px;"><div><button type="button" id="remove-agent-button-id<?=$agent['id_agent']?>" onclick="removeAgent(this.id);" class="button agent_cencel_btn">Удалить</button><button type="submit" id="edit-agent-button-id<?=$agent['id_agent']?>" onclick="editAgent(this.id);"  class="button edit_agent_btn">Редактировать</button></div></td> 
</tr>
<?php endforeach; ?>
<? else: ?>
<tr style="border: none;"><td>У Вас не зарегистрировано ни одного кассира</td></tr>
<tr style="border: none;"><td><button type="button" onclick="clickAddRecordBtn();" class="button add_record_btn" style="float: none;">Добавить кассира</button></td></tr>
<?endif;?>
</body>