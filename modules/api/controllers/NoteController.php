<?php

namespace app\modules\api\controllers;

use app\modules\api\resources\NoteResource;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

/**
 * Class NoteController
 * @package app\modules\api\controllers
 */
class NoteController extends ActiveController
{
    /** @var string */
    public $modelClass = NoteResource::class;

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $auth = $behaviors['authenticator'];

        $auth['authMethods'] = [HttpBearerAuth::class];

        unset($behaviors['authenticator']);

        $behaviors['cors'] = ['class' => Cors::class];

        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->modelClass::find()->byUser(\Yii::$app->user->id)
        ]);
    }
}