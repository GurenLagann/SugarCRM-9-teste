<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryRelac;

array_push($job_strings, 'job_fase_relac_expirada');

function job_fase_relac_expirada() {
	
	//$GLOBALS['log']->fatal('Fase Relacionamento Start');
	
	$sugarQuery = new SugarQuery();

	$sugarQuery->select(array('id'));
	$sugarQuery->from(BeanFactory::newBean('Contacts'));
	$sugarQuery->whereRaw("NOW() >= DATE_SUB(dt_previsao_relacionamento_c, INTERVAL 1 HOUR)");
	$sugarQuery->where()->notEquals('dt_previsao_relacionamento_c', '0000-00-00 00:00:00');
	$sugarQuery->where()->isNotEmpty('dt_previsao_relacionamento_c');
	$sugarQuery->where()->notNull('dt_previsao_relacionamento_c');
	$values = array('Expirada');
	$sugarQuery->where()->in('fases_relacionamento_c',$values);
	$values = array('Online');
	$sugarQuery->where()->notIn('lftm_segmentacao_cliente_c',$values);
	$sugarQuery->where()->equals('lftm_status_cliente_c','Ativo');
	$sugarQuery->where()->equals('deleted',0);

	$preparedStmt = $sugarquery->compile();

	

	$sql = "SELECT IFNULL(contacts.id,'') primaryid 

			FROM contacts LEFT JOIN contacts_cstm contacts_cstm ON contacts.id = contacts_cstm.id_c 

			WHERE NOW() >= DATE_SUB(contacts_cstm.dt_previsao_relacionamento_c, INTERVAL 1 HOUR) 
			AND contacts_cstm.dt_previsao_relacionamento_c IS NOT NULL 
			AND contacts_cstm.dt_previsao_relacionamento_c <> '0000-00-00 00:00:00' 
			AND contacts_cstm.fases_relacionamento_c NOT IN ('Expirada') 
	 		AND contacts_cstm.lftm_segmentacao_cliente_c NOT IN ('Online') 
	 		AND contacts_cstm.lftm_status_cliente_c = 'Ativo' 
	 		AND contacts.deleted=0;";

	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) {	
		
		$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));
		
		$contact_bean->fases_relacionamento_c = 'Expirada';

		//Usado para o agendador repetir para todos os registros e não apenas 1
		RegistryRelac\Registry::getInstance()->drop('triggered_starts');
		$contact_bean->save();
		
		//$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
	
	}
	
	//$GLOBALS['log']->fatal('All Contacts Saved');
    return true;

}
?>