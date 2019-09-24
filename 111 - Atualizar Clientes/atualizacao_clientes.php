<?php 

use Sugarcrm\Sugarcrm\ProcessManager\Registry as UpdateClient;

array_push($job_strings, 'update_client');

// Atualização de Clientes com Reunião
$sql = "UPDATE contacts_cstm cm INNER JOIN meetings_contacts mc ON mc.contact_id = cm.id_c INNER JOIN meetings m ON m.id = mc.meeting_id INNER JOIN meetings_cstm mcs ON mcs.id_c = m.id SET cm.lftm_it_bi_close_c = '1' WHERE m.status = 'Held' AND mcs.lftm_tipo_reuniao_c = 'Segunda' AND NOT cm.lftm_status_cliente_c = 'Inativo'"

// Atualização de Clientes sem Reuniao
$sql1 = "UPDATE contacts_cstm cm SET cm.lftm_it_bi_close_c = '3' WHERE cm.lftm_status_cliente_c NOT IN ('Inativo') AND cm.id_c NOT IN (SELECT contact_id FROM meetings_contacts mc INNER JOIN meetings m ON m.id = mc.meeting_id INNER JOIN meetings_cstm mcs ON mcs.id_c = m.id WHERE m.status = 'Held' AND mcs.lftm_tipo_reuniao_c = 'Segunda')"

//Atualização de Clientes não Convertido com Reunião
$sql2 = "UPDATE contacts_cstm cm INNER JOIN meetings_contacts mc ON mc.contact_id = cm.id_c INNER JOIN meetings m ON m.id = mc.meeting_id INNER JOIN meetings_cstm mcs ON mcs.id_c = m.id SET cm.lftm_it_bi_close_c = '2' WHERE m.status = 'Held' AND mcs.lftm_tipo_reuniao_c = 'Segunda' AND cm.lftm_status_cliente_c = 'Inativo'"

//Atualizar Clientes NDA
$sql3 = "UPDATE contacts_cstm cm SET cm.lftm_it_bi_close_c = '4'"

function update_client_meeting($task){
    $GLOBALS['log'] -> fatal('Update Client on Meeting Start');

    $conn = $GLOBALS['db']->getConnection($task);
    $stmt = $conn -> executeQuery($task);
 
    while($row = $stmt -> fetch()){
        $contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));
        //$contact_bean -> lftm_client_c = 1;

        UpdateClient\Registry::getInstance()->drop('triggered_starts');
        $contact_bean->save();
    }

    $GLOBALS['log']->fatal('Update Client on Meeting End');
    return true;
}

//Função com a atualização de clientes com reunião 
update_client_meeting($sql);

//Função com a atualização de clientes sem reunião 
update_client_meeting($sql1);

//Função com a atualização de clientes não Convertido com Reunião
update_client_meeting($sql2);

//Função com a atualização de Clientes NDA
update_client_meeting($sql3);