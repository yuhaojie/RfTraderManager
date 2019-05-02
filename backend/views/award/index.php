<?php
use common\helpers\AddonHtmlHelper;
use yii\widgets\LinkPager;
use common\helpers\AddonUrl;

$this->title = '奖品管理';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    当前有效的奖品概率为: <?= $prob ?>/1000
                    <?= AddonHtmlHelper::create(['edit'], '创建'); ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>标题</th>
                        <th>类别</th>
                        <th>排序</th>
                        <th>中奖几率</th>
                        <th>剩余/总量</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($models as $model){ ?>
                        <tr id = <?= $model->id; ?>>
                            <td><?= $model->id; ?></td>
                            <td><?= $model->title; ?></td>
                            <td><?= $model->cate_id == 1 ? '<span class="label label-primary">积分</span>' : '<span class="label label-info">卡卷</span>'; ?></td>
                            <td class="col-md-1"><?= AddonHtmlHelper::sort($model['sort']); ?></td>
                            <td><?= $model->prob; ?></td>
                            <td><?= $model->surplus_num; ?>/<?= $model->all_num; ?></td>
                            <td>
                                <?= AddonHtmlHelper::edit(['edit', 'id' => $model['id']]); ?>
                                <?= AddonHtmlHelper::status($model['status']); ?>
                                <?= AddonHtmlHelper::delete(['delete', 'id' => $model['id']]); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <?= LinkPager::widget([
                    'pagination' => $pages
                ]);?>
            </div>
        </div>
    </div>
</div>