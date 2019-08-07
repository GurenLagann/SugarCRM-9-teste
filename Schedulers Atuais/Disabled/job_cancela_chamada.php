<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry;

array_push($job_strings, 'job_cancela_chamada');

function job_cancela_chamada() 
{
	
	$GLOBALS['log']->fatal('EXPIRANDO CHAMADAS');

	$sql = "SELECT id, date_start FROM calls ";
	$sql .= "WHERE status = 'Planned' AND ";
	$sql .= "NOW() > DATE_ADD(date_start, INTERVAL 30 DAY)";

	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) 
	{	

		$calls_bean = BeanFactory::retrieveBean('Calls', $row['id'], array('disable_row_level_security' => true));
		
		$calls_bean->aux_cancelada_mes_c = 1;

		Registry\Registry::getInstance()->drop('triggered_starts');
			
		$calls_bean->save();
		
		//$GLOBALS['log']->fatal('Processing Calls: ' . $calls_bean->name);
		//$GLOBALS['log']->fatal('Processing Calls: ' . $calls_bean->id);
	
	}
	
	//$GLOBALS['log']->fatal('All Calls Saved');
    return true;

}


