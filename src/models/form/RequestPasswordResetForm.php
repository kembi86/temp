<?php
/**
 * Created by PhpStorm.
 * User: luken
 * Date: 9/25/2020
 * Time: 10:13
 */

namespace modava\auth\models\form;


use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use modava\auth\models\User;
use yii\base\Model;

class RequestPasswordResetForm extends Model
{
    /**
     * @var user email
     */
    public $email;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => 'Vui lòng nhập email'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Không tồn tại email trên.'
            ],
            [['reCaptcha'], ReCaptchaValidator2::class,
                'secret' => RECAPTCHA_GOOGLE_SECRETKEY, 'uncheckedMessage' => \Yii::t('backend', 'Vui lòng đánh dấu vào ô trên')]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('frontend', 'E-mail'),
            'reCaptcha' => 'Captcha',
        ];
    }
}