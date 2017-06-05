<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
     public static function updateActivity($id_user)
     {
         $connection = Yii::$app->db;
         $row=$connection->createCommand()->update(User::tableName(), 
                        ['last_activity' => date('Y-m-d H:i:s')],
                         'id='.$id_user)->execute();
     }
      public static function updateEnabled($id_user,$enabled)
    {    $connection = Yii::$app->db;
         $row=$connection->createCommand()->update(User::tableName(), 
                        ['enabled' => $enabled],
                         'id='.$id_user)->execute();
         if($row) return true;
         else return false;
                                    
                         
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 15],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }
}
