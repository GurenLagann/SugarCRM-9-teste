<?php

    /**
     * Giovanni de Almeida
     */

    use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryNET;

    array_push($job_strings, 'lftm_it_atualiza_net');

    function lftm_it_atualiza_net() {
        
		$sql = "UPDATE contacts c1 INNER JOIN contacts_cstm c2 ON c2.id_c = c1.id SET c2.lftm_net_c = 0.00 WHERE c2.lftm_net_c IS NULL";
		
		$conn = $GLOBALS['db']->getConnection();
		$conn->executeQuery($sql);
		
		$sQAux = new SugarQuery();
		$sQAux->from(BeanFactory::newBean('PCP01_PosConsPrincipal'), array('alias' => 'P'));
		$sQAux->join('Contacts', array('alias' => 'C'));
		$sQAux->select->field("id");
		$sQAux->select->fieldRaw("MAX(lftm_data_posicao_c) as max_date");
		$sQAux->where->equals('P.deleted','0');
		$sQAux->where->equals('C.deleted','0');
		$sQAux->groupBy('C.id');


        $sql = "SELECT 
					T1.id as id_contact, T4.lftm_net_c as net_pos, T2.lftm_net_c as net_cl, T4.id_c as id_pos 
				FROM 
					(SELECT C3.id, MAX(C1.lftm_data_posicao_c) as max_date 
						FROM pcp01_posconsprincipal_cstm C1 
						INNER JOIN pcp01_posconsprincipal_contacts_c C2 ON C1.id_c = C2.pcp01_posconsprincipal_contactspcp01_posconsprincipal_idb 
						INNER JOIN contacts C3 ON C3.id = C2.pcp01_posconsprincipal_contactscontacts_ida 
						INNER JOIN pcp01_posconsprincipal C5 ON C5.id = C1.id_c 
						WHERE C5.deleted = 0 AND C3.deleted = 0
						GROUP BY C3.id) T1 
					INNER JOIN contacts_cstm T2 ON T1.id = T2.id_c 
					INNER JOIN pcp01_posconsprincipal_contacts_c T3 ON T1.id = T3.pcp01_posconsprincipal_contactscontacts_ida 
					INNER JOIN pcp01_posconsprincipal_cstm T4 ON T4.id_c = T3.pcp01_posconsprincipal_contactspcp01_posconsprincipal_idb 
					INNER JOIN pcp01_posconsprincipal T5 ON T5.id = T4.id_c 
				WHERE 
					T1.max_date = T4.lftm_data_posicao_c 
					AND T5.deleted = 0 
					AND NOT (T2.lftm_net_c = T4.lftm_net_c) 
				LIMIT 50";
		
		
		
		$stmt = $conn->executeQuery($sql);

		//$GLOBALS['log']->fatal("Iniciando atualização de Net e análise de perfil");

		$hoje = new TimeDate($current_user);
		$hoje = $hoje->getNow(true);
		
        while ($row = $stmt->fetch()) {

            $contact_bean = BeanFactory::retrieveBean('Contacts', $row['id_contact'], array('disable_row_level_security' => true));
			$GLOBALS['log']->fatal("Processando contato " . $contact_bean-> name);
            if (isset($contact_bean) && isset($contact_bean-> name) && !empty($contact_bean-> name)) {

            	$seg_old = $contact_bean-> lftm_segmentacao_cliente_c;

				if ($row['net_pos'] < 1000) 
				{
					$contact_bean-> lftm_status_cliente_c = 'Inativo';

					if ($contact_bean-> lftm_segmentacao_cliente_c != 'Online') {

						$contact_bean-> lftm_segmentacao_cliente_c = 'Online';
						$contact_bean-> chk_email_net_c = 1;
					}
				}
				elseif ($row['net_pos'] >= 1000 && $row['net_pos'] < 100000) 
				{
					$contact_bean-> lftm_status_cliente_c = 'Ativo';

					if ($contact_bean-> lftm_segmentacao_cliente_c != 'Online') {

						$contact_bean-> lftm_segmentacao_cliente_c = 'Online';
						$contact_bean-> chk_email_net_c = 1;
					}
				}
				elseif ($row['net_pos'] >= 100000 && $row['net_pos'] < 300000) 
				{
					$contact_bean-> lftm_status_cliente_c = 'Ativo';

					if ($contact_bean-> lftm_segmentacao_cliente_c != 'Plus')
					{
						if($seg_old == 'Online')
						{
							$new_prev = $hoje->modify("+12 months");
							$new_prev = $new_prev->asDb();
							$contact_bean-> dt_previsao_acompanhamento_c = $new_prev;
						}

						$contact_bean-> lftm_segmentacao_cliente_c = 'Plus';
						$contact_bean-> chk_email_net_c = 1;
					}
				}
				elseif ($row['net_pos'] >= 300000 && $row['net_pos'] < 1000000) 
				{
					$contact_bean-> lftm_status_cliente_c = 'Ativo';

					if ($contact_bean-> lftm_segmentacao_cliente_c != 'Unique')
					{
						if($seg_old == 'Online' || $seg_old == 'Plus')
						{
							$new_prev = $hoje->modify("+6 months");
							$new_prev = $new_prev->asDb();
							$contact_bean-> dt_previsao_acompanhamento_c = $new_prev;
						}

						$contact_bean-> lftm_segmentacao_cliente_c = 'Unique';
						$contact_bean-> chk_email_net_c = 1;
					}
				}
				elseif ($row['net_pos'] >= 1000000) 
				{
					$contact_bean-> lftm_status_cliente_c = 'Ativo';

					if ($contact_bean-> lftm_segmentacao_cliente_c != 'Private')
					{
						if($seg_old == 'Online' || $seg_old == 'Plus' || $seg_old == 'Unique')
						{
							$new_prev = $hoje->modify("+3 months");
							$new_prev = $new_prev->asDb();
							$contact_bean-> dt_previsao_acompanhamento_c = $new_prev;
						}

						$contact_bean-> lftm_segmentacao_cliente_c = 'Private';
						$contact_bean-> chk_email_net_c = 1;
					}
				}
				
				$contact_bean-> lftm_net_c = $row['net_pos'];
				
				//$GLOBALS['log']->fatal("Net atualizado");
				
				//Usado para o agendador repetir para todos os registros e não apenas 1
				RegistryNET\Registry::getInstance()->drop('triggered_starts');
				$contact_bean->save();                
            }
        }
        return true;
    }
