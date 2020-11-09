<?php
/**
 * Created by PhpStorm.
 * User: luken
 * Date: 10/26/2020
 * Time: 14:24
 */

namespace modava\auth\models\form;


use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use http\Exception\InvalidArgumentException;
use modava\auth\models\User;
use yii\base\Model;
use Yii;

class ChangePassWordForm extends Model
{
    /*const SCENARIO_CHANGE_PASS = 'change-pass';*/

    public $id;
    public $old_password;
    public $password;
    public $confirm_password;

    private $_user;

    public function __construct($id, $config = [])
    {
        $this->_user = User::findIdentity($id);

        if (!$this->_user) {
            throw new InvalidArgumentException('Không tìm thấy người dùng hiện tại!');
        }

        $this->id = $this->_user->id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['old_password', 'password', 'confirm_password'], 'required'],
            [['old_password', 'password', 'confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Mật khẩu mới không trùng nhau.'],
            /*[['reCaptcha'], ReCaptchaValidator2::class,
                'secret' => RECAPTCHA_GOOGLE_SECRETKEY,
                'uncheckedMessage' => Yii::t('backend', 'I am not robot'), 'on' => self::SCENARIO_CHANGE_PASS]*/
        ];
    }

    public function attributeLabels()
    {
        return [
            'old_password' => Yii::t('backend', 'Mật khẩu cũ'),
            'password' => Yii::t('backend', 'Mật khẩu mới'),
            'confirm_password' => Yii::t('backend', 'Xác nhận mật khẩu mới')
        ];
    }

    public function changePassword()
    {
        $user = $this->_user;
        if ($user->validatePassword($this->old_password)) {
            $user->setPassword($this->password);
            return $user->save(false);
        } else {
            return false;
        }
    }
}