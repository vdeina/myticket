<?php
namespace app\models;
use Yii;
use yii\base\Model;

class FastViewForm extends Model
{
    public $search_word;
    public $period;
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['period'], 'required'], 
            [['search_word'], 'default','value'=>null],          
            ['search_word', 'string', 'max' => 30],
        ];
    }

}


?>