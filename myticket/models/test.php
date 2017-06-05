   <tr>
                    <td class="button-lable"><label>&nbsp;</label></td>
                    <td class="lable"><span>Валюта</span></td>
                    <td class="field"><?=$form->field($edit_model, 'cur_rate')->textInput(['class'=>'my','onkeypress'=>'return event.keyCode != 13;','style'=>"width: 46%;float: left;"])->label(false);?>
                    <?= $form->field($edit_model, 'cur')->dropDownList($cur,['class'=>'cur','style'=>"width: 46%;float: right;"])->label(false);?></td>                 
                   </tr>  