<?php
/**
 * Article Collections (article-collections)
 * @var $this AdminController
 * @var $model ArticleCollections
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 26 October 2016, 06:58 WIB
 * @link https://github.com/ommu/plu-article-collection
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'article-collections-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php 
		echo $form->errorSummary($model);
		if(Yii::app()->user->hasFlash('error'))
			echo Utility::flashError(Yii::app()->user->getFlash('error'));
		if(Yii::app()->user->hasFlash('success'))
			echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
		?>
	</div>
	<?php //begin.Messages ?>
	
	<?php 
	$article->cat_id = ArticleCollectionSetting::getInfo(1, 'article_cat_id');
	echo $form->hiddenField($article,'cat_id');
	$article->article_type = 1;
	echo $form->hiddenField($article,'article_type');?>

	<fieldset class="clearfix">
		<div class="clear">
			<div class="left">
				<div class="clearfix">
					<?php echo $form->labelEx($model,'cat_id'); ?>
					<div class="desc">
						<?php 
						$category = ArticleCollectionCategory::getCategory(1);
						if($category != null)
							echo $form->dropDownList($model,'cat_id', $category);
						else
							echo $form->dropDownList($model,'cat_id', array('prompt'=>Yii::t('phrase', 'Select Category')));?>
						<?php echo $form->error($model,'cat_id'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>
	
				<div class="clearfix">
					<label><?php echo $article->getAttributeLabel('title');?> <span class="required">*</span></label>
					<div class="desc">
						<?php echo $form->textField($article,'title',array('maxlength'=>128,'class'=>'span-8')); ?>
						<?php echo $form->error($article,'title'); ?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($publisher,'publisher_name'); ?>
					<div class="desc">
						<?php 
						//echo $form->textField($publisher,'publisher_name',array('maxlength'=>64,'class'=>'span-7'));
						$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'model' => $publisher,
							'attribute' => 'publisher_name',
							'source' => Yii::app()->controller->createUrl('collection/publisher/suggest'),
							'options' => array(
								//'delay '=> 50,
								'minLength' => 1,
								'showAnim' => 'fold',
								'select' => "js:function(event, ui) {
									$('form #ArticleCollectionPublisher_publisher_name').val(ui.item.value);
									$('form #ArticleCollections_publisher_id').val(ui.item.id);
								}"
							),
							'htmlOptions' => array(
								'class'	=> 'span-6',
								'maxlength'=>64,
							),
						));
						echo $form->hiddenField($model,'publisher_id'); ?>
						<?php echo $form->error($publisher,'publisher_name'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>
				
				<div class="clearfix">
					<?php echo $form->labelEx($model,'author_input'); ?>
					<div class="desc">
						<?php 
						if($model->isNewRecord) {
							echo $form->textArea($model,'author_input',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 smaller'));
							
						} else {
							//echo $form->textField($model,'author_input',array('maxlength'=>32,'class'=>'span-6'));
							$url = Yii::app()->controller->createUrl('collection/authors/add', array('hook'=>'collection','plugin'=>'collection'));
							$collection = $model->collection_id;
							$authorId = 'ArticleCollections_author_input';
							$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'author_input',
								'source' => Yii::app()->controller->createUrl('collection/author/suggest'),
								'options' => array(
									//'delay '=> 50,
									'minLength' => 1,
									'showAnim' => 'fold',
									'select' => "js:function(event, ui) {
										$.ajax({
											type: 'post',
											url: '$url',
											data: { collection_id: '$collection', author_id: ui.item.id, author: ui.item.value },
											dataType: 'json',
											success: function(response) {
												$('form #$authorId').val('');
												$('form #author-suggest').append(response.data);
											}
										});

									}"
								),
								'htmlOptions' => array(
									'class'	=> 'span-7',
								),
							));
							echo $form->error($model,'author_input');
						}?>
						<div id="author-suggest" class="suggest clearfix">
							<?php 
							if(!$model->isNewRecord) {
								$authors = $model->authors;
								if(!empty($authors)) {
									foreach($authors as $key => $val) {?>
									<div><?php echo $val->author->author_name;?><a href="<?php echo Yii::app()->controller->createUrl('collection/authors/delete',array('id'=>$val->id,'hook'=>'collection','plugin'=>'collection'));?>" title="<?php echo Yii::t('phrase', 'Delete');?>"><?php echo Yii::t('phrase', 'Delete');?></a></div>
								<?php }
								}
							}?>				
						</div>
						<?php if($model->isNewRecord) {?><span class="small-px">tambahkan tanda pagar (#) jika ingin menambahkan aothor lebih dari satu</span><?php }?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'publish_year'); ?>
					<div class="desc">
						<?php echo $form->textField($model,'publish_year',array('maxlength'=>4, 'class'=>'span-3')); ?>
						<?php echo $form->error($model,'publish_year'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'publish_location'); ?>
					<div class="desc">
						<?php echo $form->textField($model,'publish_location',array('maxlength'=>64, 'class'=>'span-5')); ?>
						<?php echo $form->error($model,'publish_location'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'isbn'); ?>
					<div class="desc">
						<?php echo $form->textField($model,'isbn',array('maxlength'=>32, 'class'=>'span-5')); ?>
						<?php echo $form->error($model,'isbn'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'pages'); ?>
					<div class="desc">
						<?php echo $form->textField($model,'pages',array('rows'=>6, 'cols'=>50, 'class'=>'span-5')); ?>
						<?php echo $form->error($model,'pages'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>

				<div class="clearfix">
					<?php echo $form->labelEx($model,'series'); ?>
					<div class="desc">
						<?php echo $form->textField($model,'series',array('rows'=>6, 'cols'=>50, 'class'=>'span-5')); ?>
						<?php echo $form->error($model,'series'); ?>
						<?php /*<div class="small-px silent"></div>*/?>
					</div>
				</div>
				
				<div class="clearfix">
					<?php echo $form->labelEx($model,'subject_input'); ?>
					<div class="desc">
						<?php 
						if($model->isNewRecord) {
							echo $form->textArea($model,'subject_input',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 smaller'));
							
						} else {
							//echo $form->textField($model,'subject_input',array('maxlength'=>32,'class'=>'span-6'));
							$url = Yii::app()->controller->createUrl('collection/subjects/add', array('hook'=>'collection'));
							$collection = $model->collection_id;
							$subjectId = 'ArticleCollections_subject_input';
							$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'subject_input',
								'source' => Yii::app()->createUrl('globaltag/suggest'),
								'options' => array(
									//'delay '=> 50,
									'minLength' => 1,
									'showAnim' => 'fold',
									'select' => "js:function(event, ui) {
										$.ajax({
											type: 'post',
											url: '$url',
											data: { collection_id: '$collection', tag_id: ui.item.id, subject: ui.item.value },
											dataType: 'json',
											success: function(response) {
												$('form #$subjectId').val('');
												$('form #subject-suggest').append(response.data);
											}
										});

									}"
								),
								'htmlOptions' => array(
									'class'	=> 'span-6',
								),
							));
							echo $form->error($model,'subject_input');
						}?>
						<div id="subject-suggest" class="suggest clearfix">
							<?php 
							if(!$model->isNewRecord) {
								$subjects = $model->subjects;
								if(!empty($subjects)) {
									foreach($subjects as $key => $val) {?>
									<div><?php echo $val->tag->body;?><a href="<?php echo Yii::app()->controller->createUrl('collection/subjects/delete',array('id'=>$val->id,'hook'=>'collection','plugin'=>'collection'));?>" title="<?php echo Yii::t('phrase', 'Delete');?>"><?php echo Yii::t('phrase', 'Delete');?></a></div>
								<?php }
								}
							}?>						
						</div>
						<?php if($model->isNewRecord) {?><span class="small-px">tambahkan tanda koma (,) jika ingin menambahkan subject lebih dari satu</span><?php }?>
					</div>
				</div>
			</div>
			
			<div class="right">				
				<div class="clearfix">
					<?php echo $form->labelEx($article,'media_input'); ?>
					<div class="desc">
						<?php 
						if(!$article->isNewRecord) {
							$article->old_media_input = $article->cover->media;
							echo $form->hiddenField($article,'old_media_input');
							if($article->media_id != 0) {
								$image = Yii::app()->request->baseUrl.'/public/article/'.$article->article_id.'/'.$article->old_media_input;
								if($article->article_type == 1) {?>
									<img class="mb-10" src="<?php echo Utility::getTimThumb($image, 320, 150, 1);?>" alt="">
						<?php 	}
							}
						}
						echo $form->fileField($article,'media_input'); ?>
						<?php echo $form->error($article,'media_input'); ?>
						<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType(unserialize($setting->media_file_type), false);?></span>
					</div>
				</div>
				
				<div class="clearfix">
					<?php echo $form->labelEx($article,'media_file'); ?>
					<div class="desc">
						<?php 
						if(!$article->isNewRecord) {
							$article->old_media_file = $article->media_file;
							echo $form->hiddenField($article,'old_media_file');
							if($article->media_file != '') {
								$file = Yii::app()->request->baseUrl.'/public/article/'.$article->article_id.'/'.$article->old_media_file;?>
								<div class="mb-10"><a href="<?php echo $file;?>" title="<?php echo $article->old_media_file;?>"><?php echo $article->old_media_file;?></a></div>
						<?php }
						}
						echo $form->fileField($article,'media_file'); ?>
						<?php echo $form->error($article,'media_file'); ?>
						<span class="small-px">extensions are allowed: <?php echo Utility::formatFileType(unserialize($setting->upload_file_type), false);?></span>
					</div>
				</div>
	
				<div class="clearfix">
					<?php echo $form->labelEx($article,'published_date'); ?>
					<div class="desc">
						<?php 
						$article->published_date = $article->isNewRecord && $article->published_date == '' ? date('d-m-Y') : date('d-m-Y', strtotime($article->published_date));
						//echo $form->textField($article,'published_date', array('class'=>'span-7'));
						$this->widget('zii.widgets.jui.CJuiDatePicker',array(
							'model'=>$article, 
							'attribute'=>'published_date',
							//'mode'=>'datetime',
							'options'=>array(
								'dateFormat' => 'dd-mm-yy',
							),
							'htmlOptions'=>array(
								'class' => 'span-7',
							 ),
						));	?>
						<?php echo $form->error($article,'published_date'); ?>
					</div>
				</div>
	
				<?php if(OmmuSettings::getInfo('site_type') == 1) {?>
				<div class="clearfix publish">
					<?php echo $form->labelEx($article,'comment_code'); ?>
					<div class="desc">
						<?php echo $form->checkBox($article,'comment_code'); ?><?php echo $form->labelEx($article,'comment_code'); ?>
						<?php echo $form->error($article,'comment_code'); ?>
					</div>
				</div>
				<?php } else {
					$article->comment_code = 0;
					echo $form->hiddenField($article,'comment_code');
				}?>
	
				<?php if(OmmuSettings::getInfo('site_headline') == 1) {?>
				<div class="clearfix publish">
					<?php echo $form->labelEx($article,'headline'); ?>
					<div class="desc">
						<?php echo $form->checkBox($article,'headline'); ?><?php echo $form->labelEx($article,'headline'); ?>
						<?php echo $form->error($article,'headline'); ?>
					</div>
				</div>
				<?php } else {
					$article->headline = 0;
					echo $form->hiddenField($article,'headline');
				}?>
	
				<div class="clearfix publish">
					<?php echo $form->labelEx($model,'publish'); ?>
					<div class="desc">
						<?php echo $form->checkBox($model,'publish'); ?><?php echo $form->labelEx($model,'publish'); ?>
						<?php echo $form->error($model,'publish'); ?>
					</div>
				</div>
			</div>
	</fieldset>
	
	<fieldset>
		<div class="clearfix">
			<?php echo $form->labelEx($article,'body'); ?>
			<div class="desc">
				<?php 
				//echo $form->textArea($article,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$article,
					'attribute'=>body,
					// Redactor options
					'options'=>array(
						//'lang'=>'fi',
						'buttons'=>array(
							'html', 'formatting', '|', 
							'bold', 'italic', 'deleted', '|',
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'link', '|',
						),
					),
					'plugins' => array(
						'fontcolor' => array('js' => array('fontcolor.js')),
						'table' => array('js' => array('table.js')),
						'fullscreen' => array('js' => array('fullscreen.js')),
					),
				)); ?>
				<?php echo $form->error($article,'body'); ?>
			</div>
		</div>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>


