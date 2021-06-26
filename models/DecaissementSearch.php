<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Decaissement;

/**
 * DecaissementSearch represents the model behind the search form of `app\models\Decaissement`.
 */
class DecaissementSearch extends Decaissement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_user', 'status_admin', 'user_id'], 'integer'],
            [['date_demande', 'motif', 'piece_jointe'], 'safe'],
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
        //Admin peut voir tous les decaissement
        $query = Decaissement::find();
        //Decaissement pour Aprobateur filtrer celon son pallier
        if(User::isAprobateur(User::getCurrentUser()->id)){
            $grade=Grade::find(['user_id'=>User::getCurrentUser()->id])->one();
            $query=Decaissement::find(['user_id'=>User::getCurrentUser()->id])
          //      ->innerJoin('grade', 'grade.user_id = decaissement.user_id ')
                ->where(['<=','decaissement.montant',$grade->montant])
             ;
        }
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      //  print_r($dataProvider );
       // die();

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
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'motif', $this->motif])
            ->andFilterWhere(['like', 'piece_jointe', $this->piece_jointe]);

        return $dataProvider;
    }
    public function searchMyDemande($params,$user_id)
    {
        $query = Decaissement::find();

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
            'user_id' => $user_id,
        ]);

        $query->andFilterWhere(['like', 'motif', $this->motif])
            ->andFilterWhere(['like', 'piece_jointe', $this->piece_jointe]);

        return $dataProvider;
    }
}
