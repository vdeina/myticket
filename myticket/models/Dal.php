<?php
namespace app\models;
use yii\db\Query;
use Yii;
class Dal
 {
    public $table_pref="bm_";
    
    public function  removePayment($id)
     {     
       $value['is_deleted']='1';     
       $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref."payment_method",$value, 
       'id ='.$id)->execute(); 
       return true;
     }    
      public function  updatePayment($id,$name)
     {     
       $value['method']=$name;     
       $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref."payment_method",$value, 
       'id ='.$id)->execute(); 
       return true;
     }   
     
    public function  removeAgent($id)
     {     
       $value['is_deleted']='1';     
       $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref."agents",$value, 
       'id_agent ='.$id)->execute(); 
       return true;
     }
     public function  removeTicket($id)
     {       
       $affected_rows =Yii::$app->db->createCommand()->delete($this->table_pref.Yii::$app->user->identity->db_name, ['ID' =>$id ])->execute();
       return true;
     }
      public function  removeCarPay($id)
     {       
       $affected_rows =Yii::$app->db->createCommand()->delete($this->table_pref.'carriers_payments', ['id' =>$id ])->execute();
       return true;
     }
     public function  removeAgentPay($id)
     {       
       $affected_rows =Yii::$app->db->createCommand()->delete($this->table_pref.'agents_payments', ['id' =>$id ])->execute();
       return true;
     }
       public function  insertCarrier($name)
     {     
       $affected_rows =Yii::$app->db->createCommand()->insert($this->table_pref.'carriers',['name'=>$name,'db_name'=>Yii::$app->user->identity->db_name])->execute(); 
       if($affected_rows>0)
          return true;
       return false;  
     }
    public function  updateAgentPayData($id,$input_pay,$input_expense,$expense_date,$note,$pay_met)
     { 
        if(trim($input_pay)=="")
           $input_pay='0';
        if(trim($input_expense)=="")
           $input_expense='0';    
       $value=array();
       $value['value_pay']=$input_pay;
       $value['value_exp']=$input_expense;     
       $value['date']=$expense_date;      
       $value['text']=$note; 
       $value['payment_method_id']=$pay_met;      
       $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref."agents_payments",$value, 
       'id ='.$id)->execute(); 
       return true;
     }
      public function  updateCarPayData($id,$input_pay,$expense_date,$note,$pay_met)
     { 
        if(trim($input_pay)=="")
           $input_pay='0';
        if(trim($input_expense)=="")
           $input_expense='0';    
       $value=array();
       $value['value_pay']=$input_pay;    
       $value['date']=$expense_date;      
       $value['text']=$note;
       $value['payment_method_id']=$pay_met;     
       $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref."carriers_payments",$value, 
       'id ='.$id)->execute(); 
       return true;
     }
     
     
    public function  updateAgentData($id,$name,$sine)
     {     
       $value=array();
       $value['name']=$name;
       $value['sine']=$sine;       
       $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref."agents",$value, 
       'id_agent ='.$id)->execute(); 
       return true;
     }
     
      public function  insertCarriersPayment($id_car,$input_pay,$input_date,$text_note,$pay_method)
     {   
      if(trim($input_pay)=="")
           $input_pay='0';    
       $affected_rows =Yii::$app->db->createCommand()->insert($this->table_pref.'carriers_payments',['idc'=>$id_car,'value_pay'=>$input_pay,'text'=>$text_note,'payment_method_id'=>$pay_method, 'date'=>$input_date.' '.date("H:i:s"),'db_name'=>Yii::$app->user->identity->db_name])->execute(); 
       if($affected_rows>0)
          return true;
       return false;  
     }
      public function  insertAgentExpense($name_id,$input_pay,$input_expense,$expense_date,$text_note,$pay_method)
     {   
        if(trim($input_pay)=="")
           $input_pay='0';
        if(trim($input_expense)=="")
           $input_expense='0';  
       $affected_rows =Yii::$app->db->createCommand()->insert($this->table_pref.'agents_payments',['ida'=>$name_id, 'value_exp'=>$input_expense,'value_pay'=>$input_pay, 'date'=>$expense_date.' '.date("H:i:s"),'db_name'=>Yii::$app->user->identity->db_name,'text'=>$text_note,'payment_method_id'=>$pay_method])->execute(); 
       if($affected_rows>0)
          return true;
       return false;  
     }
   /*  public function  insertAgentExpense($odj)
     {   
       $arr_expense=array();
       foreach($odj as $value)
       {
          $expense = array($value->id_agent, $value->expense_input, $value->pay_input,$value->expense_date,Yii::$app->user->identity->db_name);
          array_push($arr_expense,$expense);
       }
        
       $affected_rows =Yii::$app->db->createCommand()->batchInsert($this->table_pref.'agents_payments',['ida', 'value_exp','value_pay', 'date','db_name'],$arr_expense)->execute(); 
       if($affected_rows>0)
          return true;
       return false;  
     }*/
     public function  insertNewAgent($name,$sine)
     {     
       $affected_rows =Yii::$app->db->createCommand()->insert($this->table_pref.'agents',['name'=>$name,'sine'=>$sine,'db_name'=>Yii::$app->user->identity->db_name,'datetime'=>date('Y-m-d H:i:s'),'is_deleted'=>'0'])->execute(); 
       if($affected_rows>0)
          return true;
       return false;  
     }
      public function  insertCurRate($from_cur,$rate)
     {     
       $affected_rows =Yii::$app->db->createCommand()->insert($this->table_pref.'currency_rate',['from_cur'=>$from_cur,'rate'=>$rate,'db_name'=>Yii::$app->user->identity->db_name,'update_date'=>date('Y-m-d H:i:s')])->execute(); 
       if($affected_rows>0)
          return true;
       return false;  
     }
     public function getCarrierById($id)
    { 
        $query=new Query();
            $query->addSelect(['name'])
            ->from ($this->table_pref.'carriers')
            ->where(['id'=>$id]);
       return $query->one();
    }
   public function getPaymentMethod()
    {
            $query=new Query();
            $query->addSelect(['id','method'])
            ->from ($this->table_pref.'payment_method')
             ->where(['db_name'=>Yii::$app->user->identity->db_name,'is_deleted'=>'0']);
       $methods=$query->all();
       $assoc_methods=array(); 
       foreach($methods as $key=>$method)
       {  
            $assoc_methods[$method['id']]=$method['method'];
       }
       return $assoc_methods;
    }
     public function  insertPayments($name)
     {     
       $affected_rows =Yii::$app->db->createCommand()->insert($this->table_pref.'payment_method',['method'=>$name,'db_name'=>Yii::$app->user->identity->db_name])->execute(); 
       if($affected_rows>0)
          return true;
       return false;  
     }
     public function getPaymentsByView()
    { 
        $query=new Query();
            $query->addSelect(['id','method'])
            ->from ($this->table_pref.'payment_method')
            ->where(['db_name'=>Yii::$app->user->identity->db_name,'is_deleted'=>'0'])
            ->orderBy([
                       'id'=>SORT_DESC,
                    ]);
       return $query->all();
    }
    public function getPaymentMethodById($id)
    {
            $query=new Query();
            $query->addSelect(['method'])
            ->from ($this->table_pref.'payment_method')
            ->where('id='.$id); 
            return $query->one();
 
    }
    public function getCarriers()
    {
            $query=new Query();
            $query->addSelect(['id','name'])
            ->from ($this->table_pref.'carriers')
            ->where(['db_name'=>Yii::$app->user->identity->db_name])
            ->orderBy([
                       'id'=>SORT_DESC,
                    ]);
       $carriers=$query->all();
       $assoc_carriers=array(); 
       foreach($carriers as $key=>$carrier)
       {  
            $assoc_carriers[$carrier['id']]=$carrier['name'];
       }
       return $assoc_carriers;
    }
    public function getCurRate($currency)
     {
            $query=new Query();
            $query->addSelect(['from_cur','rate'])
            ->from ($this->table_pref.'currency_rate')
            ->where(['from_cur'=>$currency,'db_name'=>Yii::$app->user->identity->db_name])
            ->orderBy([
                       'id'=>SORT_DESC,
                    ]);
             $cur=$query->one(); 
     }
    public function getAllCurRate()
     {  
        $arr = array('USD','EUR','KZT','RUB');
         $cur_rate=array();
         foreach ($arr as $value) {
            $query=new Query();
            $query->addSelect(['rate','update_date'])
            ->from ($this->table_pref.'currency_rate')
            ->where(['from_cur'=>$value,'db_name'=>Yii::$app->user->identity->db_name])
            ->orderBy([
                       'id'=>SORT_DESC,
                    ]);
             $cur=$query->one(); 
             if($cur)
             {
               $cur_rate[$value]['rate']=$cur['rate'];
               $cur_rate[$value]['date']=$cur['update_date'];
             }
            
            }    
       return $cur_rate;  
     }
    public function getAgentsForAutoComplete()
    { 
        $query=new Query();
            $query->addSelect(['name as value','name as  label','id_agent as id'])
            ->from ($this->table_pref.'agents')
            ->where(['is_deleted'=>'0','db_name'=>Yii::$app->user->identity->db_name])
            ->orderBy([
                       'name'=>SORT_ASC,
                    ]);
       return $query->all();
    }
    public function getAgentsByView()
    { 
        $query=new Query();
            $query->addSelect(['id_agent','name','sine','datetime'])
            ->from ($this->table_pref.'agents')
            ->where(['is_deleted'=>'0','db_name'=>Yii::$app->user->identity->db_name])
            ->orderBy([
                       'name'=>SORT_ASC,
                    ]);
       return $query->all();
    }
    public function getCarrierByView()
    { 
        $query=new Query();
            $query->addSelect(['id','name'])
            ->from ($this->table_pref.'carriers')
            ->where(['db_name'=>Yii::$app->user->identity->db_name])
            ->orderBy([
                       'id'=>SORT_DESC,
                    ]);
       return $query->all();
    }
    public function getAgentById($id)
    {
            $query=new Query();
            $query->addSelect(['name'])
            ->from ($this->table_pref.'agents')
            ->where(['id_agent'=>$id,'is_deleted'=>'0','db_name'=>Yii::$app->user->identity->db_name]);
            $agents=$query->one();
            return $agents['name'];
    }
    public function getAgent($with_admin=true)
    {
        $query=new Query();
        $query->addSelect(['id_agent','name'])
        ->from ($this->table_pref.'agents')
        ->where(['is_deleted'=>'0','db_name'=>Yii::$app->user->identity->db_name])
        ->orderBy([
                   'name'=>SORT_ASC,
                ]);
       $agents=$query->all();
       if($with_admin)
       $assoc_agents=array('admin'=>'Admin'); 
       else
       $assoc_agents=array(); 
       foreach($agents as $key=>$agent)
       {  
            $assoc_agents[$agent['id_agent']]=$agent['name'];
       }
       return $assoc_agents;
    }
    
    public function getAviacompanies()
    {
        $query=new Query();
        $query->addSelect(['id','name'])
        ->from ($this->table_pref.'carriers')
        ->where(['db_name'=>Yii::$app->user->identity->db_name])
        ->orderBy([
                   'name'=>SORT_ASC,
                ]);
       $aivacompanies=$query->all();
       $assoc_aivacompanies=array(); 
       foreach($aivacompanies as $key=>$aivacompany)
       {  
            $assoc_aivacompanies[$aivacompany['id']]=$aivacompany['name'];
       }
       return $assoc_aivacompanies;
    }
     public function getHistoryCarPayments($date_start_pay,$date_end_pay,$car)
     {
        $e_date=date('Y-m-d', strtotime($date_end_pay . ' +1 day'));
        $query_str="date >'".$date_start_pay."' and date <'".$e_date."'";
        if($car!=="")
        $query_str.=" and 	idc='".$car."'";
        $query_str.=" and 	p.db_name='".Yii::$app->user->identity->db_name."'";
        $query=new Query();
            $query->addSelect(['c.name','p.idc','p.id','p.value_pay','p.date','p.text','ph.method','ph.id as method_id'])
            ->from ($this->table_pref.'carriers_payments p')
            ->leftJoin($this->table_pref.'carriers c','c.id = p.idc')
            ->leftJoin($this->table_pref.'payment_method ph','ph.id = p.payment_method_id')
            ->where($query_str)
            ->orderBy([
                       'date'=>SORT_DESC,
                    ])
           ->limit(310);
      return $query->all();
      
        
     }
    
     public function getHistoryAgentsPayments($date_start_pay,$date_end_pay,$agent)
     {
        $e_date=date('Y-m-d', strtotime($date_end_pay . ' +1 day'));
        $query_str="date >'".$date_start_pay."' and date <'".$e_date."'";
        if($agent!=="")
        $query_str.=" and 	ida='".$agent."'";
        $query_str.=" and 	p.db_name='".Yii::$app->user->identity->db_name."'";
        $query=new Query();
            $query->addSelect(['a.name','p.ida','p.id','p.value_pay','p.value_exp','p.date','p.text','ph.method','ph.id as method_id'])
            ->from ($this->table_pref.'agents_payments p')
            ->leftJoin($this->table_pref.'agents a','a.id_agent = p.ida')
            ->leftJoin($this->table_pref.'payment_method ph','ph.id = p.payment_method_id')
            ->where($query_str)
            ->orderBy([
                       'date'=>SORT_DESC,
                    ])
           ->limit(310);
      return $query->all();
      
        
     }
    public function getFastViewTickets($interval="",$search_word="")
    {
        $vowels = array("'", '"', "/","\\","%");
        $search_word=(str_replace($vowels,"",$search_word));
        if($interval=="" || $interval=="1")
         $interval= date('Y-m-d');
        else if ($interval=="2")
         $interval= date('Y-m-d',strtotime("-2 day"));
        else if ($interval=="3")
         $interval= date('Y-m-d',strtotime("-6 day"));
        else if ($interval=="4")
         $interval= date('Y-m-d',strtotime("-29 day"));
        $query_str="DOCUMENT_ISSUED>'".$interval."'";
        if($search_word!="")
        {
           $query_str.=" and (LAST_NAME like '%".$search_word."%' OR FIRST_NAME like '%".$search_word."%' OR RECORD_LOCATOR like '%".$search_word."%' OR DOCUMENT_NUMBER like '%".$search_word."%' OR VALIDATING_CARRIER like '%".$search_word."%')";            
        }
        $query=new Query();
            $query->addSelect(['ID','name','DOCUMENT_NUMBER','RECORD_LOCATOR','VALIDATING_CARRIER','LAST_NAME','FIRST_NAME','STATUS','DOCUMENT_ISSUED','TOTAL','RESPONSIBLE','SERVICE_FEE','COMMISSION','DISCOUNT','CURRENCY_RATE','CURRENCY','TYPE'])
            ->from ($this->table_pref.Yii::$app->user->identity->db_name.' t')
            ->leftJoin($this->table_pref.'agents a','a.id_agent = t.RESPONSIBLE')
            ->where($query_str)
            ->orderBy([
                       'DOCUMENT_ISSUED'=>SORT_DESC,
                    ]);
       $tickets=$query->all();
       return $tickets; 
    }
    
    
    public function getTicketByTicketNum($tic_num,array $selects)
     {
            $query=new Query();
            $query->addSelect($selects)
            ->from ($this->table_pref.Yii::$app->user->identity->db_name.' t')
            ->leftJoin($this->table_pref.'agents a','a.id_agent = t.RESPONSIBLE')
            ->where("t.DOCUMENT_NUMBER='".$tic_num."'");
            $ticket=$query->one();
            return $ticket;
     }
     public function getTicketByID($id,array $selects)
     {
            $query=new Query();
            $query->addSelect($selects)
            ->from ($this->table_pref.Yii::$app->user->identity->db_name.' t')
            ->leftJoin($this->table_pref.'agents a','a.id_agent = t.RESPONSIBLE')
            ->where("t.ID='".$id."'");
            $ticket=$query->one();
            return $ticket;
     }
     public function  insertTicket($ticket)
     {     
       $value=array();
       foreach ($ticket as $key => $val) {
         if($key!="ID" && $key!="name" && $key!="id_agent" && $key!="sine" && $key!="is_deleted" && $key!="db_name" && $key!='datetime')
         $value[$key]=$val; 
       }
       $affected_rows =Yii::$app->db->createCommand()->insert($this->table_pref.Yii::$app->user->identity->db_name,$value)->execute(); 
       $id = Yii::$app->db->getLastInsertID();
       return $id;
     }
     public function  updateTicket($ticket)
     {     
       $value=array();
       foreach ($ticket as $key => $val) {
         if($key!="ID" && $key!="name" && $key!="id_agent" && $key!="sine" && $key!="is_deleted" && $key!="db_name" && $key!='datetime')
         $value[$key]=$val; 
       }
       $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref.Yii::$app->user->identity->db_name,$value, 
       'ID ='.$ticket["ID"])->execute(); 
      return true;
      /* $affected_rows =Yii::$app->db->createCommand()->update($this->table_pref.Yii::$app->user->identity->db_name, ['TOTAL' => $ticket["TOTAL"],
      'TOTAL_CAR' => $ticket["TOTAL_CAR"],
      'SERVICE_FEE' => $ticket["SERVICE_FEE"],
      'COMMISSION' => $ticket["COMMISSION"],
      'COMMISSION_AMOUNT' => $ticket["COMMISSION_AMOUNT"],
      'RESPONSIBLE' => $ticket["RESPONSIBLE"],
      'DISCOUNT' => $ticket["DISCOUNT"]], 
      'ID1 ='.$ticket["ID"])->execute(); 
      return true;
     // print_r($affected_rows);
     /* if($affected_rows)
         return true;
      return false;  */
     }
      public function getAllRows($filter_arr)
      {
        $query_str="";
         if($filter_arr['first_period']!="")
         {
            $query_str="DOCUMENT_ISSUED>='".$filter_arr['first_period']."'";
         }
         if($filter_arr['second_period']!="")
         {
            $e_date=date('Y-m-d', strtotime($filter_arr['second_period'] . ' +1 day'));
            if($query_str=="")
            $query_str="DOCUMENT_ISSUED<='".$e_date."'";
            else
            $query_str.=" and DOCUMENT_ISSUED<='".$e_date."'";
         }
         if($filter_arr['responsible']!="")
         {
            if($query_str=="")
            $query_str="RESPONSIBLE='".$filter_arr['responsible']."'";
            else
            $query_str.=" and RESPONSIBLE='".$filter_arr['responsible']."'";
         }
          if($filter_arr['procedure']!="")
         {
            if($query_str=="")
            $query_str="STATUS='".$filter_arr['procedure']."'";
            else
            $query_str.=" and STATUS='".$filter_arr['procedure']."'";
         }
         if($filter_arr['pnr_ticket_pax']!="")
         {
            if($query_str=="")
            $query_str="(LAST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR FIRST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR RECORD_LOCATOR like '%".$filter_arr['pnr_ticket_pax']."%' OR DOCUMENT_NUMBER like '%".$filter_arr['pnr_ticket_pax']."%')";
            else
            $query_str.=" and (LAST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR FIRST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR RECORD_LOCATOR like '%".$filter_arr['pnr_ticket_pax']."%' OR DOCUMENT_NUMBER like '%".$filter_arr['pnr_ticket_pax']."%')";
         }
         if($filter_arr['val_car']!="")
         {
            if($query_str=="")
            $query_str="ID_CARRIER='".$filter_arr['val_car']."'";
            else
            $query_str.=" and ID_CARRIER='".$filter_arr['val_car']."'";
         }
         if($query_str!="")
           $query_str=" where ".$query_str;
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM '.$this->table_pref.Yii::$app->user->identity->db_name.$query_str)
             ->queryScalar();
        return $count;
      }
      public function getAllTicketsFilters($offset,$limit,$filter_arr)
      {
        $query_str="";
         if($filter_arr['first_period']!="")
         {
            $query_str="DOCUMENT_ISSUED>='".$filter_arr['first_period']."'";
         }
         if($filter_arr['second_period']!="")
         {
            $e_date=date('Y-m-d', strtotime($filter_arr['second_period'] . ' +1 day'));
            if($query_str=="")
            $query_str="DOCUMENT_ISSUED<='".$e_date."'";
            else
            $query_str.=" and DOCUMENT_ISSUED<='".$e_date."'";
         }
         if($filter_arr['responsible']!="")
         {
            if($query_str=="")
            $query_str="RESPONSIBLE='".$filter_arr['responsible']."'";
            else
            $query_str.=" and RESPONSIBLE='".$filter_arr['responsible']."'";
         }
         if($filter_arr['procedure']!="")
         {
            if($query_str=="")
            $query_str="STATUS='".$filter_arr['procedure']."'";
            else
            $query_str.=" and STATUS='".$filter_arr['procedure']."'";
         }
         if($filter_arr['pnr_ticket_pax']!="")
         {
            if($query_str=="")
            $query_str="(LAST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR FIRST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR RECORD_LOCATOR like '%".$filter_arr['pnr_ticket_pax']."%' OR DOCUMENT_NUMBER like '%".$filter_arr['pnr_ticket_pax']."%')";
            else
            $query_str.=" and (LAST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR FIRST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR RECORD_LOCATOR like '%".$filter_arr['pnr_ticket_pax']."%' OR DOCUMENT_NUMBER like '%".$filter_arr['pnr_ticket_pax']."%')";
         }
         if($filter_arr['val_car']!="")
         {
            if($query_str=="")
            $query_str="ID_CARRIER='".$filter_arr['val_car']."'";
            else
            $query_str.=" and ID_CARRIER='".$filter_arr['val_car']."'";
         }
        
        $query=new Query();
            $query->addSelect(['ID','DOCUMENT_NUMBER','RECORD_LOCATOR','VALIDATING_CARRIER','LAST_NAME','FIRST_NAME','COMMISSION_AMOUNT','SERVICE_FEE','STATUS','DOCUMENT_ISSUED','TOTAL','CURRENCY','name','TYPE','DISCOUNT_AMOUNT','CURRENCY_RATE','TOTAL_CAR'])
            ->from ($this->table_pref.Yii::$app->user->identity->db_name.' t')
            ->leftJoin($this->table_pref.'agents a','a.id_agent = t.RESPONSIBLE')
            ->where($query_str)
            ->orderBy(['DOCUMENT_ISSUED'=>SORT_DESC])
            ->offset($offset)
            ->limit($limit);
       $tickets= $query->all();    
       return $tickets;          
      }
     public function getTicketsForExcel($filter_arr)
      {
        $query_str="";
        if($filter_arr['first_period']=="" && $filter_arr['second_period']=="")
        {
             $query_str="DOCUMENT_ISSUED>='".date("Y-m-01")."' and DOCUMENT_ISSUED<='".date('Y-m-d', strtotime(date("Y-m-d").' +1 day'))."'";
        }
        else
        {
         if($filter_arr['first_period']!="")
         {
            $query_str="DOCUMENT_ISSUED>='".$filter_arr['first_period']."'";
         }
         if($filter_arr['second_period']!="")
         {
            $e_date=date('Y-m-d', strtotime($filter_arr['second_period'] . ' +1 day'));
            if($query_str=="")
            $query_str="DOCUMENT_ISSUED<='".$e_date."'";
            else
            $query_str.=" and DOCUMENT_ISSUED<='".$e_date."'";
         }
         }
         if($filter_arr['responsible']!="")
         {
            if($query_str=="")
            $query_str="RESPONSIBLE='".$filter_arr['responsible']."'";
            else
            $query_str.=" and RESPONSIBLE='".$filter_arr['responsible']."'";
         }
          if($filter_arr['procedure']!="")
         {
            if($query_str=="")
            $query_str="STATUS='".$filter_arr['procedure']."'";
            else
            $query_str.=" and STATUS='".$filter_arr['procedure']."'";
         }
         if($filter_arr['pnr_ticket_pax']!="")
         {
            if($query_str=="")
            $query_str="(LAST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR FIRST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR RECORD_LOCATOR like '%".$filter_arr['pnr_ticket_pax']."%' OR DOCUMENT_NUMBER like '%".$filter_arr['pnr_ticket_pax']."%')";
            else
            $query_str.=" and (LAST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR FIRST_NAME like '%".$filter_arr['pnr_ticket_pax']."%' OR RECORD_LOCATOR like '%".$filter_arr['pnr_ticket_pax']."%' OR DOCUMENT_NUMBER like '%".$filter_arr['pnr_ticket_pax']."%')";
         }
         if($filter_arr['val_car']!="")
         {
            if($query_str=="")
            $query_str="ID_CARRIER='".$filter_arr['val_car']."'";
            else
            $query_str.=" and ID_CARRIER='".$filter_arr['val_car']."'";
         }
        
        $query=new Query();
            $query->addSelect(['*'])
            ->from ($this->table_pref.Yii::$app->user->identity->db_name.' t')
            ->leftJoin($this->table_pref.'agents a','a.id_agent = t.RESPONSIBLE')
            ->where($query_str)
            ->orderBy(['DOCUMENT_ISSUED'=>SORT_DESC]);
            $tickets= $query->all();    
        return $tickets;          
      } 
        public function getAgentsReports($filter_arr)
        {
            $query_str = '';
            if (!empty($filter_arr['responsible']))
            {
                $query_str = "RESPONSIBLE = '{$filter_arr['responsible']}'";
            }
            $query_join = '';
            if (empty($filter_arr['first_period']) && empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND ';
                $query_join .= empty($query_join) ? '' : ' AND ';  
                $query_str .= "t.`DOCUMENT_ISSUED` >= '".date('Y-m-d')." 00:00:00' AND t.`DOCUMENT_ISSUED` < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
                $query_join .= "c.date >= '".date('Y-m-d')." 00:00:00' AND c.date < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
            }
            elseif (!empty($filter_arr['first_period']) && empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND '; 
                $query_join .= empty($query_join) ? '' : ' AND ';
                $query_str .= "t.`DOCUMENT_ISSUED` >= '{$filter_arr['first_period']} 00:00:00' AND t.`DOCUMENT_ISSUED` < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
                $query_join .= "c.date >= '{$filter_arr['first_period']} 00:00:00' AND c.date < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
            }
            elseif (empty($filter_arr['first_period']) && !empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND '; 
                $query_join .= empty($query_join) ? '' : ' AND ';
                $query_str .= "t.`DOCUMENT_ISSUED` >= '{$filter_arr['second_period']} 00:00:00' AND t.`DOCUMENT_ISSUED` < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
                $query_join .= "c.date >= '{$filter_arr['second_period']} 00:00:00' AND c.date < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
            }
            elseif (!empty($filter_arr['first_period']) && !empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND ';
                $query_join .= empty($query_join) ? '' : ' AND ';
                $query_str .= "t.`DOCUMENT_ISSUED` >= '{$filter_arr['first_period']} 00:00:00' AND t.`DOCUMENT_ISSUED` < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
                $query_join .= "c.date >= '{$filter_arr['first_period']} 00:00:00' AND c.date < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
            }
            
            $query=new Query();
                $query->addSelect(['`a`.id_agent agent_id', 't.STATUS status', 'sum(t.TOTAL) total_ticket', 'sum(t.SERVICE_FEE) service_fee', 'sum(t.DISCOUNT_AMOUNT) discount', 'a.name agent'])
                ->from ($this->table_pref.Yii::$app->user->identity->db_name.' t')
                ->leftJoin($this->table_pref.'agents a','a.id_agent = t.RESPONSIBLE')
                ->where($query_str)
                ->groupBy(['t.`STATUS`', '`a`.id_agent'])
                ->orderBy(['a.name'=>SORT_DESC]);
                $tickets= $query->all();
            
            $reports = array();
            if (is_array($tickets))
            {
                foreach ($tickets as &$ticket)
                {
                    $ticket['agent_id'] = empty($ticket['agent_id']) ? '0' : $ticket['agent_id'];
                    $ticket['agent'] = empty($ticket['agent']) ? 'ADMIN' : $ticket['agent'];
                    if (!isset($reports[$ticket['agent_id']]))
                    {
                        $reports[$ticket['agent_id']]['agent_id'] = $ticket['agent_id'];
                        $reports[$ticket['agent_id']]['agent'] = $ticket['agent'];
                        $reports[$ticket['agent_id']]['total_ticket'] = 0;
                        $reports[$ticket['agent_id']]['service_fee'] = 0;
                        $reports[$ticket['agent_id']]['discount'] = 0;
                    }
                    if ($ticket['status'] == 'REFUNDED' || $ticket['status'] == 'VOIDED')
                    {
                        $reports[$ticket['agent_id']]['total_ticket'] -= $ticket['total_ticket'];
                        $reports[$ticket['agent_id']]['service_fee'] -= $ticket['service_fee'];
                        $reports[$ticket['agent_id']]['discount'] -= $ticket['discount'];
                    }
                    else
                    {
                        $reports[$ticket['agent_id']]['total_ticket'] += $ticket['total_ticket'];
                        $reports[$ticket['agent_id']]['service_fee'] += $ticket['service_fee'];
                        $reports[$ticket['agent_id']]['discount'] += $ticket['discount'];
                    } 
                }
                foreach ($reports as &$report)
                {
                    $query=new Query();
                    $query->addSelect(['sum(value_pay) payment', 'sum(value_exp) expense'])
                    ->from($this->table_pref.'agents_payments c')
                    ->where($query_join . " AND c.ida = '{$report['agent_id']}'");
                    $payment = $query->all();
                    $payment = sizeof($payment) > 0 ? $payment[0] : null;
                    $pay = empty($payment) || empty($payment['payment']) ? 0 : $payment['payment'];
                    $exp = empty($payment) || empty($payment['expense']) ? 0 : $payment['expense'];
                    $report['payment'] = $pay;
                    $report['expense'] = $exp;
                }
                
            }
            
            return $reports;          
        
        }
      
        public function getAviacompaniesReports($filter_arr)
        {
            $query_str = '';
            if (!empty($filter_arr['aviacompany']))
            {
                $query_str = "ID_CARRIER = '{$filter_arr['aviacompany']}'";
            }
            $query_join = '';
            if (empty($filter_arr['first_period']) && empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND ';
                $query_join .= empty($query_join) ? '' : ' AND ';  
                $query_str .= "t.`DOCUMENT_ISSUED` >= '".date('Y-m-d')." 00:00:00' AND t.`DOCUMENT_ISSUED` < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
                $query_join .= "c.date >= '".date('Y-m-d')." 00:00:00' AND c.date < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
            }
            elseif (!empty($filter_arr['first_period']) && empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND '; 
                $query_join .= empty($query_join) ? '' : ' AND ';
                $query_str .= "t.`DOCUMENT_ISSUED` >= '{$filter_arr['first_period']} 00:00:00' AND t.`DOCUMENT_ISSUED` < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
                $query_join .= "c.date >= '{$filter_arr['first_period']} 00:00:00' AND c.date < '".date('Y-m-d', time()+60*60*24)." 00:00:00'";
            }
            elseif (empty($filter_arr['first_period']) && !empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND '; 
                $query_join .= empty($query_join) ? '' : ' AND ';
                $query_str .= "t.`DOCUMENT_ISSUED` >= '{$filter_arr['second_period']} 00:00:00' AND t.`DOCUMENT_ISSUED` < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
                $query_join .= "c.date >= '{$filter_arr['second_period']} 00:00:00' AND c.date < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
            }
            elseif (!empty($filter_arr['first_period']) && !empty($filter_arr['second_period']))
            {
                $query_str .= empty($query_str) ? '' : ' AND ';
                $query_join .= empty($query_join) ? '' : ' AND ';
                $query_str .= "t.`DOCUMENT_ISSUED` >= '{$filter_arr['first_period']} 00:00:00' AND t.`DOCUMENT_ISSUED` < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
                $query_join .= "c.date >= '{$filter_arr['first_period']} 00:00:00' AND c.date < '" .date('Y-m-d', strtotime($filter_arr['second_period'])+60*60*24). " 00:00:00'";
            }
            
            $query=new Query();
                $query->addSelect(['`a`.id aviacompany_id', 't.STATUS status', 'sum(t.FARE) + sum(t.TAXES_TOTAL) - sum(t.CANCELLATION_FEE) total', 'sum(t.COMMISSION_AMOUNT) comission', 'a.name aviacompany'])
                ->from ($this->table_pref.Yii::$app->user->identity->db_name.' t')
                ->leftJoin($this->table_pref.'carriers a','a.id = t.ID_CARRIER')
                ->where($query_str)
                ->groupBy(['t.`STATUS`', '`a`.id'])
                ->orderBy(['a.name'=>SORT_DESC]);
                $tickets= $query->all();
            
            $reports = array();
            if (is_array($tickets))
            {
                foreach ($tickets as &$ticket)
                {
                    $ticket['aviacompany_id'] = empty($ticket['aviacompany_id']) ? '0' : $ticket['aviacompany_id'];
                    $ticket['aviacompany'] = empty($ticket['aviacompany']) ? 'NULL' : $ticket['aviacompany'];
                    if (!isset($reports[$ticket['aviacompany_id']]))
                    {
                        $reports[$ticket['aviacompany_id']]['aviacompany_id'] = $ticket['aviacompany_id'];
                        $reports[$ticket['aviacompany_id']]['aviacompany'] = $ticket['aviacompany'];
                        $reports[$ticket['aviacompany_id']]['total'] = 0;
                        $reports[$ticket['aviacompany_id']]['comission'] = 0;
                    }
                    if ($ticket['status'] == 'REFUNDED' || $ticket['status'] == 'VOIDED')
                    {
                        $reports[$ticket['aviacompany_id']]['total'] -= $ticket['total'];
                        $reports[$ticket['aviacompany_id']]['comission'] -= $ticket['comission'];
                    }
                    else
                    {
                        $reports[$ticket['aviacompany_id']]['total'] += $ticket['total'];
                        $reports[$ticket['aviacompany_id']]['comission'] += $ticket['comission'];
                    } 
                }
                foreach ($reports as &$report)
                {
                    $query=new Query();
                    $query->addSelect(['sum(value_pay) payment'])
                    ->from($this->table_pref.'carriers_payments c')
                    ->where($query_join . " AND c.idc = '{$report['aviacompany_id']}'");
                    $payment = $query->all();
                    $payment = sizeof($payment) > 0 ? $payment[0] : null;
                    $pay = empty($payment) || empty($payment['payment']) ? 0 : $payment['payment'];
                    $report['payment'] = $pay;
                }
                
            }
            
            return $reports;
        }
 }
?>