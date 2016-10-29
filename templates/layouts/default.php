<?php
$this->write('css','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css');
$this->write('css','/css/main.css');
$this->write('js','https://code.jquery.com/jquery-latest.min.js');
$this->write('js','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js');

?><!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
    <?php $this->fetch('meta');?>
    <?php $this->fetch('css');?>
    <?php echo $this->element('icons');?>
   
</head>
<body>

<?php echo $this->element('header');?>
<div id="content">
<?php $this->fetch('content');?>
</div>
<?php $this->fetch('js');?>
<?php $this->fetch('scriptBlock');?>
<?php echo $this->element('footer');?>

</body>
</html>