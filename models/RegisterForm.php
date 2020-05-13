<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * Class RegisterForm
 * @package app\modules\api\models
 */
class RegisterForm extends CommonAuthForm
{
    /** @var string */
    public $password_repeat;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password_repeat', 'required'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Username must be unique']
        ]);
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
            $this->_user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $this->_user->access_token = Yii::$app->security->generateRandomString(255);

            return $this->_user->save();
        }

        return false;
    }
}