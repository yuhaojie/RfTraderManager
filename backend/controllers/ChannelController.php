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
    class ChannelController extends AddonsBaseController
    {
        use CurdTrait;

        /**
         * @var string
         */
        public $modelClass = '\addons\RfTraderManager\common\models\TraderChannel';

        /**
         * 首页
         *
         * @return mixed
         */
        public function actionIndex()
        {
            $data = TraderChannel::find();
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

        public function actionAdd()
        {
            return $this->render($this->action->id);
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