<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryTier;

$job_strings[] = 'job_relacionamento_tier';

function job_relacionamento_tier() {
	
	$GLOBALS['log']->fatal('Verifica Relacionamento Mesa START');

	$query = 	"SELECT contacts.id as primaryid FROM contacts LEFT JOIN contacts_cstm ON  contacts.id = contacts_cstm.id_c WHERE contacts_cstm.lftm_previsao_mesa_c IS NOT NULL AND contacts_cstm.lftm_previsao_mesa_c NOT IN ('0000-00-00 00:00:00', '') AND contacts.deleted = 0 AND NOW() >= contacts_cstm.lftm_previsao_mesa_c AND contacts_cstm.lftm_fase_contato_mesa_c NOT IN ('Expirada')";
							

	$conn = $GLOBALS['db']->getConnection();
	$stmt = $conn->executeQuery($query);
	
	while($row = $stmt->fetch()) {	
		$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));
		$contact_bean->lftm_fase_contato_mesa_c = 'Expirada';
		
		//Usado para o agendador repetir para todos os registros e não apenas 1
		RegistryTier\Registry::getInstance()->drop('triggered_starts');
		
		$contact_bean->save();
	}
	$GLOBALS['log']->fatal('Verifica Relacionamento Mesa END');
	
	return true;

}