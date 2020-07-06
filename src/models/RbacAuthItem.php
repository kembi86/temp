<?php

namespace modava\auth\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\auth\AuthModule;
use modava\auth\models\table\RbacAuthItemTable;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "rbac_auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property RbacAuthAssignment[] $rbacAuthAssignments
 * @property User[] $users
 * @property RbacAuthRule $ruleName
 * @property RbacAuthItemChild[] $rbacAuthItemChildren
 * @property RbacAuthItemChild[] $rbacAuthItemChildren0
 * @property RbacAuthItem[] $children
 * @property RbacAuthItem[] $parents
 */
class RbacAuthItem extends RbacAuthItemTable
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;
    const TYPE = [
        self::TYPE_ROLE => 'Role',
        self::TYPE_PERMISSION => 'Permission'
    ];
    public $toastr_key = 'rbac-auth-item';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'timestamp' => [
                    'class' => 'yii\behaviors\TimestampBehavior',
                    'preserveNonEmptyValues' => true,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'in', 'range' => array_keys(self::TYPE)],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => AuthModule::t('auth', 'Name'),
            'type' => AuthModule::t('auth', 'Type'),
            'description' => AuthModule::t('auth', 'Description'),
            'rule_name' => AuthModule::t('auth', 'Rule Name'),
            'data' => AuthModule::t('auth', 'Data'),
            'created_at' => AuthModule::t('auth', 'Created At'),
            'updated_at' => AuthModule::t('auth', 'Updated At'),
        ];
    }


}
