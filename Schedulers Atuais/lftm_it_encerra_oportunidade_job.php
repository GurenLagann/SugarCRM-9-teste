<?php

/*
 * Created: Giovanni de Almeida Marazzi
 * Date: 05/03/2018
 */

array_push($job_strings, 'lftm_it_encerra_oportunidade_job');

function lftm_it_encerra_oportunidade_job() {
	
	$sql = "SELECT T1.id_c FROM opportunities_cstm T1";
	$sql .= "WHERE T1.lftm_data_encerramento_c IS NOT NULL AND NOW() >= T1.lftm_data_encerramento_c";
	$sql .= "AND T1.lftm_status_operacao_c IN ('Aberta') AND T1.lftm_encerramento_automatico_c = 1";

	$cnt = 0;
	$conn = $GLOBALS['db']->getConnection();
	
//	$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
//	$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) {	
	
		$sql = "UPDATE opportunities_cstm SET lftm_status_operacao_c = 'Encerrada' WHERE id_c = '". $row['id_c'] ."'";
		$conn->executeQuery($sql);
		
		$cnt++;
//		$GLOBALS['log']->fatal(''. $cnt .' Opportunities Saved');
	}
	
//	$GLOBALS['log']->fatal('All Opportunities Saved');
    return true;

}
