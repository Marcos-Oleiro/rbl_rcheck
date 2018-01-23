<?php
    require ('header.ctp');
?>








<?php echo $this->Html->link('Adicionar IP\'s', ['controller' => 'Ips', 'action' => 'add']) ?>

<?php echo '<br><br><br>'; ?>

<?php echo $this->Html->link('Listar  IP\'s', ['controller' => 'Ips', 'action' => 'list']) ?>











<?php
    require ('footer.ctp');
?>