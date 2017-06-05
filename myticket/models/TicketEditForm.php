<?php
namespace app\models;
use Yii;
use yii\base\Model;

class TicketEditForm extends Model
{
    public $record;
    public $status;
    public $recloc;
    public $doc_num;
    public $sine;
    public $respon;
    public $first_name;
    public $last_name;
    public $title;
    public $passport;
    public $phone;
    public $email;
    public $route;
    public $val_car;
    public $mark_car;
    public $oper_car;
    public $dep_date;
    public $booking_class;
    public $fare_basises;
    public $flight_numbers;
    public $fo_number;
    public $baggage;
    public $rou_cnt;
    public $dom_int;
    public $rem;
    public $type;
    public $doc_issued;
    public $fare;
    public $taxes_total;
    public $sf;
    public $taxes;
    public $commis;
    public $commis_amount;
    public $dis;
    public $dis_amount; 
    public $total;
    public $total_car;
    public $cur;
    public $cur_rate;
    public $cancel_fee;
    public $fare_ref;
    public $taxes_total_ref;
    public $total_ref;
    public $total_car_ref;
    public $cur_ref;
    public $commis_amount_ref;
    public $cur_rate_ref;
    public $sf_ref;
    
    public function rules()
    {
        return [
            [['doc_num','route','val_car','doc_issued'],'required'],
            ['val_car', 'string', 'length'=>2],
            [['doc_num','fo_number'], 'string', 'length'=>[13,14]],
            [['record','recloc','doc_num','sine','respon','doc_issued','cur','cur_ref','cur_rate',
            'first_name','last_name','title','passport','taxes','cancel_fee',
            'phone','email','route','val_car','baggage',
            'mark_car','oper_car','dep_date','booking_class','fare_basises','flight_numbers',
            'fo_number','baggage','rou_cnt','dom_int','rem','type','status'], 'default','value'=>null],
            [['commis_amount_ref','cur_rate','cur_rate_ref','total_car_ref','total_ref','fare','cancel_fee','fare_ref','taxes_total_ref','sf_ref','taxes_total','sf','commis_amount','dis_amount','total','total_car'], 'match', 'pattern'=>'/^[-\d\.]+$/'], 
            [['commis','dis'], 'match', 'pattern'=>'/^[\d\.%]+$/'],       
        ];
    }

}


?>