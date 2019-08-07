<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryExpiraAgendado;

array_push($job_strings, 'job_expira_agendado');

function job_expira_agendado() {
	
	//$GLOBALS['log']->fatal('EXPIRANDO CONTATOS AGENDADOS');

	$sql = "SELECT IFNULL(contacts.id,'') primaryid 

			FROM contacts LEFT JOIN contacts_cstm contacts_cstm ON contacts.id = contacts_cstm.id_c 

			WHERE contacts_cstm.lftm_segmentacao_cliente_c NOT IN ('Online') 
			AND contacts_cstm.lftm_status_cliente_c = 'Ativo' 
			AND contacts_cstm.lftm_fases_acompanhamento_c = 'Agendada' 
			AND contacts_cstm.lftm_agendamento_acomp_c <> '0000-00-00 00:00:00' 
			AND contacts_cstm.lftm_agendamento_acomp_c IS NOT NULL 
			AND NOW() >= contacts_cstm.lftm_agendamento_acomp_c 
			AND contacts.deleted=0;";

	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) {	
		
		$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));
		
		$contact_bean->lftm_fases_acompanhamento_c = 'Expirada';

		//Usado para o agendador repetir para todos os registros e não apenas 1
		RegistryExpiraAgendado\Registry::getInstance()->drop('triggered_starts');
		$contact_bean->save();
		
		//$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
	
	}
	
	//$GLOBALS['log']->fatal('All Contacts Saved');
    return true;

}
?>