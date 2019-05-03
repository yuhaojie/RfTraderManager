<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/30
     * Time: 14:50
     */
    namespace addons\RfTraderManager\common\models;
    use addons\RfTraderManager\common\models\TraderChannel;
    use yii\base\Model;
    use Yii;

    class Market extends Model
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%addon_market}}';
        }

        public function attributes ()
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
        public function rules()
        {
            return [
                [['wxid'], 'required'],
                [['channels', 'record_image'], 'string'],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'name' => '姓名',
                'wxname' => '微信名',
                'wxid' => '微信号',
                'channels' => '渠道信息',
                'fansum' => '粉丝数',
                'record_image' => '考勤图片',
                'created_at' => '创建时间',
                'updated_at' => '修改时间',
            ];
        }
/*
        public function getTraderList()
        {
            return $this->hasOne(TraderList::class, ['id' => 'id']);
        }
*/
        static public function find()
        {
            $query = (new \yii\db\Query())->select(['u.name', 'u.wxname', 'r.*']);
            $query->from(['u' => TraderList::tableName(), 'r' => TraderLog::tableName()]);
            $query->where(['u.id' => 'r.id']);
        }

        static public function search()
        {
            $query = self::find();
            $model = $query->select(['ro.*', 'u.name', 'u.wxname'])->all();
        }
    }
