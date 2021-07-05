<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\base\Decaissement;
use yii\web\NotFoundHttpException;

/**
 * DecaissementSearch represents the model behind the search form of `app\models\Decaissement`.
 */
class DecaissementSearch extends Decaissement
{
    public $utilisateur;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_user', 'status_admin'], 'integer'],
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
     * @return \yii\db\ActiveQuery
     */
     public function getDecaissment()
     {
         return $this->hasOne(\app\models\Decaissement::className(), ['id' => 'decaissment_id']);
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
        if(User::isAdmin()){
        $query = Decaissement::find();
        $query->joinWith('senderUser');
        }
        if(User::isAprobateur()){
        
             $grade=Grade::find()->where(['user_id'=>User::getCurrentUser()->id])->one();
             if($grade){
                $query = Decaissement::find()
                   ->where(['<=','decaissement.montant',$grade->montant]);
             }else{
                throw new \yii\web\NotFoundHttpException(\Yii::t('app', 'Vous n\'aver pas eu un grade attender que l\'admin vous attribue un grade'));
             }
             $query->joinWith('senderUser');
  

        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'montant' => $this->montant,
            'status_user' => $this->status_user,
            'status_admin' => $this->status_admin,
            'sender_user_id' => $this->sender_user_id,
        ]);

        $query->andFilterWhere(['like', 'motif', $this->motif])
            ->andFilterWhere(['like', 'piece_jointe', $this->piece_jointe])
            ->andFilterWhere(['like', 'user.username', $this->utilisateur])
            ->andFilterWhere(['like',  'date_demande' , $this->date_demande])
            ;

        return $dataProvider;
    }
    public function searchDemandesUtilisateur($params,$user_id)
    {

    

            $query = Decaissement::find()
            ->andWhere(['>=','sender_user_id',$user_id])
            ;
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
                'sender_user_id' => $user_id,
            ]);
    
            $query->andFilterWhere(['like', 'motif', $this->motif])
                ->andFilterWhere(['like', 'piece_jointe', $this->piece_jointe])
                ->andFilterWhere(['like', 'user.username', $this->utilisateur])
                ->andFilterWhere(['like',  'date_demande' , $this->date_demande])
                ;
    
    
            return $dataProvider;

      
    }
}