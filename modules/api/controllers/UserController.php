<?php

namespace app\modules\api\controllers;

use app\models\User;
use app\models\LoginForm;
use app\models\RegisterForm;
use yii\filters\Cors;
use yii\rest\Controller;
use Yii;
use yii\web\UnauthorizedHttpException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Exception;

/**
 * Class UserController
 * @package app\modules\api\controllers
 */
class UserController extends Controller
{
    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), ['cors' => Cors::class]);
    }

    /**
     * Аутентификация пользователя
     * @return User|array|null
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
     * @return array|ActiveRecord
     * @throws Exception
     */
    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->register()) {
            return $model->getUser();
        }

        Yii::$app->response->statusCode = 422;

        return ['errors' => $model->errors];
    }

    /**
     * @return array|ActiveRecord|IdentityInterface
     * @throws UnauthorizedHttpException
     */
    public function actionGetData()
    {
        $headers = Yii::$app->request->headers;

        if (!isset($headers['Authorization'])) {
            throw new UnauthorizedHttpException();
        }

        $accessToken = explode(' ', $headers['Authorization'])[1];

        $user = User::findIdentityByAccessToken($accessToken);

        if (!$user) {
            throw new UnauthorizedHttpException();
        }

        return $user;
    }
}