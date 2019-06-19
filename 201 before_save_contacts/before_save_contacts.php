<?php

if (!defined('sugarEntry') || !sugarEntry) die ('Not A Valid Entry Point');

require_once('include/SugarLogger/LoggerManager.php');
require_once('include/utils.php');

//$GLOBALS['log']->fatal('---------- Começou o CALCULO_GER ----------');

class before_save_contacts
{
	function beforeSave($bean, $event, $arguments)
	{

		$id_cliente = $bean->id;

		//$GLOBALS['log']->fatal('ID: '. $id_cliente);
		
		global $current_user;

		//Valida se não tem outra conta com o mesmo número
		//$GLOBALS['log']->fatal('Validador começando');
		if ($bean->lftm_numero_conta_c != null && $bean->lftm_numero_conta_c != '')
		{
			$Query = new SugarQuery();
			// $GLOBALS['log']->fatal('Criou query');
			$Query->from(BeanFactory::getBean('Contacts'));
			// $GLOBALS['log']->fatal('query 2');
			$Query->where()->equals('lftm_numero_conta_c',$bean->lftm_numero_conta_c);
			// $GLOBALS['log']->fatal('query 3');
			$Query->where()->equals('deleted',0);
			// $GLOBALS['log']->fatal('vai entrar no if');

			// Para o caso de edição (update) da conta
			if($bean->fetched_row['lftm_numero_conta_c'] != '') 
			{ 
				// $GLOBALS['log']->fatal('entrou no if');
				// $GLOBALS['log']->fatal('Update dentro do if '.$bean->id);
				$Query->where()->notEquals('id',$bean->id);
			}
			// $GLOBALS['log']->fatal('vai executar!');
			$results = $Query->execute();
			// $GLOBALS['log']->log('Rodou a query');		
			if($results != null)
			{
				// $GLOBALS['log']->fatal('Ja existe uma conta com o CNPJ preenchido!');
				throw new SugarApiExceptionInvalidParameter('Ja existe uma conta com este número!');
			}
		}


		
		//codigo que verifica se usuario está tentando alterar a numero da conta

		//$GLOBALS['log']->fatal('------- INICIO HOOK Num Conta -------');

		if (!isset($bean->validacao_Conta) || $bean->validacao_Conta === false)
		{
			$bean->validacao_Conta = true;
			//Salva o ID da conta
			//$GLOBALS['log']->fatal(print_r($bean,true));
			$con_Id = $bean->id;
			//$GLOBALS['log']->fatal('id: ' .$con_Id);
		
			$old_con = new Contact();
			$old_con->retrieve($con_Id);
			//$GLOBALS['log']->fatal(print_r($old_con,true));
			$user = new User();
			$user->retrieve($bean->modified_user_id);
			//$GLOBALS['log']->fatal($bean->modified_user_id);
			//$GLOBALS['log']->fatal(print_r($user,true));

			$num = $bean->lftm_numero_conta_c;
			$num_old = $old_con->lftm_numero_conta_c;
			
			//$GLOBALS['log']->fatal('num: ' .$num);
			//$GLOBALS['log']->fatal('num_old: ' .$num_old);

			if($user->is_admin == 0)
			{
				if($num_old != '' && $num_old != $num)
				{
					//$GLOBALS['log']->fatal('------- ENTROU -------');
					throw new SugarApiExceptionInvalidParameter('O número da conta não pode ser alterado!');
				}
			}
		}
		//$GLOBALS['log']->fatal('------- FIM HOOK Num Conta -------');
	

		//codigo que pega as 3 ultimas receitas do cliente e soma
		//$GLOBALS['log']->fatal('------- INICIO HOOK GER_CONTA -------');

		$data = new TimeDate($current_user);
		$dataNova = $data->getNow(true);
		//$GLOBALS['log']->fatal('Data Nova: '. $dataNova);
		$dataFinal = $dataNova->modify("-110 days");
		$dataFinal = $dataFinal->asDb();
		//$GLOBALS['log']->fatal('Data Final: '. $dataFinal);
		$dataFinal = substr($dataFinal, 0, 10);
		//$GLOBALS['log']->fatal('Data Final substr: '. $dataFinal);


		$sql_ger = "SELECT l1.id l1_id, l1.name l1_name 
				FROM contacts 
				INNER JOIN  ger01_gerenciamentocliente_contacts_c l1_1 ON 
				contacts.id=l1_1.ger01_gerenciamentocliente_contactscontacts_ida AND l1_1.deleted=0 

				INNER JOIN  ger01_gerenciamentocliente l1 ON l1.id=l1_1.ger01_gere60bccliente_idb AND l1.deleted=0 
				LEFT JOIN ger01_gerenciamentocliente_cstm l1_cstm ON l1.id = l1_cstm.id_c 

				WHERE (((l1.name LIKE 'Receita%') 
				AND (l1_cstm.lftm_mes_referencia_c >= '". $dataFinal ."' AND l1_cstm.lftm_mes_referencia_c <= 'NOW()') 
				AND (contacts.id='". $id_cliente ."'))) 
				AND  contacts.deleted=0";

		$conn = $GLOBALS['db']->getConnection();

		//$GLOBALS['log']->fatal('Got Connection OPP_ADERIDA');

		$stmt = $conn->executeQuery($sql_ger);

		//$GLOBALS['log']->fatal('Query executed OPP_ADERIDA');

		$buffer = 0;

		while($row_ger = $stmt->fetch())
		{
			//$GLOBALS['log']->fatal('Valor do Buffer 1: ' . $buffer);
				
			$ger_bean = BeanFactory::retrieveBean('Ger01_GerenciamentoCliente', $row_ger['l1_id'], array('disable_row_level_security' => true));
			
			$bmi = $ger_bean->bolsa_mais_institucional_c;
			
			//$GLOBALS['log']->fatal('Valor do bmi: ' . $bmi);
			
			$buffer = $bmi + $buffer;
			
			//$GLOBALS['log']->fatal('Valor do Buffer 2: ' . $buffer);
		}

		$bean->lftm_receita_media_3m_c = $buffer;
		
		//$GLOBALS['log']->fatal('Processing Contact: ' . $bean->full_name);
	
		//$GLOBALS['log']->fatal('---------- Terminou o CALCULO_GER ----------');


		//CODIGO PARA PEGAR O VALOR ATUAL DO SALDO
		//$GLOBALS['log']->fatal('------- INICIO HOOK ATUALIZA_SALDO -------');

		$sql_cash = "SELECT IFNULL(l1.id,'') l1_id
		,IFNULL(l1.name,'') l1_name
		,l1_cstm.lftm_data_cc_c l1_cstm_lftm_data_cc_c

		FROM contacts
		INNER JOIN  pca01_posconscash_contacts_c l1_1 ON contacts.id=l1_1.pca01_posconscash_contactscontacts_ida AND l1_1.deleted=0

		INNER JOIN  pca01_posconscash l1 ON l1.id=l1_1.pca01_posconscash_contactspca01_posconscash_idb AND l1.deleted=0
		LEFT JOIN pca01_posconscash_cstm l1_cstm ON l1.id = l1_cstm.id_c

		WHERE (((contacts.id='". $id_cliente ."'
		))) 
		AND  contacts.deleted=0 
		ORDER BY l1_cstm_lftm_data_cc_c DESC;";

		$conn = $GLOBALS['db']->getConnection();

		//$GLOBALS['log']->fatal('Got Connection OPP_ADERIDA');

		$stmt = $conn->executeQuery($sql_cash);

		//$GLOBALS['log']->fatal('Query executed OPP_ADERIDA');

		$row_cash = $stmt->fetch();
			
		$cash_bean = BeanFactory::retrieveBean('PCA01_PosConsCash', $row_cash['l1_id'], array('disable_row_level_security' => true));
		
		$saldo = $cash_bean->lftm_saldod0_c;
		
		//$GLOBALS['log']->fatal('Valor do saldo: ' . $saldo);

		$bean->lftm_saldo_atual_c = $saldo;

		//$GLOBALS['log']->fatal('Valor do net em cliente: ' . $bean->lftm_saldo_atual_c);
		
		//$GLOBALS['log']->fatal('Processing Contact: ' . $bean->full_name);
		
		//$GLOBALS['log']->fatal('---------- Terminou o ATUALIZA_SALDO ----------');
	}
}

?>