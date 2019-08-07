<?php

/*
 * Created: Giovanni de Almeida Marazzi
 * Date: 22/01/2018
 */
 
array_push($job_strings, 'lftm_it_late_task_job');

function lftm_it_late_task_job() {
	
	$sql = "SELECT T1.id FROM tasks T1 INNER JOIN ";
	$sql .= "tasks_cstm T2 ON T1.id = T2.id_c AND T1.deleted = 0 WHERE NOW() >= DATE_ADD(T1.date_due, INTERVAL 1 HOUR) AND ";
	$sql .= "T2.lftm_it_late_c = 0 AND T1.status NOT IN ('Completed', 'Cancelled')";
    
	$conn = $GLOBALS['db']->getConnection();
	
	$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	$GLOBALS['log']->fatal('Query executed');
	
    while ($row = $stmt->fetch()) {
    	
		$task_bean = BeanFactory::retrieveBean('Tasks', $row['id'], array('disable_row_level_security' => true));
		
		$task_bean->lftm_it_late_c = true;
			
		$task_bean->save();
		
		$GLOBALS['log']->fatal('Processing Task: ' . $task_bean->name);
    }
	
	$GLOBALS['log']->fatal('All Tasks Processed');
	return true;
}
