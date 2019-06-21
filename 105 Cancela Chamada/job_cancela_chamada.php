<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryChamada;

array_push($job_strings, 'job_cancela_chamada');

function job_cancela_chamada() 
{
	
	//$GLOBALS['log']->fatal('EXPIRANDO CHAMADAS');

	$sql = "SELECT IFNULL(calls.id,'') primaryid
			,IFNULL(calls.date_start,'') calls_date_start

			FROM calls 

			WHERE status = ?
			AND NOW() > DATE_ADD(date_start, INTERVAL 30 DAY) 
			AND calls.deleted=0;";

	$conn = $GLOBALS['db']->getConnection($sql, array('Planned'));
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) 
	{	

		$calls_bean = BeanFactory::retrieveBean('Calls', $row['primaryid'], array('disable_row_level_security' => true));
		
		$calls_bean->aux_cancelada_mes_c = 1;

		//$GLOBALS['log']->fatal('Processing Calls: ' . $calls_bean->name);
		//$GLOBALS['log']->fatal('Processing Calls: ' . $calls_bean->id);

		//Usado para o agendador repetir para todos os registros e não apenas 1
		RegistryChamada\Registry::getInstance()->drop('triggered_starts');
		$calls_bean->save();
		
		//$GLOBALS['log']->fatal('--Salvo--');
	
	}
	
	//$GLOBALS['log']->fatal('All Calls Saved');
    return true;

}
