<?php
	namespace app\models;
    use Yii;
class  MathFunctions 
{
  
    public function getPaymentsAsocArr($payments)
    {
        $paymentsAsso=array();
        foreach($payments as $payment)
        {
            $paymentsAsso[date('d.m.Y',strtotime($payment['date']))][]=($payment);
        }
        return $paymentsAsso;
    }
    
  
    public function setAllTicketData($ticket,$edit_model)
     {
        $vowels = array("'", '"', "/","\\","%");
        $ticket["RECORD_LOCATOR"]=strtoupper(str_replace($vowels,"",$edit_model->recloc));
        $ticket["STATUS"]=strtoupper(str_replace($vowels,"",$edit_model->status));
        $ticket["DOCUMENT_NUMBER"]=strtoupper(str_replace($vowels,"",$edit_model->doc_num));
        $ticket["DOCUMENT_ISSUED"]=strtoupper(str_replace($vowels,"",$edit_model->doc_issued));
        $ticket["TICKETING_SINE"]=strtoupper(str_replace($vowels,"",$edit_model->sine));
        $ticket["RESPONSIBLE"]=str_replace($vowels,"",$edit_model->respon);
        $ticket["FIRST_NAME"]=strtoupper(str_replace($vowels,"",$edit_model->first_name));
        $ticket["LAST_NAME"]=strtoupper(str_replace($vowels,"",$edit_model->last_name));
        $ticket["TITLE"]=strtoupper(str_replace($vowels,"",$edit_model->title));
        $ticket["PASSPORT"]=strtoupper(str_replace($vowels,"",$edit_model->passport));
        $ticket["PHONE"]=strtoupper(str_replace($vowels,"",$edit_model->phone));
        $ticket["EMAIL"]=strtoupper(str_replace($vowels,"",$edit_model->email));
        $ticket["ROUTE"]=strtoupper(str_replace($vowels,"",$edit_model->route));
        $ticket["VALIDATING_CARRIER"]=strtoupper(str_replace($vowels,"",$edit_model->val_car));
        $ticket["MARKETING_CARRIER"]=strtoupper(str_replace($vowels,"",$edit_model->mark_car));
        $ticket["OPERATING_CARRIER"]=strtoupper(str_replace($vowels,"",$edit_model->oper_car));
        $ticket["DEPARTURE_DATE"]=strtoupper(str_replace($vowels,"",$edit_model->dep_date));
        $ticket["BOOKING_CLASSES"]=strtoupper(str_replace($vowels,"",$edit_model->booking_class));
        $ticket["FARE_BASISES"]=strtoupper(str_replace($vowels,"",$edit_model->fare_basises));
        $ticket["FLIGHT_NUMBERS"]=strtoupper(str_replace($vowels,"",$edit_model->flight_numbers));
        $ticket["FO_NUMBER"]=strtoupper(str_replace($vowels,"",$edit_model->fo_number));
        $ticket["BAGGAGE"]=strtoupper(str_replace($vowels,"",$edit_model->baggage));
        $ticket["ROU_CNT"]=strtoupper(str_replace($vowels,"",$edit_model->rou_cnt));
        $ticket["DOM_INT"]=strtoupper(str_replace($vowels,"",$edit_model->dom_int));
        $ticket["REMARK1"]=strtoupper(str_replace($vowels,"",$edit_model->rem));
        $ticket["TYPE"]=str_replace($vowels,"",$edit_model->type);
        if($edit_model->status=="REFUNDED")
        {
          $ticket["FARE"]=$edit_model->fare_ref;  
          $ticket["TOTAL_TST"]=$edit_model->fare_ref+$edit_model->taxes_total_ref;
          $ticket["TAXES_TOTAL"]=$edit_model->taxes_total_ref; 
          $ticket["CANCELLATION_FEE"]=$edit_model->cancel_fee; 
          $ticket["TOTAL"]=$edit_model->total_ref; 
          $ticket["TOTAL_CAR"]=$edit_model->total_car_ref;
          $ticket["CURRENCY"]=$edit_model->cur_ref;
          $ticket["COMMISSION"]=$edit_model->commis_amount_ref;
          $ticket["COMMISSION_AMOUNT"]=$edit_model->commis_amount_ref;
          $ticket["CURRENCY_RATE"]=$edit_model->cur_rate_ref;
          $ticket["SERVICE_FEE"]="0";
          $ticket["DISCOUNT"]="0"; 
          $ticket["DISCOUNT_AMOUNT"]="0"; 
          $ticket["SERVICE_FEE"]=$edit_model->sf_ref;  
        }
        else
        {
           $ticket["TOTAL_TST"]=$edit_model->fare+$edit_model->taxes_total;
           $ticket["FARE"]=$edit_model->fare;  
           $ticket["TAXES_TOTAL"]=$edit_model->taxes_total;   
           $ticket["SERVICE_FEE"]=$edit_model->sf;  
           $ticket["TAXES"]=$edit_model->taxes;  
           $ticket["COMMISSION"]=$edit_model->commis; 
           $ticket["COMMISSION_AMOUNT"]=$edit_model->commis_amount; 
           $ticket["DISCOUNT"]=$edit_model->dis; 
           $ticket["DISCOUNT_AMOUNT"]=$edit_model->dis_amount; 
           $ticket["TOTAL"]=$edit_model->total; 
           $ticket["TOTAL_CAR"]=$edit_model->total_car; 
           $ticket["CURRENCY"]=$edit_model->cur; 
           $ticket["CURRENCY_RATE"]=$edit_model->cur_rate; 
        }
        return $ticket;
     }
    
