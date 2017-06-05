<?php
	 use yii\helpers\Html;
     $this->title = 'Кассиры|MyTicket';
?>
<div class="agents-details" id="agents-details">
<div class="agents-controller">
<button type="button" id="add_agent_btn" <?=(count($agents)>0)?"":'style="display: none;"'?> class="button add_record_btn">Добавить кассира</button>
</div>
<table class="table-agents-view" id="table-agents">
<?=$this->render('table-agents-view',['agents'=>$agents])?> 
</table>
<div class="sweet-overlay" id="sweet-overlay" tabindex="-1" style="opacity: 0; display: none;"></div>
<div class="sweet-alert add_agent hideSweetAlert" id="sweet-add-agent" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span id="add-agent-title" style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 24px;">Добавление кассира</span>
<div style="width: 100%;margin-top: 30px;color: #20303c;font-family: ProximaNova Reg;font-size: 20px;">
<table style="width: 100%;height: 100%;margin-bottom: 20px;">    
<body>
<tr>
<td style="padding: 4px 0 0 0;text-align: right;width: 131px;"><span>Имя кассира</span></td>
<td>
<?= Html::input('text','','',['class'=>'input-agent-name','id'=>'input_agent_name','maxlength'=>'30']);?>
</td></tr>
<tr>
<td style="padding: 4px 0 0 0;text-align:right;">Сайны</td>
<td>
<?= Html::input('text','','',['class'=>'input-agent-sine','id'=>'input_agent_sine','maxlength'=>'400']);?>
</td></tr>
</body>
</table>
</div>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="agent_add_error"></span></div>
<div style="width: 100%;height: 60px;padding: 10px 0px;">
<div style="display: none;"><?= Html::input('text','','',['id'=>'agent_add_action','maxlength'=>'30']);?></div>
<div style="display: none;"><?= Html::input('text','','',['id'=>'agent_id']);?></div>
<button type="button" id="edit-add-agent-button" class="button edit-add-agent-button">Сохранить</button>
<button type="button" id="cencel-add-agent-button" class="button cencel-add-agent-button">Отмена</button></div>
</div>
<div class="sweet-alert remove_agent hideSweetAlert" id="sweet-remove-agent" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span id="add-agent-title" style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 20px;">Вы действительно хотите удалить кассира  "<span id="remove-agent-name"></span>"</span>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="agent_remove_error"></span></div>
<div style="width: 100%;height: 65px;padding: 20px 0px;">
<div style="display: none;"><?= Html::input('text','','remove_agent',['id'=>'agent_remove_action','maxlength'=>'30']);?></div>
<div style="display: none;"><?= Html::input('text','','',['id'=>'remove_agent_id']);?></div>
<button type="button" id="edit-remove-agent-button" class="button edit-remove-agent-button">Удалить</button>
<button type="button" id="cencel-remove-agent-button" class="button cencel-remove-agent-button">Отмена</button></div>
</div>
</div>