<?php
use yii\grid\GridView;
use common\helpers\AddonUrl;
use common\helpers\AddonHtmlHelper;

$this->title = '渠道管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <?= AddonHtmlHelper::create(['edit']); ?>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //重新定义分页样式
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false, // 不显示#
                        ],
                        [
                        		'label' => 'ID',
                        		'attribute' => 'id',
                        		'filter' => false,
						],
                        [
                            'label' => '姓名',
                            'attribute' => 'traderList.name',
                            'filter' => true, //不显示搜索框
                            'format' => 'text'
                            //'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        [
                            'label' => '微信名',
                            'attribute' => 'traderList.wxname',
                            'filter' => true, //不显示搜索框
                            'format' => 'text'
                            //'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        'wxid',
                        [
                            'label' => '渠道信息',
                            'attribute' => 'channels',
                            'filter' => false,
                        ],
                        'fansum',
                        [
                            'label' => '考勤图片',
                            'attribute' => 'record_image',
                            'filter' => false, //不显示搜索框
                            //'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        [
                            'label'=> '创建日期',
                            'attribute' => 'created_at',
                            'filter' => false, //不显示搜索框
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        [
                            'label'=> '更新日期',
                            'attribute' => 'updated_at',
                            'filter' => false, //不显示搜索框
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template'=> '{edit} {status} {delete}',
                            'buttons' => [
                                'edit' => function ($url, $model, $key) {
                                    return AddonHtmlHelper::edit(['edit', 'id' => $model->id]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return AddonHtmlHelper::delete(['hide', 'id' => $model->id]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>