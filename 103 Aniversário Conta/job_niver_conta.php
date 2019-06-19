<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryNiverConta;

array_push($job_strings, 'job_niver_conta');

function job_niver_conta() 
{
	
	//$GLOBALS['log']->fatal('Aviso de uma semana Start');

	$sql = "SELECT IFNULL(contacts.id,'') primaryid, DAY(NOW()) as dia, MONTH(NOW()) as mes
			, DAY(contacts_cstm.lftm_ativaconta_3d_c) as diaC, MONTH(contacts_cstm.lftm_ativaconta_3d_c) as mesC 

			FROM contacts LEFT JOIN contacts_cstm contacts_cstm ON contacts.id = contacts_cstm.id_c 

			WHERE contacts_cstm.lftm_status_cliente_c = 'Ativo' 
			AND	contacts_cstm.lftm_ativaconta_3d_c IS NOT NULL 
			AND contacts_cstm.lftm_ativaconta_3d_c <> '0000-00-00 00:00:00' 
			AND contacts.deleted=0;";

	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection NIVER');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed NIVER');
	
	while($row = $stmt->fetch())
	{	
		
		if ($row['diaC'] == $row['dia'] AND $row['mesC'] == $row['mes'])
		{
			$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));
			
			$contact_bean->lftm_niver_conta_c = 1;

			//Usado para o agendador repetir para todos os registros e não apenas 1
			RegistryNiverConta\Registry::getInstance()->drop('triggered_starts');
			$contact_bean->save();
			
			//$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
		}
	}
	
	//$GLOBALS['log']->fatal('All Contacts Saved NIVER');
    return true;

}
?>