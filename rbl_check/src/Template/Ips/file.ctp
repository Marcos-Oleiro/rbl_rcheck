<?php
$path = dirname(__FILE__);


require $path . '/../Pages/header.ctp';
?>

<h1>   <?php echo $msg; ?> </h1>

<?php echo $this->Html->link('Voltar', ['controller' => 'Ips', 'action' => 'add']) ?>



<?php
require $path . '/../Pages/footer.ctp';