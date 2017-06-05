<?php
namespace app\models;
use Yii;
use yii\base\Model;

class FilterTicketsForm extends Model
{
    public $first_period;
    public $second_period;
    public $responsible;
    public $val_car;
    public $procedure;
    public $pnr_ticket_pax;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
           [['pnr_ticket_pax','procedure','first_period','second_period','responsible','val_car'], 'default','value'=>null],
        ];
    }

}


?>