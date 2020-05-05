<?php

namespace app\modules\api\models;

use app\modules\api\resources\UserResource;
use yii\db\ActiveRecord;

/**
 * Class LoginForm
 * @package app\modules\api\models
 */
class LoginForm extends \app\models\LoginForm
{
    /**
     * Finds user by [[username]]
     *
     * @return array|bool|ActiveRecord
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UserResource::findByUsername($this->username);
        }

        return $this->_user;
    }
}