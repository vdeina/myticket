<?php
namespace app\models;
use Yii;
use yii\base\Model;

class FilterAviacompaniesReportsForm extends Model
{
    public $first_period;
    public $second_period;
    public $aviacompany;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
           [['first_period','second_period','aviacompany'], 'default','value'=>null],
        ];
    }

}


?>