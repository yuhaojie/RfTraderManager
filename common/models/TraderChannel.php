<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/30
     * Time: 14:50
     */
    namespace addons\RfTraderManager\common\models;
    use common\enums\StatusEnum;

    use Yii;

    class TraderChannel extends \common\models\common\BaseModel
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%addon_trader_channel}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                [['name'], 'required'],
                [['status', 'updated_at'], 'integer'],
                [['created_at'], 'safe'],
                [['name'], 'string', 'max' => 50],
                [['icon'], 'string', 'max' => 100],
                [['description'], 'string', 'max' => 140],
            ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'name' => '渠道名',
            ];
        }

        static public function getList()
        {
            $query = self::find();
            //            $count = $query->count();
            return $query->select(['id', 'name'])->andWhere(['>=', 'status', StatusEnum::DISABLED])->all();
        }
    }
