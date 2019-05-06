<?php
    namespace addons\RfTraderManager\backend\controllers;

    use addons\RfArticle\common\models\Article;
    use common\components\CurdTrait;
    use common\controllers\AddonsBaseController;
    use addons\RfTraderManager\common\models\TraderList;
    use common\enums\StatusEnum;
    use common\models\common\SearchModel;
    use yii\data\Pagination;
    use yii;

    /**
     * Class AwardController
     * @package addons\RfTrader\backend\controllers
     * @author jianyan74 <751393839@qq.com>
     */
    class TraderController extends AddonsBaseController
    {
        use CurdTrait;

        /**
         * @var string
         */
        public $modelClass = '\addons\RfTraderManager\common\models\TraderList';

        /**
         * 首页
         *
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel = new SearchModel([
                'model' => TraderList::class,
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
            $model = TraderList::loadData($id);

            if ($model->load($request->post()))
            {
//                $model->saveData();
                if (!$model->saveData()) {
                    return $this->render('error', ['errors' => $model->getErrors()]);
                }

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
            $model->password = '123456';
            $model->passcode = '123456';

            if ($model->save() || empty($model->getErrors()))
            {
                return $this->message("删除成功", $this->redirect(['index']));
            }
            else
            {
                return $this->render('error', ['errors' => $model->errors]);
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

        public function actionLogin($tname, $tdepartment, $tphone)
        {
            $trader = TraderList::findOne(['name' => $tname]);
            if (!$trader)
            {
                $trader = new TraderList();
                $trader->name = $tname;
                $trader->department = $tdeparment;
                $trader->phone = $tphone;
                $trader->save();
                if (!$trader->save())
                {
                    VarDumper::dump($trader->errors);
                    exit;
                }
            }

            $this->redirect(\Yii::$app->urlManager->createUrl(['trader/index']))->send();
        }

        public function actionLogout()
        {
            $url = $_COOKIE['TraderLoginUrl'];
            \Yii::$app->response->redirect($url)->send();
            \Yii::$app->end();
        }
    }