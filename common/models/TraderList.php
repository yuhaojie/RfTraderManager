<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/30
     * Time: 14:50
     */
    namespace addons\RfTraderManager\common\models;

    use Yii;

    class TraderList extends \common\models\common\BaseModel
    {
        /**
         * {@inheritdoc}
         */
        public static function tableName()
        {
            return '{{%addon_trader_list}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            return [
                [['name', 'wxname'], 'required'],
                [['department', 'phone'], 'string'],
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
                'department' => '部门',
                'phone' => '电话',
            ];
        }

        static public function getList()
        {
            $query = self::find();
//            $count = $query->count();
            return $query->select(['id', 'name', 'wxname'])->all();
        }
    }
