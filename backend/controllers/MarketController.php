<?php
    namespace addons\RfTraderManager\backend\controllers;

    use common\components\CurdTrait;
    use common\controllers\AddonsBaseController;
    use addons\RfSignShoppingDay\common\models\Award;
    use common\enums\StatusEnum;
    use yii\data\Pagination;

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
        public $modelClass = '\addons\RfTrader\common\models\TraderLog';

        /**
         * 首页
         *
         * @return mixed
         */
        public function actionIndex()
        {
            $data = TraderLog::find();
            $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => $this->pageSize]);
            $models = $data->offset($pages->offset)
                           ->orderBy('id desc')
                           ->limit($pages->limit)
                           ->all();

            return $this->render($this->action->id, [
                'models' => $models,
                'pages' => $pages,
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