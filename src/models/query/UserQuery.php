<?php

namespace modava\auth\models\query;

use modava\auth\models\User;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    public function findUser()
    {
        $this->andWhere(['not in', 'user.id', \Yii::$app->user->id]);
//        $this->andWhere(['in', 'created_by', User::getChild(\Yii::$app->user->id)]);
        return $this;
    }

    public function notDeleted()
    {
        $this->andWhere(['!=', 'status', User::STATUS_DELETED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }
}