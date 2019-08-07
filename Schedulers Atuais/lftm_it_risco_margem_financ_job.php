<?php

array_push($job_strings, 'lftm_it_risco_margem_financ_job');

function lftm_it_risco_margem_financ_job() {

//	$GLOBALS['log']->fatal('Margin and Risk and Financ Start');

	$sql = "UPDATE contacts_cstm c INNER JOIN (SELECT 
	IFNULL(SUM(T4.lftm_margem_operacao_c),0) AS margem, IFNULL(SUM(T4.lftm_risco_maximo_c),0) AS risco, IFNULL(SUM(T4.lftm_valor_financ_c),0) AS valor, T1.id_c, T1.lftm_numero_conta_c 
FROM 
	contacts_cstm T1 INNER JOIN
	contacts_opportunities_1_c T2 ON T1.id_c = T2.contacts_opportunities_1contacts_ida INNER JOIN
	opportunities T3 ON T3.id = T2.contacts_opportunities_1opportunities_idb INNER JOIN
	opportunities_cstm T4 ON T4.id_c = T3.id 
WHERE 
	T3.opportunity_type = 'ReceitaExisting' AND T4.lftm_status_operacao_c = 'Aberta' AND T3.sales_stage = 'Closed Won'
	GROUP BY T1.id_c) tab ON c.id_c = tab.id_c SET c.lftm_it_risco_max_atual_c = tab.risco, c.lftm_it_financ_consu_c = tab.valor, c.lftm_it_margem_financeira_c = tab.margem;";

	$cnt = 0;
	$stmt = $conn->executeQuery($sql);
	
//	$GLOBALS['log']->fatal('Margin and Risk and Financ End');
    return true;

}
