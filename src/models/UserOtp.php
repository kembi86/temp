<?php

namespace modava\auth\models;

use common\models\User;
use modava\auth\models\table\UserOtpTable;
use yii\db\ActiveRecord;
use Yii;

/**
* This is the model class for table "user_otp".
*
    * @property int $id
    * @property int $user_id
    * @property string $otp Mã otp gửi cho khách hàng
    * @property int $time_expired
    * @property int $status Đã sử dụng hay chưa sử dụng
    * @property int $created_at
*/
class UserOtp extends UserOtpTable
{
    public $toastr_key = 'user-otp';
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
            ]
        );
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
			[['user_id', 'otp'], 'required'],
			[['user_id', 'time_expired', 'status', 'created_at'], 'integer'],
			[['otp'], 'string', 'max' => 10],
		];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('auth', 'ID'),
            'user_id' => Yii::t('auth', 'User ID'),
            'otp' => Yii::t('auth', 'Otp'),
            'time_expired' => Yii::t('auth', 'Time Expired'),
            'status' => Yii::t('auth', 'Status'),
            'created_at' => Yii::t('auth', 'Created At'),
        ];
    }


}
