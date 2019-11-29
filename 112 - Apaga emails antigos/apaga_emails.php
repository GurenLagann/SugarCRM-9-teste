<?php 

array_push($job_strings, 'apaga_emails');


function apaga_emails($task){
    
    //return true;
	
	$GLOBALS['log']->fatal("atualiza_budget");

	global $GLOBALS;
	global $timedate;	
	global $db;
	$conn = $GLOBALS['db']->getConnection(); 
    
    $sql = "SELECT id FROM emails WHERE created_by = '15a72ccb-e8f1-4dcc-4a65-55b92580e567' AND date_entered < ".date("Y-m-d",strtotime("-3 months"));
    
    $emailsadeletar = $conn->executeQuery($sql);
	
	// $GLOBALS['log']->fatal("atualiza por vendedor");
	foreach($emailsadeletar->fetchAll() as $emails){
		$email =  BeanFactory::getBean('Emails', $emails["id"]);
        $email->mark_deleted();
	}
	
	// $GLOBALS['log']->fatal("fim atualiza_budget");
    return true;
    
    
    
}
