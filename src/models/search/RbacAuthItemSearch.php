<?php

namespace modava\auth\models\search;

use dosamigos\arrayquery\ArrayQuery;
use modava\auth\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modava\auth\models\RbacAuthItem;
use yii\data\ArrayDataProvider;
use yii\rbac\Item;

/**
 * RbacAuthItemSearch represents the model behind the search form of `modava\auth\models\RbacAuthItem`.
 */
class RbacAuthItemSearch extends RbacAuthItem
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['name', 'description', 'rule_name', 'data'], 'safe'],
            [['type', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = RbacAuthItem::find();
        if(!Yii::$app->user->can(User::DEV)) $query->andWhere(['<>', 'type' => self::TYPE_ROLE]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'rule_name', $this->rule_name])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }

    public function searchRole(array $params): ArrayDataProvider
    {
        $authManager = Yii::$app->getAuthManager();

        if ($this->type == Item::TYPE_ROLE) {
            $result = Yii::$app->getAuthManager()->getAssignments(Yii::$app->user->id);
            foreach ($result as $roleName) {
                $roleNames = $roleName->roleName;
            }

            $items = $authManager->getChildRoles($roleNames);
        } elseif
        ($this->type == Item::TYPE_PERMISSION) {
            $items = $authManager->getPermissions();
        }

        $query = new ArrayQuery($items);

        $this->load($params);

        if ($this->validate()) {
            $query->addCondition('name', $this->name ? "~{$this->name}" : null)
                ->addCondition('rule_name', $this->rule_name ? "~{$this->rule_name}" : null)
                ->addCondition('description', $this->description ? "~{$this->description}" : null);
        }

        return new ArrayDataProvider([
            'allModels' => $query->find(),
            'sort' => [
                'attributes' => ['name'],
            ],
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
    }
}
