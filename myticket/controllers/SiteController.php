<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FastViewForm;
use app\models\FastEditForm;
use app\models\MathFunctions;
use app\models\TicketEditForm;
use app\models\AddRecordForm;
use app\models\ExportExcel;
use app\models\FilterTicketsForm;
use app\models\FilterAgentsReportsForm;
use app\models\FilterAviacompaniesReportsForm;
use app\models\Dal;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
     public function actionPaymentsCarriers()
    {
       if(Yii::$app->request->post('action')=='add_pay')
        { 
           $dal=new Dal();          
           $id_car = Yii::$app->request->post('id_car'); 
           $input_pay = Yii::$app->request->post('input_pay'); 
           $input_date = Yii::$app->request->post('input_date'); 
           $text_note = Yii::$app->request->post('text_note'); 
           $pay_method = Yii::$app->request->post('pay_method'); 
           
           if($dal->insertCarriersPayment($id_car,$input_pay,$input_date,$text_note,$pay_method))
              return \yii\helpers\Json::encode(['status'=>'success','msg' =>'Данные успешно сохранены']);
            else
              return \yii\helpers\Json::encode(['status'=>'error','msg' =>'ошибка при сохранении']);
        }
        else if(Yii::$app->request->post('action')=='search_payments')
        { 
           $dal=new Dal();          
           $date_start_pay = Yii::$app->request->post('date_start_pay'); 
           $date_end_pay = Yii::$app->request->post('date_end_pay'); 
           $car_id_filter = Yii::$app->request->post('car_id_filter');
           $payments= $dal->getHistoryCarPayments($date_start_pay,$date_end_pay,$car_id_filter);
           return \yii\helpers\Json::encode(['status' =>'success','total'=>count($payments),'result' =>$this->renderAjax('table_payments_carriers',['payments'=>$payments])]);
        } 
         else if(Yii::$app->request->post('action')=='remove_car_pay')
        { 
            $dal=new Dal();
            $dal->removeCarPay(Yii::$app->request->post('pay_id'));
            return \yii\helpers\Json::encode(['status'=>'success','id' =>Yii::$app->request->post('pay_id')]);
        }
        else if(Yii::$app->request->post('action')=='car_pay_edit_action')
        {
           $dal=new Dal();
           $pay_id = Yii::$app->request->post('pay_id'); 
           $input_pay = Yii::$app->request->post('input_pay');  
           $expense_date = Yii::$app->request->post('expense_date'); 
           $note = Yii::$app->request->post('note'); 
           $pay_met = Yii::$app->request->post('pay_met'); 
           $time = Yii::$app->request->post('time'); 
           
           if (preg_match("/(\d{4}-\d{2}-\d{2})/i", $expense_date,$matches)) {
              $expense_date=$matches[1].' '.$time;
           } else {
               $expense_date=date('Y-m-d H:i:s');
           }
           $name_met=$dal->getPaymentMethodById($pay_met);
           $dal->updateCarPayData($pay_id,$input_pay,$expense_date,$note,$pay_met);
           return \yii\helpers\Json::encode(['status'=>'success','id' =>$pay_id,'input_pay'=>$input_pay,'expense_date'=>$expense_date,'note'=>$note,'name_met'=>$name_met['method'],'method_id'=>$pay_met]);
        }
          
       $dal=new Dal(); 
       $payments= $dal->getHistoryCarPayments(date('Y-m-01'),date('Y-m-d'),'');
       $carriers=$dal->getCarriers(); 
       $payment_methods= $dal->getPaymentMethod();
       return $this->render('payments_carriers',['carriers'=>$carriers,'payments'=>$payments,'payment_methods'=>$payment_methods]);
    }
     public function actionPayments()
    {
        if (Yii::$app->request->post() && Yii::$app->request->post('action')=='add_new')
        {
            $vowels = array("'", '"', "/","\\","%"); 
            $name= Yii::$app->request->post('name');
            $name= mb_strtoupper(str_replace($vowels,"",$name),"utf-8");         
            $dal=new Dal();
            if($dal->insertPayments($name))
            {
              $payments=$dal->getPaymentsByView(); 
              return \yii\helpers\Json::encode(['status' =>'success','result' =>$this->renderAjax('table_payments',['payments'=>$payments])]);
            }
            return \yii\helpers\Json::encode(['status' =>'error','msg'=>'error']);   
            
        }
        else if(Yii::$app->request->post('action')=='remove_form_pay')
        {
            $id=Yii::$app->request->post('pay_id');
                if(strlen(trim($id)>0))
                {
                    $dal=new Dal();
                    $dal->removePayment($id);  
                    return \yii\helpers\Json::encode(['status'=>'success','id'=>$id]);                    
                }
                else
                {
                  return \yii\helpers\Json::encode(['status'=>'error','msg' =>'id оплаты не определен']);  
                }
        }
        else if(Yii::$app->request->post('action')=='edit_form_pay')
        {
            $id=Yii::$app->request->post('pay_id');
            $name=Yii::$app->request->post('name');
            $name= mb_strtoupper(str_replace($vowels,"",$name),"utf-8");
                if(strlen(trim($id)>0))
                {
                    $dal=new Dal();
                    $dal->updatePayment($id,$name);  
                    return \yii\helpers\Json::encode(['status'=>'success','id'=>$id,"name"=>$name]);                    
                }
                else
                {
                  return \yii\helpers\Json::encode(['status'=>'error','msg' =>'id оплаты не определен']);  
                }
        }
        
        
       $dal=new Dal(); 
       $payments=$dal->getPaymentsByView(); 
       return $this->render('form_of_payment',['payments'=>$payments]);
    }
     public function actionCarriers()
    {
        if (Yii::$app->request->post() && Yii::$app->request->post('action')=='add_new')
        {
            $vowels = array("'", '"', "/","\\","%"); 
            $name= Yii::$app->request->post('name');
            $name= mb_strtoupper(str_replace($vowels,"",$name),"utf-8");         
            $dal=new Dal();
            if($dal->insertCarrier($name))
            {
              $carriers=$dal->getCarrierByView(); 
              return \yii\helpers\Json::encode(['status' =>'success','result' =>$this->renderAjax('table_carriers',['carriers'=>$carriers])]);
            }
            return \yii\helpers\Json::encode(['status' =>'error','msg'=>'error']);   
            
        }
       $dal=new Dal(); 
       $carriers=$dal->getCarrierByView(); 
       return $this->render('carriers',['carriers'=>$carriers]);
    }
    public function actionPaymentsAgents()
    {
       if(Yii::$app->request->post('action')=='add_pay')
        { 
           $dal=new Dal();          
          // $name =mb_strtolower(trim(Yii::$app->request->post('name')),"UTF-8") ; 
           $name_id = Yii::$app->request->post('name_id'); 
           $input_pay = Yii::$app->request->post('input_pay'); 
           $input_expense = Yii::$app->request->post('input_expense'); 
           $expense_date = Yii::$app->request->post('expense_date'); 
           
           $text_note = Yii::$app->request->post('text_note'); 
           $pay_method = Yii::$app->request->post('pay_method'); 
           
           if($dal->insertAgentExpense($name_id,$input_pay,$input_expense,$expense_date,$text_note,$pay_method))
              return \yii\helpers\Json::encode(['status'=>'success','msg' =>'Данные успешно сохранены']);
            else
              return \yii\helpers\Json::encode(['status'=>'error','msg' =>'ошибка при сохранении']);
          
        }
        else if(Yii::$app->request->post('action')=='search_payments')
        { 
           $dal=new Dal();          
           $date_start_pay = Yii::$app->request->post('date_start_pay'); 
           $date_end_pay = Yii::$app->request->post('date_end_pay'); 
           $agent_id_filter = Yii::$app->request->post('agent_id_filter');
           $payments= $dal->getHistoryAgentsPayments($date_start_pay,$date_end_pay,$agent_id_filter);
           return \yii\helpers\Json::encode(['status' =>'success','total'=>count($payments),'result' =>$this->renderAjax('table_expense_agents',['payments'=>$payments])]);
        }   
         else if(Yii::$app->request->post('action')=='remove_agent_pay')
        { 
            $dal=new Dal();
            $dal->removeAgentPay(Yii::$app->request->post('pay_id'));
            return \yii\helpers\Json::encode(['status'=>'success','id' =>Yii::$app->request->post('pay_id')]);
        }
        else if(Yii::$app->request->post('action')=='agent_pay_edit_action')
        {
           $dal=new Dal();
           $pay_id = Yii::$app->request->post('pay_id'); 
           $input_pay = Yii::$app->request->post('input_pay'); 
           $input_expense = Yii::$app->request->post('input_expense'); 
           $expense_date = Yii::$app->request->post('expense_date'); 
           $note = Yii::$app->request->post('note'); 
           $pay_met = Yii::$app->request->post('pay_met'); 
           $time = Yii::$app->request->post('time'); 
           
           
           
           if (preg_match("/(\d{4}-\d{2}-\d{2})/i", $expense_date,$matches)) {
              $expense_date=$matches[1].' '.$time;
           } else {
               $expense_date=date('Y-m-d H:i:s');
           }
           $dal->updateAgentPayData($pay_id,$input_pay,$input_expense,$expense_date,$note,$pay_met);
           $name_met=$dal->getPaymentMethodById($pay_met);
           return \yii\helpers\Json::encode(['status'=>'success','id' =>$pay_id,'input_pay'=>$input_pay,'input_expense'=>$input_expense,'expense_date'=>$expense_date,'note'=>$note,'name_met'=>$name_met['method'],'method_id'=>$pay_met]);
        }
           
       $dal=new Dal(); 
       $agents_filter = $dal->getAgent(false);   
       $payments= $dal->getHistoryAgentsPayments(date('Y-m-01'),date('Y-m-d'),'');
       $payment_methods= $dal->getPaymentMethod();
       $agents=$dal->getAgentsForAutoComplete(); 
       return $this->render('expense_agents',['agents'=>$agents,'agents_filter'=>$agents_filter,'payments'=>$payments,'payment_methods'=>$payment_methods]);
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
     public function actionMain()
    {
        if (Yii::$app->user->isGuest) {
           return $this->redirect('index');
        }        
       return $this->render('fast_edit');
    }
     public function actionReports()
    {      
       return $this->render('main_reports');
    }
    public function actionAgents()
    { 
         if(Yii::$app->request->post())
         {
             if(Yii::$app->request->post('action')=='add_new_agent')
             { 
                $vowels = array("'", '"', "/","\\","%");
                $name=Yii::$app->request->post('name');
                if(strlen(trim($name))==0)
                 return \yii\helpers\Json::encode(['status' =>'error','msg'=>'введите имя']);
                $temp_test= mb_strtolower(trim($name),"UTF-8");
                if($temp_test=='admin' || $temp_test=='админ')
                  return \yii\helpers\Json::encode(['status' =>'error','msg'=>'Запрещено использовать имя Admin']); 
                 
                $sine=Yii::$app->request->post('sine');
                $name=mb_strtoupper(str_replace($vowels,"",$name),"utf-8");
                $sine=mb_strtoupper(str_replace($vowels,"",$sine),"utf-8");
                $dal=new Dal();
                if($dal->insertNewAgent($name,$sine))
                {
                     $agents=$dal->getAgentsByView(); 
                     if(count($agents)>0)
                        $flag='1';
                      else
                        $flag='0';   
                     return \yii\helpers\Json::encode(['status'=>'success','add_btn_show'=>$flag,'result' =>$this->renderAjax('table-agents-view',['agents'=>$agents])]);
                }
                else
                {
                     return \yii\helpers\Json::encode(['status'=>'error','msg' =>'ошибка при добавлении записи']);
                }
             }
             else if(Yii::$app->request->post('action')=='update_agent')
              {
                $id=Yii::$app->request->post('agent_id');
                if(strlen(trim($id)>0))
                {
                    $vowels = array("'", '"', "/","\\","%");
                    $name=Yii::$app->request->post('name');
                    if(strlen(trim($name))==0)
                      return \yii\helpers\Json::encode(['status' =>'error','msg'=>'введите имя']);
                    $temp_test= mb_strtolower(trim($name),"UTF-8");
                    if($temp_test=='admin' || $temp_test=='админ')
                    return \yii\helpers\Json::encode(['status' =>'error','msg'=>'Запрещено использовать имя Admin']); 
                    $sine=Yii::$app->request->post('sine');
                    $name=mb_strtoupper(str_replace($vowels,"",$name),"utf-8");
                    $sine=mb_strtoupper(str_replace($vowels,"",$sine),"utf-8");
                    $dal=new Dal();
                    $dal->updateAgentData($id,$name,$sine);  
                    $agents=$dal->getAgentsByView();  
                    return \yii\helpers\Json::encode(['status'=>'success','result' =>$this->renderAjax('table-agents-view',['agents'=>$agents])]);
                    
                 }
               }
              else if(Yii::$app->request->post('action')=='remove_agent')
              {
                $id=Yii::$app->request->post('agent_id');
                if(strlen(trim($id)>0))
                {
                    $dal=new Dal();
                    $dal->removeAgent($id);  
                    $agents=$dal->getAgentsByView();  
                    if(count($agents)>0)
                        $flag='1';
                      else
                        $flag='0';  
                    return \yii\helpers\Json::encode(['status'=>'success','add_btn_show'=>$flag,'result' =>$this->renderAjax('table-agents-view',['agents'=>$agents])]);                    
                }
                else
                {
                  return \yii\helpers\Json::encode(['status'=>'error','msg' =>'id кассира не определен']);  
                }
              }                        
             else
                {
                   return \yii\helpers\Json::encode(['status'=>'error','msg' =>'ошибка в запросе']); 
                }
        }
        $dal=new Dal();
        $agents=$dal->getAgentsByView();        
        return $this->render('agents_viewr',['agents'=>$agents]);
    }
    public function actionAddRecord()
    {
      if (!\Yii::$app->user->isGuest) {
        if(Yii::$app->request->post('actions')=='add_new_record')
        {
          $edit_model= new TicketEditForm();
          if ($edit_model->load(Yii::$app->request->post())&& $edit_model->validate())
          {  
          $dal=new Dal();
          $type_id=$edit_model->type;
          $carrier_name=$dal->getCarrierById($edit_model->type);
          $edit_model->type=$carrier_name['name'];
          $math=new MathFunctions();
          $ticket=array();
          $ticket= $math->setAllTicketData($ticket,$edit_model);
          $ticket['ID_CARRIER']=$type_id;
          $id=$dal->insertTicket($ticket);
          return $this->redirect('/ticket-details/'.$id);
          } 
        }
        else
        {
            $dal=new Dal();
            $agents = $dal->getAgent();
            $carriers=$dal->getCarriers();
            $edit_model= new TicketEditForm();
            return $this->render('add_record',['edit_model'=>$edit_model,'agents'=>$agents,'carriers'=>$carriers]);
        }
        }
        return $this->redirect(['/index']);
    }
    public function actionTickets()
    { 
         $vowels = array("'", '"', "/","\\","%");
         $filter_model=new FilterTicketsForm();
         $session = Yii::$app->session;
         if ($session->has('filter_arr'))
         {
            $filter_arr=$session['filter_arr'];
         }
         else
         {
            $session['filter_arr'] = new \ArrayObject;
            $session['filter_arr']['first_period'] = "";
            $session['filter_arr']['second_period'] = "";
            $session['filter_arr']['responsible'] = "";
            $session['filter_arr']['val_car'] = "";
            $session['filter_arr']['procedure'] = "";
            $session['filter_arr']['pnr_ticket_pax'] = "";
            $filter_arr=$session['filter_arr'];
         }
        if(Yii::$app->request->post('actions')=='excel_export' )
        { 
            $dal=new Dal();
            $tickets=$dal->getTicketsForExcel($filter_arr);
            $excel= new ExportExcel();
            $date_start_pay=date("Y-m-01");
            $date_end_pay=date('Y-m-d', strtotime(date("Y-m-d").' +1 day'));
            if($filter_arr['first_period']!="" && $filter_arr['second_period']!="")
             {
             $date_start_pay=$filter_arr['first_period'];
             $date_end_pay=date('Y-m-d', strtotime($filter_arr['second_period'] . ' +1 day'));
             }
             else if($filter_arr['first_period']!="")
               $date_start_pay=$filter_arr['first_period'];
             
            $payments= $dal->getHistoryAgentsPayments($date_start_pay,$date_end_pay,"");
            $method=new MathFunctions();
            $paymentsAsocArr=$method->getPaymentsAsocArr($payments);
            $excel->export($tickets,$paymentsAsocArr,$filter_arr,Yii::$app->user->identity->hide_fees_pegasus);
        }
        else
        {
         if(Yii::$app->request->post('actions')=='filters_details' && $filter_model->load(Yii::$app->request->post()))
         {
            $filter_arr['first_period'] = str_replace($vowels,"",trim($filter_model->first_period));
            $filter_arr['second_period'] = str_replace($vowels,"",trim($filter_model->second_period));
            $filter_arr['responsible'] =str_replace($vowels,"",trim($filter_model->responsible));
            $filter_arr['val_car'] = str_replace($vowels,"",trim($filter_model->val_car));
            $filter_arr['procedure'] = str_replace($vowels,"",trim($filter_model->procedure));
            $filter_arr['pnr_ticket_pax'] = str_replace($vowels,"",trim($filter_model->pnr_ticket_pax));
            $session['filter_arr'] = $filter_arr;
         }
        
        $dal=new Dal();
        $agents = $dal->getAgent();   
        $carriers=$dal->getCarriers();    
        $count=$dal->getAllRows($filter_arr);
        $pagination = new Pagination(['defaultPageSize'=>15,'totalCount'=>$count]);
        $tickets=$dal->getAllTicketsFilters($pagination->offset,$pagination->limit,$filter_arr);
        return $this->render('tickets',['tickets'=>$tickets,'pagination'=>$pagination,'filter_model'=>$filter_model,'agents'=>$agents,'filter_arr'=>$filter_arr,'carriers'=>$carriers]); 
       }
    }
    
     public function actionTicketDetails($record)
     {
         if (!\Yii::$app->user->isGuest) {
            if(Yii::$app->request->post('actions')=='update_all_data_airfile')
             {
                $edit_model=new TicketEditForm();
                if ($edit_model->load(Yii::$app->request->post())&& $edit_model->validate())
                {
                  $dal=new Dal();
                  $ticket=$dal->getTicketByID($edit_model->record,['*']);
                  if($ticket)
                  {
                    if($ticket["STATUS"]==$edit_model->status)
                    {
                       $math=new MathFunctions();
                       $type_id=$edit_model->type;
                       $carrier_name=$dal->getCarrierById($edit_model->type);
                       $edit_model->type=$carrier_name['name'];
                       $ticket= $math->setAllTicketData($ticket,$edit_model);
                       $ticket['ID_CARRIER']=$type_id;
                       $dal->updateTicket($ticket);
                       $ticket=$dal->getTicketByID($edit_model->record,['*']);
                       $carriers=$dal->getCarriers(); 
                       $agents = $dal->getAgent();
                       return $this->render('ticket-details',['edit_model'=>$edit_model,'ticket'=>$ticket,'agents'=>$agents,'carriers'=>$carriers]);
                    }
                    else if ($edit_model->status=="VOIDED" &&($ticket["STATUS"]=="ISSUED" || $ticket["STATUS"]=="REISSUED" ))
                    {
                       $math=new MathFunctions();
                       $type_id=$edit_model->type;
                       $carrier_name=$dal->getCarrierById($edit_model->type);
                       $edit_model->type=$carrier_name['name'];                      
                       $ticket= $math->setAllTicketData($ticket,$edit_model);
                       $ticket['ID_CARRIER']=$type_id;
                       $dal->updateTicket($ticket);
                       $ticket=$dal->getTicketByID($edit_model->record,['*']);
                       $agents = $dal->getAgent();
                       $carriers=$dal->getCarriers(); 
                       return $this->render('ticket-details',['edit_model'=>$edit_model,'ticket'=>$ticket,'agents'=>$agents,'carriers'=>$carriers]);  
                    }
                    else
                    {
                      $math=new MathFunctions();
                      $type_id=$edit_model->type;
                      $carrier_name=$dal->getCarrierById($edit_model->type);
                      $edit_model->type=$carrier_name['name'];
                      $ticket= $math->setAllTicketData($ticket,$edit_model);  
                      $ticket['ID_CARRIER']=$type_id;
                      $id=$dal->insertTicket($ticket);
                     // $ticket=$dal->getTicketByID($id,['*']);
                      //$agents = $dal->getAgent();
                      //return $this->render('ticket-details',['edit_model'=>$edit_model,'ticket'=>$ticket,'agents'=>$agents]); 
                       return $this->redirect('/ticket-details/'.$id);
                    }
                  }
                  else
                   return \yii\helpers\Json::encode(['status'=>'error data']);
                }
                else
                  return \yii\helpers\Json::encode(['status'=>'error data']);
             }
             else if(Yii::$app->request->post('action')=='remove_ticket')
             {
                $dal=new Dal();
                $dal->removeTicket($record);
                $doc_num=Yii::$app->request->post('doc_num');
                return \yii\helpers\Json::encode(['status' =>'success','result'=>"<div style='width: 400px;font-size: 19px;margin: 90px auto;font-family: &quot;ProximaNova Light&quot;, sans-serif;text-align: center;'><span>Билет ".$doc_num." успешно удален</span></div>"]);
                
             }
            else{            
            $dal=new Dal();
            $ticket=$dal->getTicketByID($record,['*']);
            if($ticket)
            {
               $fonumber_id=""; 
               if(strlen(trim($ticket['FO_NUMBER']))>0)
                 {
                    $fo_ticket=$dal->getTicketByTicketNum($ticket['FO_NUMBER'],['ID']);
                    $fonumber_id=$fo_ticket["ID"];
                 }
               $carriers=$dal->getCarriers();  
               $agents = $dal->getAgent();
               $edit_model= new TicketEditForm();
               return $this->render('ticket-details',['edit_model'=>$edit_model,'ticket'=>$ticket,'agents'=>$agents,'fonumber_id'=>$fonumber_id,'carriers'=>$carriers]);
            }
            else
             return $this->render('error');
          }
         }
         return $this->redirect(['/index']);
        
        }
    public function actionActionTickets()
    {
        if (!\Yii::$app->user->isGuest) {
            $search_model=new FastViewForm();
            if (Yii::$app->request->post('actions')=='get_airfile_list' && $search_model->load(Yii::$app->request->post())&& $search_model->validate())
             {
                $dal=new Dal();
                $tickets = $dal->getFastViewTickets($search_model->period,$search_model->search_word);
                return \yii\helpers\Json::encode(['status'=>'success','count'=>count($tickets), 'result' =>$this->renderAjax('fast_edit_tickets_table',['tickets'=>$tickets])]);
             }
             else if(Yii::$app->request->post('actions')=='update_airfile')
             {
                $edit_model=new FastEditForm();
                $math=new MathFunctions();
                if($edit_model->load(Yii::$app->request->post())&& $edit_model->validate() && strlen(Yii::$app->request->post('ticket-id'))>0)
                {
                   $dal=new Dal();
                   $ticket=$dal->getTicketByID(Yii::$app->request->post('ticket-id'),['TAXES_TOTAL','CANCELLATION_FEE','STATUS','ID','TOTAL','TOTAL_CAR','TOTAL_TST','FARE','RESPONSIBLE','SERVICE_FEE','COMMISSION','COMMISSION_AMOUNT','DISCOUNT','DISCOUNT_AMOUNT','CURRENCY','CURRENCY_RATE','TYPE','FARE_PEGASUS']);
                   if($ticket)
                   {
                    /* if(strtolower($ticket['CURRENCY'])!=strtolower($edit_model->cur) && trim($edit_model->cur_rate)!="")
                     {
                       $ticket= $math->setTicketDataWithCurrencyRate($ticket,$edit_model,false); 
                       if($ticket['RESPONSIBLE']=='admin')
                          $agent='ADMIN';
                        else
                          $agent=$dal->getAgentById($ticket['RESPONSIBLE']);
                       if($dal->updateTicket($ticket))   
                       return \yii\helpers\Json::encode(['status'=>'success','ticket'=>['id'=>$ticket['ID'],'agent'=>$agent,'total'=>$ticket['TOTAL'],'responce'=>$ticket['RESPONSIBLE'],'sf'=> $ticket["SERVICE_FEE"],'fm'=>$ticket["COMMISSION"],'dis'=>$ticket["DISCOUNT"],'cur'=>$ticket["CURRENCY"],'cur_rate'=>$ticket["CURRENCY_RATE"]]]); 
                     
                     }
                     else*/
                     if(strtolower($ticket['CURRENCY'])==strtolower($edit_model->cur) && trim($edit_model->cur_rate)!="" && $ticket['CURRENCY_RATE']!=$edit_model->cur_rate)
                     {
                       $ticket= $math->setTicketDataWithCurrencyRate($ticket,$edit_model,true); 
                       if($ticket['RESPONSIBLE']=='admin')
                          $agent='ADMIN';
                        else
                          $agent=$dal->getAgentById($ticket['RESPONSIBLE']);
                       if($dal->updateTicket($ticket))   
                       return \yii\helpers\Json::encode(['status'=>'success','ticket'=>['id'=>$ticket['ID'],'agent'=>$agent,'total'=>$ticket['TOTAL'],'responce'=>$ticket['RESPONSIBLE'],'sf'=> $ticket["SERVICE_FEE"],'fm'=>$ticket["COMMISSION"],'dis'=>$ticket["DISCOUNT"],'cur'=>$ticket["CURRENCY"],'cur_rate'=>$ticket["CURRENCY_RATE"]]]); 
                     
                     }
                     else
                     {
                        $ticket= $math->setTicketData($ticket,$edit_model);  
                        if($ticket['RESPONSIBLE']=='admin')
                          $agent='ADMIN';
                        else
                          $agent=$dal->getAgentById($ticket['RESPONSIBLE']);
                        if($dal->updateTicket($ticket))                 
                        return \yii\helpers\Json::encode(['status'=>'success','ticket'=>['id'=>$ticket['ID'],'agent'=>$agent,'total'=>$ticket['TOTAL'],'responce'=>$ticket['RESPONSIBLE'],'sf'=> $ticket["SERVICE_FEE"],'fm'=>$ticket["COMMISSION"],'dis'=>$ticket["DISCOUNT"],'cur'=>$ticket["CURRENCY"],'cur_rate'=>$ticket["CURRENCY_RATE"]]]); 
                      }
                     return \yii\helpers\Json::encode(['status'=>'error','msg'=>'Ошибка при обновлении данных']);   
                   }
                   return \yii\helpers\Json::encode(['status'=>'error','msg'=>'Билет не найдей']); 
                  
                }
                 return \yii\helpers\Json::encode(['status'=>'error','msg'=>'Данные не прошли валидацию']); 
             }                        
             else
             {
                return \yii\helpers\Json::encode(['status'=>'error data']);
             }
         }
         else
         return $this->redirect(['/index']);
    }
    public function actionIndex()
    {
               
     if (!\Yii::$app->user->isGuest) {
          $dal=new Dal();
          $tickets = $dal->getFastViewTickets();
          $agents = $dal->getAgent();
          $search_model=new FastViewForm();   
          $edit_model=new FastEditForm();     
          return $this->render('fast_edit',['search_model'=>$search_model,'edit_model'=>$edit_model,'agents'=>$agents,'tickets'=>$tickets]);
        }
     else
       {
           $model = new LoginForm();
            if (Yii::$app->request->post())
            {
               if ($model->load(Yii::$app->request->post()) && $model->login()) {
                        return $this->redirect('');
                     }
                else
                  return \yii\helpers\Json::encode(['msg' =>'Неправельный логин или пароль']);
            }
            return $this->render('index',['model'=>$model]);
       }
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
   public function actionCurrencyRate()
    {  
          if (Yii::$app->request->post() && Yii::$app->request->post('action')=='update')
          {
            $from_cur= Yii::$app->request->post('cur');
            $rate= Yii::$app->request->post('cur_rate');
            if(strlen(trim($from_cur))==0 || strlen(trim($rate))==0)
              return \yii\helpers\Json::encode(['status' =>'error','msg'=>'неверный формат']); 
            $rate=str_replace(",",".",$rate);
            $dal=new Dal();
            if($dal->insertCurRate($from_cur,$rate))
              return \yii\helpers\Json::encode(['status' =>'success','rate'=>$rate,'cur'=>$from_cur]);
            return \yii\helpers\Json::encode(['status' =>'error','msg'=>'error currency rate is not updated']);   
            
          }
        return \yii\helpers\Json::encode(['status' =>'error','msg'=>'actions error']);
    }
   public function actionAgentsReports()
    {
        if (!\Yii::$app->user->isGuest) 
        {
            $dal=new Dal();
            $filter_model=new FilterAgentsReportsForm;
            $filter_arr = array('first_period'=>'', 'second_period'=>'', 'responsible'=>'');
            if ($filter_model->load(Yii::$app->request->post()))
            {
                $vowels = array("'", '"', "/","\\","%");
                $filter_arr['first_period'] = str_replace($vowels,"",trim($filter_model->first_period));
                $filter_arr['second_period'] = str_replace($vowels,"",trim($filter_model->second_period));
                $filter_arr['responsible'] = str_replace($vowels,"",trim($filter_model->responsible));
            }
            
            if(Yii::$app->request->post('actions')=='excel_export' )
            { 
                $dal=new Dal();
                $tickets=$dal->getAgentsReports($filter_arr);
                $excel= new ExportExcel();
                $excel->exportAgentsReports($tickets,$filter_arr);
            }
            else
            {
                $agents = $dal->getAgent();
                $tickets=$dal->getAgentsReports($filter_arr);
                return $this->render('agentsReports',['tickets'=>$tickets, 'agents' => $agents, 'filter_arr' => $filter_arr, 'filter_model' => $filter_model]);
            }
        }
        else
            return $this->redirect(['/index']);
    }
    
    public function actionAviacompaniesReports()
    {
        if (!\Yii::$app->user->isGuest) 
        {
            $dal=new Dal();
            $filter_model=new FilterAviacompaniesReportsForm;
            $filter_arr = array('first_period'=>'', 'second_period'=>'', 'aviacompany'=>'');
            if ($filter_model->load(Yii::$app->request->post()))
            {
                $vowels = array("'", '"', "/","\\","%");
                $filter_arr['first_period'] = str_replace($vowels,"",trim($filter_model->first_period));
                $filter_arr['second_period'] = str_replace($vowels,"",trim($filter_model->second_period));
                $filter_arr['aviacompany'] = str_replace($vowels,"",trim($filter_model->aviacompany));
            }
            if(Yii::$app->request->post('actions')=='excel_export' )
            { 
                $dal=new Dal();
                $tickets=$dal->getAviacompaniesReports($filter_arr);
                $excel= new ExportExcel();
                $excel->exportAviacompaniesReports($tickets,$filter_arr);
            }
            else
            {
                $tickets=$dal->getAviacompaniesReports($filter_arr);
                $aviacompanies = $dal->getAviacompanies();
                return $this->render('aviacompaniesReports', ['tickets'=>$tickets, 'aviacompanies'=>$aviacompanies, 'filter_arr' => $filter_arr, 'filter_model' => $filter_model]);
            }
        }
        else
            return $this->redirect(['/index']);
    }
   
}
