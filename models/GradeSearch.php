<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grade;

/**
 * GradeSearch represents the model behind the search form of `app\models\Grade`.
 */
class GradeSearch extends Grade
{
    public $userID;
    public $roleID;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
      
            [['roleID','userID','role_id','user_id','niveau'], 'safe'],
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
        $query = Grade::find();
        $query->joinWith('user');
        $query->joinWith('role');

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
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'montant' => $this->montant,
        ]);
      
        $query
        ->andFilterWhere(['like', 'niveau', $this->niveau])
        ->andFilterWhere(['like', 'user.username', $this->userID])
        ->andFilterWhere(['like', 'role.role_name', $this->roleID])
        ;

        return $dataProvider;
    }
}
