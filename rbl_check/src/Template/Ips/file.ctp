<?php

$path = dirname(__FILE__);


require $path . '/../Pages/header.ctp';
?>

<?php echo $msg_success; ?> 
<?php echo $msg_failure; ?> 
<?php echo $msg_duplicate; ?> 

<br><br><br>
<?php echo $this->Html->link('Voltar', ['controller' => 'Ips', 'action' => 'add']) ?>



<?php

require $path . '/../Pages/footer.ctp';
