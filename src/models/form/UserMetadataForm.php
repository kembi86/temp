<?php

namespace modava\auth\models\form;

use yii\base\Model;

class UserMetadataForm extends Model
{
    public $User;
    public $Pass;
    public $Display;
    public $Realm;
    public $WSServer;

    public function rules()
    {
        return [
            [['User']]
        ];
    }

    public function attributeLabels()
    {
        return [];
    }
}