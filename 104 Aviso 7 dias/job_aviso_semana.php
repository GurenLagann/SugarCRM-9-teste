<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistrySemanaAcomp;

array_push($job_strings, 'job_aviso_semana');

function job_aviso_semana() {
	
	//$GLOBALS['log']->fatal('Aviso de uma semana Start');

	$sql = "SELECT IFNULL(contacts.id,'') primaryid 

			FROM contacts LEFT JOIN contacts_cstm contacts_cstm ON contacts.id = contacts_cstm.id_c 

			WHERE contacts_cstm.lftm_segmentacao_cliente_c NOT IN (?) 
			AND contacts_cstm.lftm_status_cliente_c = ? 
			AND contacts_cstm.lftm_fases_acompanhamento_c NOT IN (?) 
			AND contacts_cstm.alerta_enviado_c = ? 
			AND contacts_cstm.enviar_alerta_c = ? 
			AND contacts_cstm.lftm_aux_prevacomp_menos7_c <> ? 
			AND contacts_cstm.lftm_aux_prevacomp_menos7_c IS NOT NULL 
			AND NOW() >= contacts_cstm.lftm_aux_prevacomp_menos7_c
			AND contacts.deleted=?;";

	$conn = $GLOBALS['db']->getConnection($sql, array('Online', 'Ativo', 'Agendada', 0, 0, '0000-00-00 00:00:00', 0));
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) {	
		
		$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));
		
		$contact_bean->enviar_alerta_c = 1;

		//Usado para o agendador repetir para todos os registros e não apenas 1
		RegistrySemanaAcomp\Registry::getInstance()->drop('triggered_starts');
		$contact_bean->save();
		
		//$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
	
	}
	
	//$GLOBALS['log']->fatal('All Contacts Saved');
    return true;

}
