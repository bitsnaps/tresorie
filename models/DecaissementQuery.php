<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Decaissement]].
 *
 * @see Decaissement
 */
class DecaissementQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Decaissement[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Decaissement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}