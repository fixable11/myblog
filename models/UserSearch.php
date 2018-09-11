<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
  
    public $roles;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isAdmin', 'fb_uid'], 'integer'],
            [['username', 'email', 'password', 'photo', 'last_name', 'photo_rec', 'auth_key', 'password_reset_token', 'roles', 'relatedRoles.item_name'], 'safe'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['relatedRoles.item_name']);
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
              'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->joinWith([
          'relatedRoles' => function($query){
            $query->from(['relatedRoles' => 'auth_assignment']);
          }
        ]);
        $dataProvider->sort->attributes['relatedRoles.item_name'] = [
          'asc' => ['relatedRoles.item_name' => SORT_ASC],
          'desc' => ['relatedRoles.item_name' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'isAdmin' => $this->isAdmin,
            'fb_uid' => $this->fb_uid,
            //'roles.ss' => 'moderator',
        ]);
        
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'photo_rec', $this->photo_rec])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'relatedRoles.item_name', $this->getAttribute('relatedRoles.item_name')]);

        return $dataProvider;
    }
}
