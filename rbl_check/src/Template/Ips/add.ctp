<?php
$path = dirname(__FILE__);


require $path . '/../Pages/header.ctp';

echo $this->Form->Create(null, ['type' => 'file', 'url' => ['controller' => 'Ips', 'action' => 'file']]);
echo '<br>' . '<br>';
?>


Informe o Arquivo:

<?php

echo $this->Form->file('file') . '<br><br>';
?>


<?php
echo $this->Form->button('Enviar');
echo $this->Form->end();
?>

<?php echo '<br><br>'.$this->Html->link('Voltar', ['controller' => 'Pages', 'action' => 'display','index']) ?>

<?php
require $path . '/../Pages/footer.ctp';
