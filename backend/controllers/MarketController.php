<?php
    namespace addons\RfTraderManager\backend\controllers;

    use addons\RfArticle\common\models\Article;
    use common\components\CurdTrait;
    use common\controllers\AddonsBaseController;
    use addons\RfTraderManager\common\models\TraderLog;
    use addons\RfTraderManager\common\models\TraderList;
    use addons\RfTraderManager\common\models\TraderChannel;
    use addons\RfTraderManager\common\models\Market;
    use common\enums\StatusEnum;
    use common\models\common\SearchModel;
    use yii\data\Pagination;
    use yii;

    /**
     * Class AwardController
     * @package addons\RfTrader\backend\controllers
     * @author jianyan74 <751393839@qq.com>
     */
    class MarketController extends AddonsBaseController
    {
        use CurdTrait;

        /**
         * @var string
         */
        public $modelClass = '\addons\RfTraderManager\common\models\TraderLog';

        /**
         * 首页
         *
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel = new SearchModel([
                'model' => TraderLog::class,
                'scenario' => 'default',
                'partialMatchAttributes' => ['wxid'], // 模糊查询
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'pageSize' => $this->pageSize
            ]);

            $dataProvider = $searchModel
                ->search(Yii::$app->request->queryParams);
            //$dataProvider->query->andWhere(['>=', 'status', StatusEnum::DISABLED]);

            return $this->render($this->action->id, [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'traderList' => TraderList::getList()
            ]);
        }

        public function actionEdit()
        {
            $request = Yii::$app->request;
            $id = $request->get('id', null);
            $model = $this->findModel($id);
            $channels = TraderChannel::getList();

            foreach($channels as $value)
            {
//                $value->value = 0;
//                $model[$value->id] =$value->attributes;
//                $modle[$value->id]['value'] = 0;
//                $mode[$value->name] = 0;
                $chlarry[$value->name] = 0;
            }
            $model->setAttributes($chlarry, false);


            if ($model->load($request->post()) && $model->save())
            {
                return $this->redirect(['index']);
            }

            return $this->render($this->action->id, [
                'model' => $model,
                'traderList' => TraderList::getList(),
                'channelList' => $channels
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

        public function actionRecord($name, $wxid, $channels, $fancnt, $fanimg)
        {
            $bNewTrader = false;
            $user = TraderList::findOne([
                    'username' => $we7_user['username'],
                ]);

            if (!$user)
            {
                $user = new TraderList();
                $user->name = $we7_user['username'];
                $user->save();
                if (!$user->save())
                {
                    VarDumper::dump($user->errors);
                    exit;
                }
                $bNewTrader = true;
            }

            Yii::$app->user->login($user);

            $trader_log = TraderLog::findOne(['id' => $user->id, 'wxid' => $wxid]);
            if(!$trader_log)
            {
                $trader_log = new TraderLog();
            }

            $trader_log->id = $user->id;
            $trader_log->wxid = $wxid;
            $trader_log->channels = $channels;
            $trader_log->fansum = $fancnt;
            $trader_log->record_image = $fanimg;

            CommonActionLog::storeActionLog('', 'login', 0, [], $user->id);

            $this->redirect(\Yii::$app->urlManager->createUrl(['market/index']))->send();
        }
    }