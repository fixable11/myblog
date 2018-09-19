<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Article;
use yii\data\Pagination;

/**
 * ArticleSearch represents the model behind the search form of `app\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'viewed', 'user_id', 'status', 'category_id'], 'integer'],
            [['title', 'description', 'content', 'date', 'image', 'category.title'], 'safe'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['category.title']);
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
        $query = Article::find();

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
          'category' => function($query){
            $query->from(['category' => 'category']);
          }
        ]);
        $dataProvider->sort->attributes['category.title'] = [
          'asc' => ['category.title' => SORT_ASC],
          'desc' => ['category.title' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'viewed' => $this->viewed,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'category.title', $this->getAttribute('category.title')]);

        return $dataProvider;
    }
    
    public function fulltextSearch($keyword)
    {
      $keyword = addslashes(htmlspecialchars($keyword));
      $limit = Yii::$app->params['searchLimit'];
      
      $sql = "SELECT * FROM article"
      . " WHERE MATCH (content,title,description) AGAINST ('{$keyword}')";

      
      $query = Article::findBySql($sql);
      $count = $query->count();
      $pagination = new Pagination([
          'totalCount' => $count, 
          'pageSize' => $limit
      ]);
      
      $sql .= "LIMIT {$pagination->limit} OFFSET {$pagination->offset}";
      $articles = Article::findBySql($sql)->with('author')->all();

      $data['articles'] = $articles;
      $data['pagination'] = $pagination;
      
      return $data;
    }
}
