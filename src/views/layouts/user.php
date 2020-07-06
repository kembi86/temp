<?php
\modava\auth\assets\UserAsset::register($this);
\modava\auth\assets\UserCustomAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/main.php'); ?>
<?php echo $content ?>
<?php $this->endContent(); ?>