    public function setTicketDataWithCurrencyRate($ticket,$edit_model,$other_rate)
     {
          if($other_rate)
          {
            $old_cur_rate=$ticket["CURRENCY_RATE"];
            $ticket["FARE"]=round($ticket["FARE"]/$old_cur_rate,2);
            $ticket["TAXES_TOTAL"]=round($ticket["TAXES_TOTAL"]/$old_cur_rate,2);
            $ticket["TOTAL_TST"]=$ticket["TAXES_TOTAL"]+ $ticket["FARE"];
             if($ticket["COMMISSION"]==$edit_model->fm)
               { 
                  if( strpos($edit_model->fm, '%') == false )
                  {
                    if(strlen(trim($edit_model->fm))==0)
                       $edit_model->fm=0;
                    else  
                    {     $edit_model->fm=$edit_model->fm/$old_cur_rate;
                          $edit_model->fm=round($edit_model->fm*$edit_model->cur_rate,2);
                    }
                  }  
               }
          }
          else
          {
             if($ticket["DISCOUNT"]==$edit_model->dis)
               { 
                  if( strpos($edit_model->dis, '%') == false )
                  {
                    if(strlen(trim($edit_model->dis))==0)
                    $edit_model->dis=0;
                    else
                    $edit_model->dis=round($edit_model->dis*$edit_model->cur_rate,2);
                  }  
               }
               if($ticket["COMMISSION"]==$edit_model->fm)
               { 
                  if( strpos($edit_model->fm, '%') == false )
                  {
                    if(strlen(trim($edit_model->fm))==0)
                    $edit_model->fm=0;
                    else
                    $edit_model->fm=round($edit_model->fm*$edit_model->cur_rate,2);
                  }  
               }
                if($ticket["SERVICE_FEE"]==$edit_model->sf)
               { 
                  if(strlen(trim($edit_model->sf))==0)
                    $edit_model->sf=0;
                    else
                  $edit_model->sf=round($edit_model->sf*$edit_model->cur_rate,2);              
               }
          }
        
           $ticket["RESPONSIBLE"] =$edit_model->agent;
           $ticket["CURRENCY"] =$edit_model->cur;
           $ticket["CURRENCY_RATE"] =$edit_model->cur_rate;
           $ticket["FARE"]=round($ticket["FARE"]*$edit_model->cur_rate,2);
           $ticket["TAXES_TOTAL"]=round($ticket["TAXES_TOTAL"]*$edit_model->cur_rate,2);
           $ticket["TOTAL_TST"]=$ticket["TAXES_TOTAL"]+ $ticket["FARE"];
                                
           $ticket["DISCOUNT"] =$edit_model->dis;  
           if(strlen(trim($edit_model->fm))>0)
           {        
           $ticket["COMMISSION"] =$edit_model->fm;
           $ticket["COMMISSION_AMOUNT"] =$this->GetCommission($ticket["FARE"],$edit_model->fm,$edit_model->cur);
           if($ticket["STATUS"]=="REFUNDED")
             $ticket["TOTAL_CAR"]=$ticket["TOTAL_TST"]-$ticket["COMMISSION_AMOUNT"]-$ticket["CANCELLATION_FEE"];
           else
             $ticket["TOTAL_CAR"]=$ticket["TOTAL_TST"]-$ticket["COMMISSION_AMOUNT"];
           }
           else if(strlen(trim($ticket["COMMISSION"]))>0)
           {
               $ticket["COMMISSION"] ="0";
               $ticket["COMMISSION_AMOUNT"] ="0";
               $ticket["TOTAL_CAR"]=$ticket["TOTAL_TST"];
           }
           if(strlen(trim($edit_model->sf))>0)
           {
             $ticket["SERVICE_FEE"] = $edit_model->sf;
             $ticket["TOTAL"] = $ticket["TOTAL_TST"]+ $edit_model->sf; 
           } 
           else if(strlen(trim($ticket["SERVICE_FEE"]))>0)
           {
             $ticket["SERVICE_FEE"] ="0";
             $ticket["TOTAL"] = $ticket["TOTAL_TST"];
           }
           $ticket["DISCOUNT_AMOUNT"] =$this->GetDiscount(($ticket["TOTAL_TST"]+$ticket["SERVICE_FEE"]),$edit_model->dis,$edit_model->cur);
           
           $ticket["TOTAL"] =number_format(($ticket["TOTAL_TST"]+$ticket["SERVICE_FEE"]) -$this->GetDiscount(($ticket["TOTAL_TST"]+$ticket["SERVICE_FEE"]),$edit_model->dis,$edit_model->cur),2,'.','');
           
           return $ticket;
     }
    
