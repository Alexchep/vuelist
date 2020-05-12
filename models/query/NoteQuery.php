<?php

namespace app\models\query;

use yii\db\ActiveQuery;
use app\models\Note;

/**
 * This is the ActiveQuery class for [[\app\models\Note]].
 *
 * @see Note
 */
class NoteQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Note[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Note|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $id
     * @return NoteQuery
     */
    public function byUser($id)
    {
        return $this->andWhere(['created_by' => $id]);
    }
}