<?php

namespace App\Controller;

use Cake\Filesystem\File;
use App\Model\Entity\Ip;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class IpsController extends AppController {

    public function add() {
//        $this->layout = false;

        $this->viewBuilder()->setLayout('');
        $this->render();
    }

    public function file() {

        // arquivo vindo do formulário /ips/add
        $file_ip = $this->request->data['file'];

        // cria o objeto File (Cake), usando a localização do arquivo vindo do formulário
        $file_cake = new File($file_ip['tmp_name'], true, 0755);

        $file_cake->open('r');
        $lines = $file_cake->read();

        // explode a string vinda da leitura do arquivo em um array. utilizando whithesoace como separador
        $ip_list = preg_split("/\s+/", $lines);         // lista de ips do arquivo
        array_pop($ip_list);                            // excluir último elemento, em branco. Obs : Por algum motivo, quando é preg_split é usado, ele tá criando um elemento vazio no fim do array, por isso o pop
        $ip_reverse_list = $ip_list;                    // lista de ips reversos 
        // Array de ips que já existiam no banco de dados, quando foi tentado inserir ips ao banco        
        $duplicate_ips = array();

        // Mensagem comunicando a falha ao tentar inserir o ip no banco de dados
        $msg_fail = '';

        // Mensagem comunicando o sucesso ao tentar inserir o ip no banco de dados
        $msg_suc = '';

        // Array de ips duplicado, para criar a mensagem
        $ip_d = '';
//        print_r($ip_list);exit();
        // função para pegar a lista de ip reverso da lista dos ips.=> 187.86.129.3 vira 3.129.86.187

        for ($i = 0; $i < sizeof($ip_list); $i++) {
            $str_aux = $ip_list[$i];

            $array_aux1 = explode(".", $str_aux);
            $array_aux2 = $array_aux1;

            $array_aux2[0] = '';
            $array_aux2[1] = '';
            $array_aux2[2] = '';
            $array_aux2[3] = '';

            $array_aux2[0] = $array_aux1[3];
            $array_aux2[1] = $array_aux1[2];
            $array_aux2[2] = $array_aux1[1];
            $array_aux2[3] = $array_aux1[0];

            $ip_reverse_list[$i] = implode(".", $array_aux2);
        }

        $connection = ConnectionManager::get('default');

        // função para instanciar objetos da classe IP e já salva no banco de dados cada objeto criado

        for ($j = 0; $j < sizeof($ip_list); $j++) {

            $ipsTable = TableRegistry::get('Ips');
            $ip = $ipsTable->newEntity();


            $ip->ipv4 = $ip_list[$j];
            $ip->ip_reverse = $ip_reverse_list[$j];
            $ip->active = 0;
            $ip->listed = 0;
            $ip->service = 'nenhum';
            
            // Checa se o IP já existe dentro do banco de dados
            $stmt = $connection->execute('Select ipv4 from ips where ipv4 = ?', [$ip->get('ipv4')])->fetchAll('assoc');

            if ($ip->get('ipv4') == $stmt[0]['ipv4']) { // se existir, insere no array $duplicate_ips
                array_push($duplicate_ips, $ip->get('ipv4'));
            } else { // se não existir, ele insere no banco
                $res = $ipsTable->save($ip);

                if ($res) { // sucesso na inserção no banco
                    $msg_suc = "Dados inseridos no banco de dados." . "<br>";
                } else { // falha na inserção no banco
                    $msg_fail = $msg_fail + "Erro ao salvar o ip: '.$ip->get('ipv4').'no banco de dados." . "<br>";
                }
            }
        }

        // Prepara a mensagem que mostra os ip's duplicados, se houverem.
        if (sizeof($duplicate_ips) > 0) {
            for ($i = 0; $i < sizeof($duplicate_ips); $i++) {
                
                if ( $i== (sizeof($duplicate_ips) - 1) ) {

                    $ip_d = $ip_d  . $duplicate_ips[$i];

                }
                else{
                    
                    $ip_d = $ip_d  . $duplicate_ips[$i] . '; ';
                }

            }
            $msg_duplicate_ips = 'Os seguintes IP\'s já estavam inseridos no banco de dados: ' . $ip_d . '.';
        }
        else{
            $msg_duplicate_ips = '';
        }

        $this->set('msg_success', $msg_suc);
        $this->set('msg_failure', $msg_fail);
        $this->set('msg_duplicate', $msg_duplicate_ips);

        $this->viewBuilder()->setLayout('');
        $this->render();
    }

}
