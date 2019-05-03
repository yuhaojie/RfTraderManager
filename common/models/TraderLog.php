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
            return [
                [['id', 'wxid'], 'required'],
                [['channels', 'record_image'], 'string'],
                [['traderList.name','traderList.wxname'], 'safe'],
            ];
        }

        public function attributes()
        {
            $attributes = parent::attributes();
            $channels = TraderChannel::getList();
            foreach($channels as $value)
            {
                $attributes[] = $value->name;
            }
            return $attributes;
        }
        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'wxid' => '微信号',
                'channels' => '渠道信息',
                'fansum' => '粉丝数',
                'record_image' => '考勤图片',
                'created_at' => '创建时间',
                'updated_at' => '修改时间',
            ];
        }

        public function getTraderList()
        {
            return $this->hasOne(TraderList::class, ['id' => 'id']);
        }

    }
