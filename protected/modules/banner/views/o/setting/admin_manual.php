<?php
/**
 * Banner Settings (banner-setting)
 * @var $this SettingController
 * @var $model BannerSetting
 * version: 1.3.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-banner
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Banner Settings'=>array('manage'),
		'Manual Book',
	);
?>

<div class="dialog-content">
	<ul>
	<?php
		foreach (new DirectoryIterator($manual_path) as $fileInfo) {
			$filePath = '';
			if($fileInfo->isDot())
				continue;
			
			if($fileInfo->isFile()) {
				$extension = pathinfo($fileInfo->getFilename(), PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('php')))
					$filePath = $this->module->assetsUrl.'/manual/'.$fileInfo->getFilename();
			}
			if($filePath)
				echo '<li>'.CHtml::link($fileInfo->getFilename(), $filePath).'</li>';
		}
	?>
	</ul>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>