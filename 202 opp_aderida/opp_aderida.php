<?php

if (!defined('sugarEntry') || !sugarEntry) die ('Not A Valid Entry Point');

require_once('include/SugarLogger/LoggerManager.php');

$GLOBALS['log']->fatal('---------- Começou o OPP_ADERIDA ----------');

class before_save_class
{
	function before_save($bean, $event, $arguments)
	{
		if($bean->opportunity_type == 'ReceitaExisting' && $bean->sales_stage == 'Closed Won' && $bean->lftm_status_operacional_c == 'Concluida')
		{	

			$id_opp = $bean->id;

			//$GLOBALS['log']->fatal('ID: '. $id_opp);

			$sql = "SELECT IFNULL(l1.id,'') l1_id
				,IFNULL(l1.first_name,'') l1_first_name
				,IFNULL(l1.last_name,'') l1_last_name
				,IFNULL(l1.salutation,'') l1_salutation,IFNULL(l1.title,'') l1_title

				FROM opportunities
				INNER JOIN  contacts_opportunities_1_c l1_1 ON opportunities.id=l1_1.contacts_opportunities_1opportunities_idb AND 	l1_1.deleted=0

				INNER JOIN  contacts l1 ON l1.id=l1_1.contacts_opportunities_1contacts_ida AND l1.deleted=0

				WHERE (((opportunities.id='". $id_opp ."'))) 
				AND  opportunities.deleted=0;";

			$conn = $GLOBALS['db']->getConnection();
	
			//$GLOBALS['log']->fatal('Got Connection OPP_ADERIDA');
	
			$stmt = $conn->executeQuery($sql);
	
			//$GLOBALS['log']->fatal('Query executed OPP_ADERIDA');
	
			while($row = $stmt->fetch())
			{
				$estrategia = $bean->lftm_estrategia_rv_c;

				$estrategia = ",^" . $estrategia . "^";

				//$GLOBALS['log']->fatal('estrategia: '. $estrategia);

				$contact_bean = BeanFactory::retrieveBean('Contacts', $row['l1_id'], array('disable_row_level_security' => true));
		
				$aderidas = $contact_bean->lftm_estrategias_rv_c;

				//$GLOBALS['log']->fatal('aderidas: '. $aderidas);

				$aderidas = $aderidas . $estrategia;

				//$GLOBALS['log']->fatal('Nova aderidas: '. $aderidas);

				$contact_bean->lftm_estrategias_rv_c = $aderidas;

				//$GLOBALS['log']->fatal('contact_bean->lftm_estrategias_rv_c: '. $contact_bean->lftm_estrategias_rv_c);
			
				$contact_bean->save();
		
				$GLOBALS['log']->fatal('Processing Contact: ' . $contact_bean->full_name);
			
				$GLOBALS['log']->fatal('---------- Terminou o OPP_ADERIDA ----------');
			}
		}
	}
}
?>
