<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'MyTicket| Учет продаж авиабилетов';
?>
<div class="main">
<div class="myticket-case">
  <div class="logo"></div>
  <div class="contact-info">
   <div class="email">myticket@hd.com</div>
   <div class="phone">996(552)15-23-03</div>    
  </div> 
  <div class="title">если твоя задача - формировать правильный отчет по продажам авиабилетов, получи <span>myticket!</span></div>
  <div class="login_block">
  <?php $form = ActiveForm::begin( ['id' => 'login-form','fieldConfig' => [
        'template' => "{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,]]); ?>
        <div class="form-row">
        <label class="login-label">Введите Ваш логин</label>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(false); ?>
        </div>
        <div class="form-row">
        <label class="login-label">Введите Ваш пароль</label>
        <?= $form->field($model, 'password')->passwordInput()->label(false); ?>
        </div>
         <div class="form-row_btn">
         <?= Html::submitButton('Войти', ['class' => 'btn-login', 'name' => 'login-button']) ?>
         </div>

   <?php ActiveForm::end(); ?>
    </div> 
  <?=Html::tag('div', '&copy 2015-'.date("Y").' Avia Ticket', ['class'=>'copyright']);?>
</div>
</div>