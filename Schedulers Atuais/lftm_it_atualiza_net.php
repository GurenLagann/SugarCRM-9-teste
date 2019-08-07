<?php

    /**
     * Giovanni de Almeida
     */

    use Sugarcrm\Sugarcrm\ProcessManager\Registry as RegistryNET;

    array_push($job_strings, 'lftm_it_atualiza_net');

    function lftm_it_atualiza_net() {
        
			$sql = "SELECT 
				T1.id as id_contact, T4.lftm_net_c as net_pos  
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
		
			$conn = $GLOBALS['db']->getConnection();
			$count = 0;
			$stmt = $conn->executeQuery($sql);

			$GLOBALS['log']->fatal("Iniciando atualização de Net e análise de perfil");
		
			while ($row = $stmt->fetch()) {
				$count = $count + 1;
				$contact_bean = BeanFactory::retrieveBean('Contacts', $row['id_contact'], array('disable_row_level_security' => true));
				$seg_old = $contact_bean->lftm_segmentacao_cliente_c;

				if ($row['net_pos'] < 1000){
					$dataEvade = new DateTime($row['']);
					$contact_bean->lftm_evasao_c = $dataEvase->format('Y-m-d H:i:s');
					$contact_bean->lftm_status_cliente_c = 'Inativo';
					if ($seg_old != 'Online' && $seg_old != 'Plus' && $seg_old != 'Unique' && $seg_old != 'Private') {
						$contact_bean->lftm_segmentacao_cliente_c = 'Online';
					}
				}
				elseif ($row['net_pos'] >= 1000 && $row['net_pos'] < 100000){
					$contact_bean->lftm_status_cliente_c = 'Ativo';
					if ($seg_old != 'Online' && $seg_old != 'Plus' && $seg_old != 'Unique' && $seg_old != 'Private') {
						$contact_bean->lftm_segmentacao_cliente_c = 'Online';
					}
				}
				elseif ($row['net_pos'] >= 100000 && $row['net_pos'] < 300000){
					$contact_bean->lftm_status_cliente_c = 'Ativo';
					if ($seg_old != 'Plus' && $seg_old != 'Unique' && $seg_old != 'Private'){
						$contact_bean->lftm_segmentacao_cliente_c = 'Plus';
					}
				}
				elseif ($row['net_pos'] >= 300000 && $row['net_pos'] < 1000000){
					$contact_bean->lftm_status_cliente_c = 'Ativo';
					if ($seg_old != 'Unique' && $seg_old != 'Private'){
						$contact_bean->lftm_segmentacao_cliente_c = 'Unique';
					}
				}
				elseif ($row['net_pos'] >= 1000000){
					$contact_bean->lftm_status_cliente_c = 'Ativo';
					if ($seg_old != 'Private'){
						$contact_bean->lftm_segmentacao_cliente_c = 'Private';
					}
				}
				$contact_bean->lftm_net_c = $row['net_pos'];
				//Usado para o agendador repetir para todos os registros e não apenas 1
				RegistryNET\Registry::getInstance()->drop('triggered_starts');
				$contact_bean->save();                
			}
			$GLOBALS['log']->fatal($count . " Clientes Atualizados com Sucesso");
			return true;
    }
