<?php

namespace modava\auth\models;

use modava\auth\AuthModule;
use modava\auth\components\MyUpload;
use Mpdf\Tag\P;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\web\UploadedFile;

class UserProfile extends ActiveRecord
{
    const SCENARIO_SAVE = 'save';
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHER = 3;
    const GENDER = [
        self::GENDER_OTHER => 'Khác',
        self::GENDER_MALE => 'Nam',
        self::GENDER_FEMALE => 'Nữ'
    ];

    public $iptAvatar;
    public $iptCover;

    private $avatarSuccess = null;
    private $coverSuccess = null;

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => ['iptAvatar']
                ],
                'value' => function () {
                    return UploadedFile::getInstance($this, 'iptAvatar');
                }
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => ['iptCover']
                ],
                'value' => function () {
                    return UploadedFile::getInstance($this, 'iptCover');
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required', 'on' => self::SCENARIO_SAVE],
            [['phone'], 'required'],
            [['user_id', 'gender'], 'integer'],
            [['gender'], 'in', 'range' => array_keys(self::GENDER)],
            [['fullname', 'address', 'avatar', 'cover'], 'string', 'max' => 255],
            [['facebook'], 'string', 'max' => 50],
            [['birthday', 'phone'], 'string', 'max' => 25],
            [['about'], 'string'],
            [['iptAvatar', 'iptCover'], 'file', 'extensions' => ['png', 'jpg', 'jpeg'], 'wrongExtension' => 'Chỉ chấp nhận định dạng: {extensions}', 'maxSize' => 5 * 1024 * 1024],
            [['avatar', 'cover'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->language],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
            [['phone'], 'unique', 'targetClass' => self::class, 'targetAttribute' => 'phone', 'filter' => function ($query) {
                $query->andWhere(['not', ['user_id' => $this->getPrimaryKey()]]);
            },]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('backend', 'User ID'),
            'fullname' => Yii::t('backend', 'Họ tên'),
            'birthday' => Yii::t('backend', 'Ngày sinh'),
            'about' => Yii::t('backend', 'About me'),
            'address' => Yii::t('backend', 'Address'),
            'phone' => Yii::t('backend', 'Phone'),
            'facebook' => Yii::t('backend', 'Facebook'),
            'avatar' => Yii::t('backend', 'Avatar'),
            'cover' => Yii::t('backend', 'Cover'),
            'locale' => Yii::t('backend', 'Locale'),
            'gender' => Yii::t('backend', 'Giới tính'),
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->iptAvatar != null) {
            /* @var $iptAvatar UploadedFile */
            $iptAvatar = $this->iptAvatar;
            $avatarName = $iptAvatar->baseName . '-' . time() . '.' . $iptAvatar->extension;
            if ($iptAvatar->saveAs('@frontend/web/uploads/tmp/' . $avatarName)) {
                $pathImage = FRONTEND_HOST_INFO . '/uploads/tmp/' . $avatarName;
                foreach (Yii::$app->params['user-avatar'] as $info) {
                    $pathSave = Yii::getAlias('@backend/web') . $info['folder'];
                    if (!file_exists($pathSave) && !is_dir($pathSave)) {
                        mkdir($pathSave);
                    }
                    $resultName = MyUpload::uploadFromOnline($info['width'], $info['height'], $pathImage, $pathSave, $this->avatarSuccess);
                    if ($this->avatarSuccess == null) {
                        $this->avatarSuccess = $resultName;
                    }
                }
                @unlink(Yii::getAlias('@frontend/web/uploads/tmp') . '/' . $avatarName);
            }
            if ($this->avatarSuccess != null) $this->avatar = $this->avatarSuccess;
        }
        if ($this->iptCover != null) {
            /* @var $iptCover UploadedFile */
            $iptCover = $this->iptCover;
            $coverName = $iptCover->baseName . '-' . time() . '.' . $iptCover->extension;
            if ($iptCover->saveAs('@frontend/web/uploads/tmp/' . $coverName)) {
                $pathImage = FRONTEND_HOST_INFO . '/uploads/tmp/' . $coverName;
                foreach (Yii::$app->params['user-cover'] as $info) {
                    $pathSave = Yii::getAlias('@backend/web') . $info['folder'];
                    if (!file_exists($pathSave) && !is_dir($pathSave)) {
                        mkdir($pathSave);
                    }
                    $resultName = MyUpload::uploadFromOnline($info['width'], $info['height'], $pathImage, $pathSave, $this->coverSuccess);
                    if ($this->coverSuccess == null) {
                        $this->coverSuccess = $resultName;
                    }
                }
                @unlink(Yii::getAlias('@frontend/web/uploads/tmp') . '/' . $coverName);
            }
            if ($this->coverSuccess != null) $this->cover = $this->coverSuccess;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $save = parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
        if ($save === false) {
            if ($this->avatarSuccess != null && $this->avatarSuccess != '') {
                foreach (Yii::$app->params['user-avatar'] as $info) {
                    $pathAvatar = Yii::getAlias('@backend/web' . $info['folder'] . $this->avatarSuccess);
                    if (!is_dir($pathAvatar) && file_exists($pathAvatar)) {
                        @unlink($pathAvatar);
                    }
                }
            }
            if ($this->coverSuccess != null && $this->coverSuccess != '') {
                foreach (Yii::$app->params['user-cover'] as $info) {
                    $pathCover = Yii::getAlias('@backend/web' . $info['folder'] . $this->coverSuccess);
                    if (!is_dir($pathCover) && file_exists($pathCover)) {
                        @unlink($pathCover);
                    }
                }
            }
        }
        return $save;
    }

    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::class, ['id' => 'user_id']);
    }

    public function getAvatar($size = null)
    {
        if ($this->avatar == null) return null;
        $params = Yii::$app->params;
        if ($size == null || !array_key_exists($size, $params['user-avatar'])) $size = array_keys($params['user-avatar'])[0];
        $pathAvatar = Yii::getAlias('@backend/web') . $params['user-avatar'][$size]['folder'] . $this->avatar;
        if (!is_dir($pathAvatar) && file_exists($pathAvatar)) return Yii::$app->assetManager->publish($pathAvatar)[1];
        return null;
    }

    public function getCover($size = null)
    {
        if ($this->cover == null) return null;
        $params = Yii::$app->params;
        if ($size == null || !array_key_exists($size, $params['user-cover'])) $size = array_keys($params['user-cover'])[0];
        $pathAvatar = Yii::getAlias('@backend/web') . $params['user-cover'][$size]['folder'] . $this->cover;
        if (!is_dir($pathAvatar) && file_exists($pathAvatar)) return Yii::$app->assetManager->publish($pathAvatar)[1];
        return null;
    }
}