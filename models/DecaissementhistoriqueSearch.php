<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Decaissementhistorique;

/**
 * DecaissementhistoriqueSearch represents the model behind the search form of `app\models\Decaissementhistorique`.
 */
class DecaissementhistoriqueSearch extends Decaissementhistorique
{
    public $utilisateur;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_user', 'status_admin', 'sender_user_id', 'reciever_user_id'], 'integer'],
            [['utilisateur','date_demande', 'motif', 'piece_jointe'], 'safe'],
            [['montant'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Decaissementhistorique::find();
        $query->joinWith('senderUser');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_demande' => $this->date_demande,
            'montant' => $this->montant,
            'status_user' => $this->status_user,
            'status_admin' => $this->status_admin,
            'sender_user_id' => $this->sender_user_id,
            'reciever_user_id' => $this->reciever_user_id,
        ]);

        $query->andFilterWhere(['like', 'motif', $this->motif])
            ->andFilterWhere(['like', 'piece_jointe', $this->piece_jointe])
            ->andFilterWhere(['like', 'user.username', $this->utilisateur]);

        return $dataProvider;
    }
}
