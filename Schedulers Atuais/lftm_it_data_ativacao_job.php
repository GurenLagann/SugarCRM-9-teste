<?php

/**
 * GAM#DAC
 */

array_push($job_strings, 'lftm_it_data_ativacao_job');

function lftm_it_data_ativacao_job() {
	
	$sql = "SELECT T3.id_c, MIN(T0.lftm_mes_referencia_c) as reference FROM ger01_gerenciamentocliente_cstm T0 INNER JOIN ";
	$sql .= "ger01_gerenciamentocliente T1 ON T0.id_c = T1.id AND T1.deleted = 0 INNER JOIN ";
	$sql .= "ger01_gerenciamentocliente_contacts_c T2 ON T1.id = T2.ger01_gere60bccliente_idb AND T2.deleted = 0 INNER JOIN ";
	$sql .= "contacts_cstm T3 ON T3.id_c = T2.ger01_gerenciamentocliente_contactscontacts_ida ";
	$sql .= "WHERE T0.lftm_mes_referencia_c IS NOT NULL AND T3.lftm_data_ativacao_c IS NULL AND T0.lftm_captacao_liquida_c > 0 GROUP BY T3.id_c";

	$cnt = 0;
	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) {	
	
		$sql = "UPDATE contacts_cstm SET lftm_data_ativacao_c = '". $row['reference'] ."' WHERE id_c = '". $row['id_c'] ."'";
		$conn->executeQuery($sql);
		
		$cnt++;
		//$GLOBALS['log']->fatal(''. $cnt .' Registers Saved');
	}
	
	//$GLOBALS['log']->fatal('All Registers Saved');
  return true;

}
