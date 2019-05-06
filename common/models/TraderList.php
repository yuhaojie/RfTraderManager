<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019/4/30
     * Time: 14:50
     */
    namespace addons\RfTraderManager\common\models;

    use Yii;
    use yii\web\NotFoundHttpException;

    class TraderList extends \common\models\common\BaseModel
    {
        public $bSave;
        public $passcode;
        public $auth_key;

        protected $authAssignment;

        /**
         * {@inheritdoc}
         */
        public function __construct()
        {
            $this->bSave = false;
//            $this->passcode = '123456';
        }

        public static function tableName()
        {
            return '{{%addon_trader_list}}';
        }

        /**
         * {@inheritdoc}
         */
        public function rules()
        {
            $rs = [
                [['name', 'wxname', 'password'], 'required'],
                [['department', 'phone'], 'string'],
                [['password'], 'string']
            ];

            if(!$this->bSave)
            {
                $rs[] = [['passcode'], 'required'];
            }

            return $rs;
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels()
        {
            $lbs = [
                'id' => 'ID',
                'name' => '姓名',
                'wxname' => '微信名',
                'department' => '部门',
                'phone' => '电话',
            ];

            if(!$this->bSave)
            {
                $lbs['passcode'] = '密码';
            }

            return $lbs;
        }

        public function attributes()
        {
            $attrs = parent::attributes();

            if($this->bSave == false)
            {
                $attrs[] = 'passcode';
            }

            return $attrs;
        }

        static public function getList()
        {
            $query = self::find();
//            $count = $query->count();
            return $query->select(['id', 'name', 'wxname'])->all();
        }

        public function save($runValidation = true, $attributeNames = null)
        {
            $this->bSave = true;
            //            $this->id = TraderLog::getCount();
            parent::save($runValidation, $attributeNames);
            $this->bSave = false;
        }

        public function saveData()
        {
            $transaction = Yii::$app->db->beginTransaction();

            try
            {
                // 验证密码是否修改
                if ($this->password != $this->passcode)
                {
                    $this->password = Yii::$app->security->generatePasswordHash($this->passcode);
                }

                if (!$this->save())
                {
                    //$this->addErrors($this->getErrors());
                    if(!empty($model->errors))
                        throw new NotFoundHttpException('用户编辑错误');
                }

                // 验证超级管理员
                if ($this->id == Yii::$app->params['adminAccount'])
                {
                    $transaction->commit();
                    return true;
                }

                /*
                $authAssignment = $this->authAssignment;
                $authAssignment->user_id = $this->id;
                $authAssignment->item_name = (AuthItem::findOne(['key' => $this->auth_key]))->name;
                $authAssignment->save();
                if (!$authAssignment->save())
                {
                    $this->addErrors($authAssignment->getErrors());
                    throw new NotFoundHttpException('权限写入错误');
                }
                */

                $transaction->commit();
                return true;
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                return false;
            }
        }

        static public function loadData($id)
        {
            $TraderModel = TraderList::findOne($id);

            if ($TraderModel)
            {
                $TraderModel->passcode = $TraderModel->password;
            }
            else
            {
                $TraderModel = new TraderList();
                $TraderModel->passcode = '';
            }

            /*
            $TraderModel->authAssignment = AuthAssignment::find()
                                                  ->where(['user_id' => $TraderModel->id])
                                                  ->with('itemName')
                                                  ->one();

            if ($TraderModel->authAssignment)
            {
                $TraderModel->auth_key = $TraderModel->authAssignment->itemName->key;
            }
            else
            {
                $TraderModel->authAssignment = new AuthAssignment();
            }
            */

            return $TraderModel;
        }

    }
