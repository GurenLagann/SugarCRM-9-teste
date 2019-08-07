<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistrySaldo;

array_push($job_strings, 'dias_saldo_positivo');

function dias_saldo_positivo() 
{
	
	//$GLOBALS['log']->fatal('------- dias_saldo_positivo -------');

	$sql1 = "SELECT IFNULL(contacts.id,'') primaryid, 
			contacts_cstm.lftm_saldo_atual_c CONTACTS_CSTM_LFTM_SAL81DE02, 
			contacts_cstm.currency_id CONTACTS_CSTM_LFTM_SAL103C07, 
			contacts_cstm.lftm_saldo_min_c CONTACTS_CSTM_LFTM_SAL896AD6, 
			contacts_cstm.currency_id CONTACTS_CSTM_LFTM_SAL89834D, 
			contacts_cstm.lftm_dias_saldo_positivo_c CONTACTS_CSTM_LFTM_DIA16D5D8, 
			contacts_cstm.lftm_net_c NET_CLIENTE 
			FROM contacts
			LEFT JOIN contacts_cstm contacts_cstm ON contacts.id = contacts_cstm.id_c

			WHERE (((((IFNULL(contacts_cstm.lftm_status_cliente_c,'') = 'Ativo') 
			AND (contacts_cstm.lftm_saldo_atual_c < contacts_cstm.lftm_saldo_min_c)
			AND ((coalesce(LENGTH(contacts_cstm.lftm_saldo_atual_c), 0) <> 0)) 
			AND ((coalesce(LENGTH(contacts_cstm.lftm_saldo_min_c), 0) <> 0)) 
			AND ((coalesce(LENGTH(contacts_cstm.lftm_dias_saldo_positivo_c), 0) <> 0)) 
			AND (contacts_cstm.lftm_dias_saldo_positivo_c > 0))) 
			AND (((IFNULL(contacts_cstm.lftm_perfil_comportamental_c,'') IN ('Money_Maker','Money_Saver')))))) 
			AND  contacts.deleted=0;";

	$conn = $GLOBALS['db']->getConnection();
	
	//$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql1);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) 
	{	

		$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));

		//$GLOBALS['log']->fatal('Dias > 0 e Saldo < min');
		//$GLOBALS['log']->fatal('dias antes: ' . $row['contacts_cstm.lftm_dias_saldo_positivo_c']);
		//$GLOBALS['log']->fatal('saldo antes: ' . $row['CONTACTS_CSTM_LFTM_SAL81DE02']);
		$contact_bean->lftm_dias_saldo_positivo_c = 0;
		//$GLOBALS['log']->fatal('Zerou-> ' . $contact_bean->lftm_dias_saldo_positivo_c);

		//Usado para o agendador repetir para todos os registros e não apenas 1;
		RegistrySaldo\Registry::getInstance()->drop('triggered_starts');
		$contact_bean->save();
		
		//$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
	}


	$sql2 = "SELECT IFNULL(contacts.id,'') idprimary, 
			contacts_cstm.lftm_saldo_atual_c CONTACTS_CSTM_LFTM_SAL81DE02, 
			contacts_cstm.currency_id CONTACTS_CSTM_LFTM_SAL103C07, 
			contacts_cstm.lftm_saldo_min_c CONTACTS_CSTM_LFTM_SAL896AD6, 
			contacts_cstm.currency_id CONTACTS_CSTM_LFTM_SAL89834D, 
			contacts_cstm.lftm_dias_saldo_positivo_c CONTACTS_CSTM_LFTM_DIA16D5D8, 
			contacts_cstm.lftm_net_c NET_CLIENTE 
			FROM contacts
			LEFT JOIN contacts_cstm contacts_cstm ON contacts.id = contacts_cstm.id_c

			WHERE (((((IFNULL(contacts_cstm.lftm_status_cliente_c,'') = 'Ativo') 
			AND (contacts_cstm.lftm_saldo_atual_c >= contacts_cstm.lftm_saldo_min_c)
			AND ((coalesce(LENGTH(contacts_cstm.lftm_saldo_atual_c), 0) <> 0)) 
			AND ((coalesce(LENGTH(contacts_cstm.lftm_saldo_min_c), 0) <> 0)) 
			AND ((coalesce(LENGTH(contacts_cstm.lftm_dias_saldo_positivo_c), 0) <> 0)))) 
			AND (contacts_cstm.lftm_net_c BETWEEN 200000 AND 500000) 
			AND (((IFNULL(contacts_cstm.lftm_perfil_comportamental_c,'') IN ('Money_Maker','Money_Saver')))))) 
			AND  contacts.deleted=0;";

	$stmt = $conn->executeQuery($sql2);
	
	//$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) 
	{
		$contact_bean = BeanFactory::retrieveBean('Contacts', $row['idprimary'], array('disable_row_level_security' => true));
		
		$dias = $contact_bean->lftm_dias_saldo_positivo_c;

		//$GLOBALS['log']->fatal('Saldo > min');
		//$GLOBALS['log']->fatal('dias antes: ' . $dias);
		//$GLOBALS['log']->fatal('saldo antes: ' . $row['CONTACTS_CSTM_LFTM_SAL81DE02']);
		$dias = $dias + 1;
		$contact_bean->lftm_dias_saldo_positivo_c = $dias;
		//$GLOBALS['log']->fatal('Novo Dias: ' . $contact_bean->lftm_dias_saldo_positivo_c);

		//Usado para o agendador repetir para todos os registros e não apenas 1;
		RegistrySaldo\Registry::getInstance()->drop('triggered_starts');
		$contact_bean->save();
		
		//$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
		
	}
	
	//$GLOBALS['log']->fatal('All Contacts Saved');
    return true;
}
?>