<?php

namespace modava\auth\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

class UserModel extends User
{
    const SCENARIO_DEV = 'dev';
    public $manager;
    public $password = null;

    public function init()
    {
        $this->manager = Yii::$app->authManager;
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by']
                ],
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
        ];
    }

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => '\yii\helpers\Html::encode'],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'This username has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => $this->getId()]]);
                },
            ],

            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'This email address has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => $this->getId()]]);
                },
            ],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::STATUS)],
            [['role_name'], 'string'],
            [['password'], 'string', 'on' => self::SCENARIO_DEV]
        ];
    }

    public function attributeLabels()
    {
        return [];
    }

    public function getRoleName($id)
    {
        $cache = Yii::$app->cache;
        $key = 'rbac-' . $id;

        $assignment = $cache->get($key);

        if ($assignment == false) {
            $assignment = array_keys($this->manager->getAssignments($id));
            $assignment = $assignment != null ? $assignment[0] : User::USERS;

            $cache->set($key, $assignment);
        }


        return $assignment;
    }
}