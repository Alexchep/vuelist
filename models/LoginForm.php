<?php

namespace app\models;

use Yii;

/**
 * Class LoginForm
 * @package app\models
 */
class LoginForm extends CommonAuthForm
{
    /** @var bool */
    public $rememberMe = true;

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean']
        ]);
    }

    /**
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
}