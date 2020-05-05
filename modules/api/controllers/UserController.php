<?php

namespace app\modules\api\controllers;

use app\modules\api\resources\UserResource;
use app\modules\api\models\LoginForm;
use app\modules\api\models\SignUpForm;
use yii\rest\Controller;
use Yii;

/**
 * Class UserController
 * @package app\modules\api\controllers
 */
class UserController extends Controller
{
    /**
     * Аутентификация пользователя
     * @return UserResource|array|null
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $model->getUser();
        }

        Yii::$app->response->statusCode = 422;

        return ['errors' => $model->errors];
    }

    /**
     * Регистрация пользователя
     * @return array|bool
     */
    public function actionSignup()
    {
        $model = new SignUpForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->register()) {
            return $model->_user;
        }

        Yii::$app->response->statusCode = 422;

        return ['errors' => $model->errors];
    }
}