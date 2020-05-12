<?php

namespace app\modules\api\controllers;

use app\modules\api\resources\UserResource;
use app\modules\api\models\LoginForm;
use app\modules\api\models\RegisterForm;
use yii\filters\Cors;
use yii\rest\Controller;
use Yii;
use yii\web\UnauthorizedHttpException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->register()) {
            return $model->_user;
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

        $user = UserResource::findIdentityByAccessToken($accessToken);

        if (!$user) {
            throw new UnauthorizedHttpException();
        }

        return $user;
    }
}