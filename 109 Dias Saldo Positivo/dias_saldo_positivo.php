<?php

/**
 * GAM#FAC
 */

use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistrySaldo;

array_push($job_strings, 'dias_saldo_positivo');

function dias_saldo_positivo() 
{
	
	$GLOBALS['log']->fatal('------- dias_saldo_positivo -------');

	$sql = "SELECT IFNULL(contacts.id,'') primaryid
			,IFNULL(contacts.first_name,'') contacts_first_name
			,IFNULL(contacts.last_name,'') contacts_last_name

			FROM contacts

			 WHERE ((1=1)) 
			AND  contacts.deleted=0;";

	$GLOBALS['log']->fatal('SQL: ' . $sql);

	$conn = $GLOBALS['db']->getConnection();
	
	$GLOBALS['log']->fatal('Got Connection');
	
	$stmt = $conn->executeQuery($sql);
	
	$GLOBALS['log']->fatal('Query executed');
	
	while($row = $stmt->fetch()) 
	{	

		$contact_bean = BeanFactory::retrieveBean('Contacts', $row['primaryid'], array('disable_row_level_security' => true));

		$saldo_cliente = $contact_bean->lftm_saldo_atual_c;

		$dias = $contact_bean->lftm_dias_saldo_positivo_c;

		$min = $contact_bean->lftm_saldo_min_c;

		//$GLOBALS['log']->fatal('entrou no if');
		if($dias > 0 && $saldo_cliente < $min)
		{
			$GLOBALS['log']->fatal('Dias > 0 e Saldo < min');
			$GLOBALS['log']->fatal('dias antes: ' . $dias);
			$GLOBALS['log']->fatal('saldo antes: ' . $saldo_cliente);
			$contact_bean->lftm_dias_saldo_positivo_c = 0;
			$GLOBALS['log']->fatal('Zerou-> ' . $contact_bean->lftm_dias_saldo_positivo_c);

			//Usado para o agendador repetir para todos os registros e não apenas 1;
			RegistrySaldo\Registry::getInstance()->drop('triggered_starts');
			$contact_bean->save();
			
			$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
		}
		
		if ($saldo_cliente >= $min) 
		{
			$GLOBALS['log']->fatal('Saldo > min');
			$GLOBALS['log']->fatal('dias antes: ' . $dias);
			$GLOBALS['log']->fatal('saldo antes: ' . $saldo_cliente);
			$dias = $dias + 1;
			$contact_bean->lftm_dias_saldo_positivo_c = $dias;
			$GLOBALS['log']->fatal('Novo Dias-> ' . $contact_bean->lftm_dias_saldo_positivo_c);

			//Usado para o agendador repetir para todos os registros e não apenas 1;
			RegistrySaldo\Registry::getInstance()->drop('triggered_starts');
			$contact_bean->save();
			
			$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
		}
	}
	
	$GLOBALS['log']->fatal('All Contacts Saved');
    return true;
}