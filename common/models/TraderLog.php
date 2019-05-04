<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/30
     * Time: 14:50
     */
    namespace addons\RfTraderManager\common\models;

    use Yii;

    class TraderLog extends \common\models\common\BaseModel
    {
        public $bSave;

        public function __construct()
        {
            $channels = TraderChannel::getList();
            if(isset($channels))
            {
                foreach ($channels as $value)
                {
                    $var = 'channel' . $value->id;
                    $this->$var = 0;
                }
            }
        }

        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%addon_trader_log}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            $myrules = [
                [['tid', 'wxid'], 'required'],
                [['channels', 'record_image'], 'string'],
                [['traderList.name','traderList.wxname'], 'safe'],
            ];

            $channels = TraderChannel::getList();
            if(isset($channels))
            {
                foreach ($channels as $value)
                {
                    $myrules[] = [
                        ['channel' . $value->id],
                        'safe'];
                }
            }

            return $myrules;
        }

        public function attributes()
        {
            $attributes = parent::attributes();
            $channels = TraderChannel::getList();

            if($this->bSave == false)
            {
                if (isset($channels))
                {
                    foreach ($channels as $value)
                    {
                        $attributes[] = 'channel' . $value->id;
                    }
                }
            }

            return $attributes;
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            $channels = TraderChannel::getList();

            $labels = [
                'id' => 'ID',
                'tid' => '帐号',
                'wxid' => '微信号',
                'channels' => '渠道信息',
                'fansum' => '粉丝数',
                'record_image' => '考勤图片',
                'created_at' => '创建时间',
                'updated_at' => '修改时间',
            ];

            if(isset($channels))
            {
                foreach ($channels as $value)
                {
                    $labels['channel' . $value->id] = $value->name;
                }
            }

            return $labels;
        }

        public function getTraderList()
        {
            return $this->hasOne(TraderList::class, ['id' => 'tid']);
        }

        static public function getCount()
        {
            $count = (new \yii\db\Query())->select(['*'])
                ->from(self::tableName())
                ->count();
        }

        public function save($runValidation = true, $attributeNames = null)
        {
            $this->bSave = true;
//            $this->id = TraderLog::getCount();
            parent::save($runValidation, $attributeNames);
            $this->bSave = false;
        }
    }
