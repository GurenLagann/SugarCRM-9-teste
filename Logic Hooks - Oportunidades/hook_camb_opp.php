<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("data/BeanFactory.php");
require_once('include/SugarQuery/SugarQuery.php');
require_once('include/SugarLogger/LoggerManager.php');
require_once('include/utils.php');


class Opportunities_hooks{
	
	function calc_cambio($bean, $event, $arguments)
	{
	    try {

            // $GLOBALS['log']->fatal("O Hook foi iniciado");
            // $GLOBALS['log']->fatal("\n\$bean->lftm_it_camb_taxa_pronto_c :".$bean->lftm_it_camb_taxa_pronto_c."\n".
                                //    "\$bean->lftm_it_camb_taxa_cambial_c :".$bean->lftm_it_camb_taxa_cambial_c."\n".
                                //    "\$bean->lftm_it_camb_valor_me_c :".$bean->lftm_it_camb_valor_me_c."\n");
            
            //---------------RECEITA DA OPERAÇÃO--------------------------------------------

            if($bean->opportunity_type == 'cambio'){

                if($bean->lftm_it_camb_op_c == 1){
                  
                    $bean->lftm_it_camb_receita_op_c = ($bean->lftm_it_camb_valor_me_c * ($bean->lftm_it_camb_taxa_pronto_c - $bean->lftm_it_camb_taxa_cambial_c));
                    //$GLOBALS['log']->fatal("Caso 1.1 :".$bean->lftm_it_camb_receita_op_c.".");

                  }else
                  
                  if($bean->lftm_it_camb_op_c == 2)
                  $bean->lftm_it_camb_receita_op_c = ($bean->lftm_it_camb_valor_me_c * ($bean->lftm_it_camb_taxa_cambial_c - $bean->lftm_it_camb_taxa_pronto_c));
                          
                   //$GLOBALS['log']->fatal("Caso 2 :".$bean->lftm_it_camb_receita_op_c.".");
            }
            
            //-----------------RECEITA LIFETIME-----------------------------------------------

            // if($bean->lftm_it_camb_parceiro_c==1){
            //     $bean->lftm_it_camb_receita_lftm_c = $bean->lftm_it_camb_receita_op_c * 0.55;
            // }else
            // if($bean->lftm_it_camb_parceiro_c==2||3||4){
            //     $bean->lftm_it_camb_receita_lftm_c = $bean->lftm_it_camb_receita_op_c * 0.50;
            // }else
            // if($bean->lftm_it_camb_parceiro_c==5){
            //     $bean->lftm_it_camb_receita_lftm_c = $bean->lftm_it_camb_receita_op_c * 0.65;
            // }else
            // if($bean->lftm_it_camb_parceiro_c==7){
            //     $bean->lftm_it_camb_receita_lftm_c = $bean->lftm_it_camb_receita_op_c * 0.30;
            // }else
            // if($bean->lftm_it_camb_parceiro_c==10){
            //     $bean->lftm_it_camb_receita_lftm_c = $bean->lftm_it_camb_receita_op_c * 0.20;
            // }else
            // if($bean->lftm_it_camb_parceiro_c==9){
            //     $bean->lftm_it_camb_receita_lftm_c = $bean->lftm_it_camb_receita_op_c * 0.25;
            // }else
            // if($bean->lftm_it_camb_parceiro_c==6||8){
            //     $bean->lftm_it_camb_receita_lftm_c = $bean->lftm_it_camb_receita_op_c * 0.10;
            // }

            //-----------------SPREAD DA OPERAÇÃO--------------------------------------------

            if ($bean->lftm_it_camb_taxa_pronto_c > $bean->lftm_it_camb_taxa_cambial_c) {

                if ($bean->lftm_it_camb_taxa_cambial_c == 0) $aux = 0; 
                else $aux = $bean->lftm_it_camb_taxa_pronto_c / $bean->lftm_it_camb_taxa_cambial_c;
                
                $bean->lftm_it_camb_spread_c = 100 * ($aux - 1);  

            }else{
                
                if ($bean->lftm_it_camb_taxa_cambial_c == 0) $aux = 0; 
                else $aux = $bean->lftm_it_camb_taxa_cambial_c / $bean->lftm_it_camb_taxa_pronto_c;

                $bean->lftm_it_camb_spread_c = 100 * ($aux - 1);  
            }
            //-----------------RECEITA LIFETIME (LIQUIDA)-------------------------------------------------------------

            $bean->lftm_it_camb_receita_lftm_lq_c= ($bean->lftm_it_camb_receita_lftm_c*9535)/10000;

            //--------------------------------------------------------------------------------------------------------
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("[ERRO] no Logic Hook :".$e." ----------------------");
        }
        
    }
}
?>