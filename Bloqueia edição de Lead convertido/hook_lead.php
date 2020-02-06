<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("data/BeanFactory.php");
require_once('include/SugarQuery/SugarQuery.php');
require_once('include/SugarLogger/LoggerManager.php');
require_once('include/utils.php');


class Leads_hooks{
	
	function block_converted_lead($bean, $event, $arguments)
	{   
        global $current_user;

            //$GLOBALS['log']->fatal("Hook converte lead");

            if($bean->converted == 1){
                if($current_user->isAdmin() == 1){
                    //$GLOBALS['log']->fatal("This is admin user");
                    
                }
                
                else{
                    //$GLOBALS['log']->fatal("This is regular user");
                    throw new SugarApiExceptionInvalidParameter('Leads convertidos não podem ser editados');
                }
            }
        
    }
}
?>