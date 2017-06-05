<?php
namespace app\models;
use Yii;
use yii\base\Model;

class FastEditForm extends Model
{
    public $agent;
    public $sf;
    public $fm;
    public $dis;
    public $cur_rate;
    public $cur;
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['agent'], 'required'], 
            [['sf','fm','dis','cur_rate','cur'], 'default','value'=>null], 
            [['fm','dis'], 'match', 'pattern'=>'/^[\d\.%]+$/'],    
            [['sf','cur_rate'], 'match', 'pattern'=>'/^[\d\.]+$/'],      
        ];
    }

}


?>