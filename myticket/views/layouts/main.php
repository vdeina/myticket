<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\CurrencyRate;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if(Yii::$app->user->isGuest):?>
    <div class="container">
        <?= $content ?>
    </div>
   <?php else : ?> 
   <div class="wrap">
    <div class="myticket-menu">
      <div class="mymenu-container">
      <div class="mt-logo-wrapper"><a href="<?=Yii::$app->urlManager->createUrl('')?>" id="mt-logo"></a></div>
      <div class="mt-links-wrapper">
      <div class="mt-links-container">
      <ul class="web">
      <li class="menuItem" <?=(Yii::$app->controller->action->id=='index')?'style="border-top-color: #4eb7f5;"':''?>><a class="link-menu" href="<?=Yii::$app->urlManager->createUrl('')?>">Главная</a></li>
      <li class="menuItem" <?=(Yii::$app->controller->action->id=='tickets')?'style="border-top-color: #4eb7f5;"':''?> ><a class="link-menu" href="<?=Yii::$app->urlManager->createUrl('/tickets')?>">Билеты</a></li>
      <li class="menuItem"  <?=(Yii::$app->controller->action->id=='payments-agents' || Yii::$app->controller->action->id=='payments-carriers' )?'style="border-top-color: #4eb7f5;"':''?> ><a class="link-menu" href="#">Оплаты
      <div class="sub-menu-arrow">
      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="10" height="5.7" viewBox="0 0 10 5.7" enable-background="new 0 0 9.992 5.695" xml:space="preserve">
      <polygon fill="none" points="5 5.7 0 0.7 0.7 0 5 4.4 9.3 0 10 0.7 "></polygon>
      </svg>
      </div></a>
      <ul class="mt-menu-drop-down">
      <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/payments-agents')?>">Оплата кассиров</a></li>
      <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/payments-carriers')?>">Оплата авиакомпаниям</a></li>
      </ul>        
      </li>
      <li class="menuItem"  <?=(Yii::$app->controller->action->id=='agents-reports' || Yii::$app->controller->action->id=='aviacompanies-reports' )?'style="border-top-color: #4eb7f5;"':''?> ><a class="link-menu" href="#">Отчеты
      <div class="sub-menu-arrow">
      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="10" height="5.7" viewBox="0 0 10 5.7" enable-background="new 0 0 9.992 5.695" xml:space="preserve">
      <polygon fill="none" points="5 5.7 0 0.7 0.7 0 5 4.4 9.3 0 10 0.7 "></polygon>
      </svg>
      </div></a>
      <ul class="mt-menu-drop-down">
      <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/agents-reports')?>">По кассирам</a></li>
      <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/aviacompanies-reports')?>">По авиакомпаниям</a></li>
      </ul>      
      </li>
      <li class="menuItem"<?=(Yii::$app->controller->action->id=='carriers' || Yii::$app->controller->action->id=='agents' || Yii::$app->controller->action->id=='add-record')?'style="border-top-color: #4eb7f5;"':''?> ><a class="link-menu" href="#">Добавить
      <div class="sub-menu-arrow">
      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="10" height="5.7" viewBox="0 0 10 5.7" enable-background="new 0 0 9.992 5.695" xml:space="preserve">
      <polygon fill="none" points="5 5.7 0 0.7 0.7 0 5 4.4 9.3 0 10 0.7 "></polygon>
      </svg>
      </div></a>
      <ul class="mt-menu-drop-down">
      <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/carriers')?>">Добавить авиакомпанию</a></li>
      <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/agents')?>">Добавить кассира</a></li>
      <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/add-record')?>">Добавить билет</a></li>
       <li><a  class="link-drop-down" href="<?=Yii::$app->urlManager->createUrl('/payments')?>">Добавить форму оплаты</a></li>
      </ul>      
      </li>
      </ul>
      </div>
      </div>
      
      <? if(Yii::$app->controller->action->id!='ticket-details' && Yii::$app->controller->action->id!='add-record' ):?>
      <div class="mt-user-state-wrapper">
       <div class="mt-user-image-wrapper">
       <div class="mt-user-fallback-image">&nbsp;</div></div> 
       <div class="user-name-wrapper"><div class="user-name"><?=Yii::$app->user->identity->username?>
          <div class="sub-menu-arrow">
       <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" width="10" height="5.7" viewBox="0 0 10 5.7" enable-background="new 0 0 9.992 5.695" xml:space="preserve">
       <polygon fill="none" points="5 5.7 0 0.7 0.7 0 5 4.4 9.3 0 10 0.7 "></polygon>
       </svg>
       </div>
       </div></div>       
       <ul class="mt-settings-drop-down">
      <li>  <?=Html::a('Выйти',
           ['/logout'],
           ['data' => ['method' => 'post',]])?></li>
      </ul>
      </div>
     <?php endif; ?>
     <?=CurrencyRate::widget()?>
      </div>
    </div>
    <div class="container" id="container">
    <?= $content ?>
    
<div class="sweet-overlay" id="sweet-overlay_cur" tabindex="-1" style="opacity: 0; display: none;"></div>
<div class="sweet-alert hideSweetAlert" id="sweet-alert" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -111px;">
<span style="font-family:Helveticaneuecyr Light;color: #20303c;font-size: 24px;">Изменение курса валют</span>
<div style="width: 100%;height: 70px;color: #20303c;font-family: Helveticaneuecyr Light;font-size: 22px;">
<table style="width: 100%;height: 100%;">    
<body>
<tr><td>
<span>1 <span id="span-edit-cur"></span><span> = </span><?= Html::input('text','','',['class'=>'input-cur','id'=>'input-cur-rate','maxlength'=>'6']);?><span> <?=Yii::$app->user->identity->local_cur?></span>
</td></tr>
</body>
</table>
</div>
<div style="width: 100%;*/height: 15px;/* padding: 10px 0px; */color: #20303c;font-family: Helveticaneuecyr Light;font-size: 15px;color: red;"><span id="cur_rate_error"></span></div>
<div style="width: 100%;height: 60px;padding: 10px 0px;">
<button type="button" id="edit-cur-button" class="button edit-cur-button">Обновить</button>
<button type="button" id="cencel-edit-cur-button" class="button cencel-edit-cur-button">Отмена</button></div>
</div>
   </div>
   </div>
   <footer class="footer">  
   <?=Html::tag('div', '&copy 2015-'.date("Y").' Avia Ticket', ['class'=>'mt-copyright','style'=>'width:100%']);?>
</footer>
  <?php endif; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
