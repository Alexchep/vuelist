<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\helpers\Console;
use yii\base\Exception;

/**
 * Class AppController
 * @package app\commands
 */
class AppController extends Controller
{
    /**
     * Добавить пользователя
     * @param $username
     * @param $password
     * @throws Exception
     */
    public function actionAddUser($username, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->password_hash = \Yii::$app->security->generatePasswordHash($password);
        $user->access_token = \Yii::$app->security->generateRandomString(255);

        if ($user->save()) {
            Console::output('Saved');
        } else {
            var_dump($user->errors);
            Console::output('Error');
        }
    }
}
