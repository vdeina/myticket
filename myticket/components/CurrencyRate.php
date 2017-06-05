<?php
    namespace app\components;
    use Yii;
	use yii\base\Widget;
    use yii\helpers\Html;
    use app\models\Dal;
    
  class CurrencyRate extends Widget
  {
     public function run()
    {
          $dal=new Dal();
          $cur_rate=$dal->getAllCurRate();
          if(count($cur_rate)==0)
            return Html::tag('div',"",['class'=>'cur-rate-wraper']);
          if(count($cur_rate)>2)
          {
            $step=0;
            foreach($cur_rate as $key=>$value)
            {
                $step++;
                $span=Html::tag('span','1 '.$key.' = ').Html::tag('span',$value['rate'],['id'=>'span-'.$key]).Html::tag('span',' '.Yii::$app->user->identity->local_cur);
                $td.=Html::tag('td',$span,['id'=>$key,'title'=>"Курс установлен ".$value['date']]);               
                if (($step % 2) == 0)
                {
                  $trs.=Html::tag('tr',$td);
                  $td=null;
                }
                if($step==count($cur_rate) && $td!=null)
                {
                  $trs.=Html::tag('tr',$td);
                  $td=null; 
                }                
            }
            $table=Html::tag('table',$trs,['class'=>'cur-rate-table','id'=>'cur-rate-table']);
            return Html::tag('div',$table,['class'=>'cur-rate-wraper']);
         } 
          else
          {
          foreach($cur_rate as $key=>$value)
          {
            $span=Html::tag('span','1 '.$key.' = ').Html::tag('span',$value['rate'],['id'=>'span-'.$key]).Html::tag('span',' '.Yii::$app->user->identity->local_cur);
            $td=Html::tag('td',$span,['id'=>$key,'title'=>"Курс установлен ".$value['date']]);
            $trs.=Html::tag('tr',$td);
          }
          $table=Html::tag('table',$trs,['class'=>'cur-rate-table','id'=>'cur-rate-table']);
          return Html::tag('div',$table,['class'=>'cur-rate-wraper']);
          }
    }
  }  
    
    
?>