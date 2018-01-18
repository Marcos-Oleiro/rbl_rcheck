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
        $ip_reverse_list = $ip_list;                    // lista de ips reversos 
        // função para pegar a lista de ip reverso da lista dos ips.=> 187.86.129.3 vira 3.129.86.187

        for ($i = 0; $i < sizeof($ip_list); $i++) {
            $str_aux = $ip_list[$i];

            $array_aux1 = explode(".", $str_aux);
            $array_aux2 = $array_aux1;

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
            
//            $aux= $ipsTable->find()->select(['ipv4'])->where(['ipv4 = '=> '164.587.647.555']);
            
//            $stmt = $connection->execute('Select ipv4 from ips where ipv4 = ?',['164.587.647.555']);
            $stmt = $connection->execute('SELECT * FROM ips')->fetchAll('assoc');
            print_r($stmt);

            exit();
            
            
//            $ip_db = $this->Model->();
//            $res = false;
//            if (!$ip_db) {
//                $res = $ipsTable->save($ip);
//            }
//            $res_msg = "Dados inseridos no banco de dados." . "<br>";
//
//            if (!$res) {
//                $res_msg = "Erro ao salvar no banco de dados." . "<br>";
//            } 
        }

        $this->set('msg', $res_msg);
        $this->viewBuilder()->setLayout('');
        $this->render();
    }

}
