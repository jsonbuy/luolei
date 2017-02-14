<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<table class="adminTable" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>上传图片</td>
		<td>
			<div class="upFileBox">
				<?= $form->field($model, 'file')->fileInput() ?>
				<span class="inputFile"> upload</span>
			</div>
		</td>
	</tr>
	<tr>
		<td>图片描述</td>
		<td>
			<input class="inputText" autocomplete="off" name="title" type="text" placeholder="title" />
		</td>
	</tr>
	<tr>
		<td>链接地址</td>
		<td>
			<input class="inputText" autocomplete="off" name="imgurl" type="text" placeholder="path" />
		</td>
	</tr>
	<tr>
		<td></td>
		<td><button name="submit" class="btn btn-primary">Submit</button></td>
	</tr>
</table>
<?php ActiveForm::end() ?>

<table class="adminTable edibannerTable" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<th style="width: 180px">图片</th>
		<th>图片描述</th>
		<th>图片链接</th>
		<th style="width: 100px">编辑</th>
		<th style="width: 100px">删除</th>
	</tr>
	<?php
		foreach ($editbanner as $key => $value) {
	?>
	<tr class="edibanner">
		<td><img class="imgbanner" width="150" src="/banner/<?php echo $value['imgpath'] ?>"></td>
		<td><input type="text" name="bannerTitle" value="<?php echo $value['title'] ?>"></td>
		<td><input type="text" name="bannerUrl" value="<?php echo $value['imgurl'] ?>"></td>
		<td>
			<input name="updateBanner" class="btn btn-primary" type="button" value="Edit" />
			<input type="hidden" name="bannerId" value="<?php echo $value['id'] ?>" />
		</td>
		<td><input name="deleteBanner" class="btn btn-primary" type="button" value="Delete" /></td>
	</tr>
	<?php
		}
	?>
</table>