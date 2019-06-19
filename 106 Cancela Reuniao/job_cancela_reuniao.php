<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryReuniao;

array_push($job_strings, 'job_cancela_reuniao');

function job_cancela_reuniao() 
{
	
	//$GLOBALS['log']->fatal('-------EXPIRANDO REUNIOES-------');

	$sql = "SELECT IFNULL(meetings.id,'') id_meet 
			,IFNULL(meetings.date_start,'') meet_date_start 

			FROM meetings 
			
			WHERE status = 'Planned' 
			AND	NOW() > DATE_ADD(date_start, INTERVAL 30 DAY) 
			AND meetings.deleted=0;";

	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) 
	{	

		//$GLOBALS['log']->fatal('IDs: ' . $row['id_meet']);

		$meetings_bean = BeanFactory::retrieveBean('Meetings', $row['id_meet'], array('disable_row_level_security' => true));
		
		$meetings_bean->aux_cancelada_mes_c = 1;

		//$GLOBALS['log']->fatal('Processing Meetings: ' . $meetings_bean->name);
		//$GLOBALS['log']->fatal('Processing Meetings: ' . $meetings_bean->id);

		//Usado para o agendador repetir para todos os registros e não apenas 1
		RegistryReuniao\Registry::getInstance()->drop('triggered_starts');
		$meetings_bean->save();
		
		//$GLOBALS['log']->fatal('--Salvo--');
	
	}
	
	//$GLOBALS['log']->fatal('All Meetings Saved');
    return true;

}
?>