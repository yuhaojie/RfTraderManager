<?php
    namespace addons\RfTraderManager\backend\controllers;

    use addons\RfArticle\common\models\Article;
    use addons\RfArticle\common\models\ArticleCate;
    use common\components\CurdTrait;
    use common\controllers\AddonsBaseController;
    use addons\RfTraderManager\common\models\TraderChannel;
    use common\enums\StatusEnum;
    use common\models\common\SearchModel;
    use yii\data\Pagination;
    use yii;

    /**
     * Class AwardController
     * @package addons\RfTrader\backend\controllers
     * @author jianyan74 <751393839@qq.com>
     */
    class ChannelController extends AddonsBaseController
    {
        use CurdTrait;

        /**
         * @var string
         */
        public $modelClass = '\addons\RfTraderManager\common\models\TraderChannel';

        public function actionIndex()
        {
            $searchModel = new SearchModel([
                'model' => TraderChannel::class,
                'scenario' => 'default',
                'partialMatchAttributes' => ['name'], // 模糊查询
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'pageSize' => $this->pageSize
            ]);

            $dataProvider = $searchModel
                ->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['>=', 'status', StatusEnum::DISABLED]);

            return $this->render($this->action->id, [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        }

        public function actionEdit()
        {
            $request = Yii::$app->request;
            $id = $request->get('id', null);
            $model = $this->findModel($id);

            if ($model->load($request->post()) && $model->save())
            {
                return $this->redirect(['index']);
            }

            return $this->render($this->action->id, [
                'model' => $model
            ]);
        }

        public function actionShow($id)
        {
            $model = $this->findModel($id);
            $model->status = StatusEnum::ENABLED;
            if ($model->save())
            {
                return $this->message("还原成功", $this->redirect(['recycle']));
            }

            return $this->message("还原失败", $this->redirect(['recycle']), 'error');
        }

        /**
         * 删除
         *
         * @param $id
         * @return mixed
         */
        public function actionHide($id)
        {
            $model = $this->findModel($id);
            $model->status = StatusEnum::DELETE;
            if ($model->save())
            {
                return $this->message("删除成功", $this->redirect(['index']));
            }

            return $this->message("删除失败", $this->redirect(['index']), 'error');
        }

        /**
         * 回收站
         *
         * @return mixed
         */
        public function actionRecycle()
        {
            $data = Article::find()->where(['<', 'status', StatusEnum::DISABLED]);
            $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->pageSize]);
            $models = $data->offset($pages->offset)
                ->orderBy('id desc')
                ->limit($pages->limit)
                ->all();

            return $this->render($this->action->id, [
                'models' => $models,
                'pages' => $pages
            ]);
        }

        public function actionRecord($cname)
        {
            $traderChl = TraderChannel::findOne(['name' => $cname]);
            if (!$traderChl)
            {
                $traderChl = new TraderChannel();
                $traderChl->name = $cname;
                $traderChl->save();
                if (!$traderChl->save())
                {
                    VarDumper::dump($traderChl->errors);
                    exit;
                }
            }

            $this->redirect(\Yii::$app->urlManager->createUrl(['channel/index']))->send();
        }
    }