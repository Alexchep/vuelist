<?php

namespace app\modules\api\models;

use app\modules\api\resources\UserResource;
use yii\base\Model;
use app\models\User;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Class SignUpForm
 * @package app\modules\api\models
 */
class SignUpForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;

    public $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
            ['username', 'unique', 'targetClass' => UserResource::class, 'message' => 'Username must be unique']
        ];
    }

    /**
     * Регистрация
     * @return bool
     * @throws Exception
     */
    public function register()
    {
        $this->_user = new User();

        if ($this->validate()) {
            $this->_user->username = $this->username;
            $this->_user->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
            $this->_user->access_token = \Yii::$app->security->generateRandomString(255);

            return $this->_user->save();
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return array|ActiveRecord
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}