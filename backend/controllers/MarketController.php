<?php
    namespace addons\RfTraderManager\backend\controllers;

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

            if ($model->load($request->post()) && $model->save())
            {
                return $this->redirect(['index']);
            }

            return $this->render($this->action->id, [
                'model' => $model,
                'traderList' => TraderList::getList(),
                'channelList' => TraderChannel::getList()
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