<?php

namespace modava\auth\models\query;

use modava\auth\models\UserOtp;

/**
 * This is the ActiveQuery class for [[UserOtp]].
 *
 * @see UserOtp
 */
class UserOtpQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([UserOtp::tableName() . '.status' => UserOtp::STATUS_ACTIVE]);
    }

    public function notactive()
    {
        return $this->andWhere([UserOtp::tableName() . '.status' => UserOtp::STATUS_NOT_ACTIVE]);
    }

    public function sortDescById()
    {
        return $this->orderBy([UserOtp::tableName() . '.id' => SORT_DESC]);
    }
}
