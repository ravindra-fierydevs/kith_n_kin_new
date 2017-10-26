<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FoodItem */

$this->title = 'Update Food Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Food Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="food-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'menu_categories' => $menu_categories,
    ]) ?>

</div>
