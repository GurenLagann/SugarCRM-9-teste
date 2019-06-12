<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryAniver;

array_push($job_strings, 'job_aniversario');

function job_aniversario() 
{
	
	//$GLOBALS['log']->fatal('Aviso de uma semana Start');

	$sql = "SELECT T0.id_c, DAY(NOW()) as dia, MONTH(NOW()) as mes, DAY(T1.birthdate) as diaC, MONTH(T1.birthdate) as mesC 
			
			FROM contacts_cstm T0 INNER JOIN contacts T1 on T1.id = T0.id_c 
			
			WHERE T0.lftm_status_cliente_c = 'Ativo' 
			AND	T1.birthdate IS NOT NULL 
			AND T1.birthdate <> '0000-00-00 00:00:00' 
			AND T1.deleted=0;";

	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection NIVER');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed NIVER');
	
	while($row = $stmt->fetch())
	{	
		
		if ($row['diaC'] == $row['dia'] AND $row['mesC'] == $row['mes'])
		{
			$contact_bean = BeanFactory::retrieveBean('Contacts', $row['id_c'], array('disable_row_level_security' => true));
			
			$contact_bean->lftm_niver_c = 1;

			//Usado para o agendador repetir para todos os registros e não apenas 1
			RegistryAniver\Registry::getInstance()->drop('triggered_starts');
			$contact_bean->save();
			
			//$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
		}
	}
	
	//$GLOBALS['log']->fatal('All Contacts Saved NIVER');
    return true;

}
?>