   public function setTicketData($ticket,$edit_model)
     {
      if($ticket["TYPE"]=="ПЕГАСУС")
          {
            
            if($ticket['FARE_PEGASUS']==0)
                $ticket['FARE_PEGASUS']=$ticket["FARE"]-$ticket["COMMISSION_AMOUNT"];
          
           $ticket["RESPONSIBLE"] =$edit_model->agent;
           
           if(strlen(trim($edit_model->dis))>0)
           {
             $ticket["DISCOUNT"] = $edit_model->dis;
           } 
           else 
           {
             $ticket["DISCOUNT"] ="0";
           }
           if(strlen(trim($edit_model->fm))>0)
           {        
             $edit_model->fm =str_replace("%","",$edit_model->fm); 
             $ticket["COMMISSION"] =$edit_model->fm;
             $ticket["COMMISSION_AMOUNT"] =$edit_model->fm;
           }
           else 
           {
               $ticket["COMMISSION"] ="0";
               $ticket["COMMISSION_AMOUNT"] ="0";
           }          
           if(strlen(trim($edit_model->sf))>0)
           {
             $ticket["SERVICE_FEE"] = $edit_model->sf;
           } 
           else 
           {
             $ticket["SERVICE_FEE"] ="0";
           }
           $ticket['FARE']=$ticket['FARE_PEGASUS']+$ticket["COMMISSION_AMOUNT"];
           $ticket["DISCOUNT_AMOUNT"] =$this->GetDiscount(($ticket['FARE']+$ticket['TAXES_TOTAL']+$ticket["SERVICE_FEE"]),$edit_model->dis,$edit_model->cur);
          
           if($ticket["STATUS"]=="REFUNDED")
            $ticket["TOTAL"] =number_format(($ticket['FARE']+$ticket['TAXES_TOTAL']-$ticket["SERVICE_FEE"]-$ticket["CANCELLATION_FEE"]),2,'.','');
           else
           $ticket["TOTAL"] =number_format($ticket['FARE']+$ticket['TAXES_TOTAL']+$ticket["SERVICE_FEE"]-$ticket["DISCOUNT_AMOUNT"],2,'.','');
           
          }
        else
        {        
           $com_ref=$ticket["COMMISSION_AMOUNT"];           
           $ticket["TOTAL_TST"]=$ticket["TAXES_TOTAL"]+ $ticket["FARE"];
           $ticket["RESPONSIBLE"] =$edit_model->agent;
           $ticket["DISCOUNT"] =$edit_model->dis;  
           if(strlen(trim($edit_model->fm))>0)
           {        
           $ticket["COMMISSION"] =$edit_model->fm;
           $ticket["COMMISSION_AMOUNT"] =$this->GetCommission($ticket["FARE"],$edit_model->fm,$edit_model->cur);
           if($ticket["STATUS"]!=="REFUNDED")
            // $ticket["TOTAL_CAR"]=$ticket["TOTAL_TST"]-$com_ref-$ticket["CANCELLATION_FEE"];
          // else
             $ticket["TOTAL_CAR"]=$ticket["TOTAL_TST"]-$ticket["COMMISSION_AMOUNT"];
           }
           else 
           {
               $ticket["COMMISSION"] ="0";
               $ticket["COMMISSION_AMOUNT"] ="0";
           }
           if(strlen(trim($edit_model->sf))>0)
           {
             $ticket["SERVICE_FEE"] = $edit_model->sf;
             $ticket["TOTAL"] = $ticket["TOTAL_TST"]+ $edit_model->sf; 
           } 
           else 
           {
             $ticket["SERVICE_FEE"] ="0";
             $ticket["TOTAL"] = $ticket["TOTAL_TST"];
           }
           
           $ticket["DISCOUNT_AMOUNT"] =$this->GetDiscount(($ticket["TOTAL_TST"]+$ticket["SERVICE_FEE"]),$edit_model->dis,$edit_model->cur);
           if($ticket["STATUS"]=="REFUNDED")
            $ticket["TOTAL"] =number_format(($ticket["TOTAL_CAR"]+$ticket["COMMISSION_AMOUNT"]-$ticket["SERVICE_FEE"]),2,'.','');
           else
           $ticket["TOTAL"] =number_format(($ticket["TOTAL_TST"]+$ticket["SERVICE_FEE"]) -$this->GetDiscount(($ticket["TOTAL_TST"]+$ticket["SERVICE_FEE"]),$edit_model->dis,$edit_model->cur),2,'.','');
           }
           return $ticket;
     }
    
   public function GetServiceFee($total,$sf)
    {
        if(strlen(trim($sf))>0)
        {
        if( strpos($sf, '%') !== false )
        {
           $sf= str_replace('%','',$sf);
           return round($total*$sf/100,2); 
        }
        else
          return $sf;
        }
        return trim($sf);
    }
   public function GetCommission($fare,$fm,$cur)
    {
        if(strlen(trim($fm))>0)
        {
          if( strpos($fm, '%') !== false )
          {
           $fm= str_replace('%','',$fm);
           return round($fare*$fm/100,2);
          }
          else
          return $fm;
        }
         return "0";           
    }
    public function GetDiscount($total,$dis,$cur)
    {
        if(strlen(trim($dis))>0)
        {
          if( strpos($dis, '%') !== false )
          {
           $dis= str_replace('%','',$dis);
           return round($total*$dis/100,2); 
          }
          else
          return $dis;
        }
         return "0";           
    }
}   
    
    
?>