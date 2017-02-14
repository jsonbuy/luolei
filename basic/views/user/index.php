<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="upFileImg">
	<?= $form->field($model, 'file')->fileInput(['class'=>'upFile']) ?>
</div>
<button>Submit</button>
<?php ActiveForm::end() ?>
