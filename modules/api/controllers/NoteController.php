<?php

namespace app\modules\api\controllers;

use app\modules\api\resources\NoteResource;
use yii\filters\auth\HttpBearerAuth;
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

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];

        return $behaviors;
    }
}