<?php

namespace modava\auth\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const STATUS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DELETED => 'Deleted',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    const DEV = 'develop';
    const SALES_ONLINE = 'sales_online';
    const CLINIC = 'clinic';
    const USERS = 'users'; //user frontend

    public $toastr_key = 'user';
    public $manager;
    public $role_name;
    public $role;
    public $fullname;

    public function init()
    {
        $this->manager = Yii::$app->authManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /*
     * Trả về tên Role của user.
     */

    public function getRoleName($id)
    {
        $cache = Yii::$app->cache;
        $key = 'rbac-' . $id;

        $assignment = $cache->get($key);

        if ($assignment == false) {
            $assignment = array_keys($this->manager->getAssignments($id));
            $assignment = $assignment != null ? $assignment[0] : null;

            $cache->set($key, $assignment);
        }


        return $assignment;
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    public function getUserToken()
    {
        return $this->hasMany(UserToken::class, ['user_id' => 'id']);
    }

    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUserUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function getAuthItem()
    {
        return $this->hasMany(RbacAuthItem::class, ['name' => 'item_name'])
            ->viaTable('rbac_auth_assignment', ['user_id' => 'id']);
    }

    public function afterSignup(array $profileData = [])
    {
        $this->refresh();

        $profile = new UserProfile();
        $profile->locale = Yii::$app->language;
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole($this->role_name), $this->getId());
    }

    /*
     * Kiểm tra parent - child
     * $role đưa vào cần kiểm tra
     * $roleUser role của người đang kiểm tra
     */
    public function checkParent(string $role, string $roleUser): bool
    {
        if ($roleUser == 'user_develop') {
            return true;
        }
        $result = $this->manager->getChildRoles($roleUser);
        foreach ($result as $roleName) {
            if ($role == $roleName->name) {
                return true;
            }
        }
        return false;
    }

    public function getUserMetadataHasOne()
    {
        return $this->hasOne(UserMetadata::class, ['user_id' => 'id']);
    }

    public function getUserMetadata($metadataName = null)
    {
        if ($this->primaryKey == null) return null;
        $metadata = $this->userMetadataHasOne == null ? [] : $this->userMetadataHasOne->metadata;
        if (!is_array($metadata)) $metadata = [];
        if (is_string($metadataName)) return $metadata[$metadataName] ?: null;
        if (is_array($metadataName)) {
            return ArrayHelper::filter($metadata, $metadataName);
        }
        return null;
    }

    public static function getUserByRole($role, $select = null, $active = true)
    {
        if (!is_string($role) && !is_array($role)) return [];
        $query = self::find()->joinWith(['authItem', 'userProfile'])
            ->where([RbacAuthItem::tableName() . '.name' => $role]);
        if ($select != null) $query->select($select);
        if ($active === true) $query->andWhere([self::tableName() . '.status' => self::STATUS_ACTIVE]);
        return $query->all();
    }
}
