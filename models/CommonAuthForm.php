<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class CommonAuthForm
 * @package app\models
 */
abstract class CommonAuthForm extends Model
{
    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var User */
    protected $_user = false;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required']
        ];
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