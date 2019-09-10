<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryNiverConta;

array_push($job_strings, 'job_niver_conta');

function job_niver_conta(){
	
	$GLOBALS['log']->fatal('Aniversario de Conta - Start');

	$sql = "SELECT T0.id_c AS primaryid, 
	DAY(DATE_ADD(NOW(), INTERVAL 2 DAY)) as dia, MONTH(DATE_ADD(NOW(), INTERVAL 2 DAY)) as mes, 
	DAY(T1.lftm_it_niver_conta_c) as diaC, MONTH(T1.lftm_it_niver_conta_c) as mesC 
	FROM contacts_cstm T0 INNER JOIN contacts T1 on T1.id = T0.id_c 
	WHERE T0.lftm_status_cliente_c = 'Ativo' AND T1.lftm_it_niver_conta_c IS NOT NULL AND T1.deleted=0 
	HAVING diaC = dia AND mesC = mes;";

	$conn = $GLOBALS['db']->getConnection();
	$stmt = $conn->executeQuery($sql);
	while($row = $stmt->fetch()){

			$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));	
			$contact_bean->lftm_niver_conta_c = 1;
			//Usado para o agendador repetir para todos os registros e não apenas 1
			RegistryNiverConta\Registry::getInstance()->drop('triggered_starts');
			$contact_bean->save();
	}
	$GLOBALS['log']->fatal('Aniversario de Conta - End');
	return true;
}
