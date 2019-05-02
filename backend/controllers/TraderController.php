<?php
    namespace addons\RfTraderManager\backend\controllers;

    use common\components\CurdTrait;
    use common\controllers\AddonsBaseController;
    use addons\RfTraderManager\common\models\TraderList;
    use common\enums\StatusEnum;
    use yii\data\Pagination;

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
            $data = TraderList::find();
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

        public function actionLogon()
        {
            return $this->render($this->action->id);
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