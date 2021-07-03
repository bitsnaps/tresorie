<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `app\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    public $utilisateur;
    public $motif;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'decaissement_id'], 'integer'],
            [['utilisateur','motif','date_transaction'], 'safe'],
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
        $query = Transaction::find();
      
        $query->joinWith(['decaissement' => function($query) {
            $query->joinWith('senderUser') ;
            
        }]);
        
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
         //   'date_transaction' => $this->date_transaction,
           'montant' => $this->montant,
           

         //   'decaissment_id' => $this->decaissment_id ,
        ]);
        $query
        ->andFilterWhere(['like',   'transaction.montant' , $this->montant])
        ->andFilterWhere(['like',   'user.username' , $this->utilisateur])
        ->andFilterWhere(['like',   'decaissement.motif' , $this->motif])
        ->andFilterWhere(['like',   'date_transaction' , $this->date_transaction])
        //->andFilterWhere(['like', 'piece_jointe', $this->piece_jointe])
        //->andFilterWhere(['like', 'user.username', $this->utilisateur])
        ;

        return $dataProvider;
    }
}
