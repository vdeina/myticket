<?php
namespace app\models;
use Yii;
use yii\base\Model;

class FilterAgentsReportsForm extends Model
{
    public $first_period;
    public $second_period;
    public $responsible;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
           [['first_period','second_period','responsible'], 'default','value'=>null],
        ];
    }

}


?>