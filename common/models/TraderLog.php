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
                [['wxid'], 'required'],
                [['channel', 'fan_img_url'], 'string'],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'wxid' => '微信号',
                'fan_count' => '粉丝变动数',
                'logdate' => '考勤日期',
            ];
        }

        public function getUser()
        {
            return $this->hasOne(TraderList::class, ['id' => 'id']);
        }

    }
