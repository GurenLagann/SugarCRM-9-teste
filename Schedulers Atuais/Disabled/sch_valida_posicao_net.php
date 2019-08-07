<?php

    /**
     * JIRA#SLT-31
     */

    array_push($job_strings, 'sch_valida_posicao_net');

    function sch_valida_posicao_net() {
        $prefix = 'sch_valida_posicao_net: ';
        $sql = "
			SELECT 
			T3.id, 
			T5.lftm_net_c 
			FROM pcp01_posconsprincipal T1 
			INNER JOIN pcp01_posconsprincipal_contacts_c T2 
			ON T1.id = T2.`pcp01_posconsprincipal_contactspcp01_posconsprincipal_idb` AND T2.deleted = 0 AND T1.deleted = 0 
			INNER JOIN contacts T3 ON T3.id = T2.pcp01_posconsprincipal_contactscontacts_ida AND T3.deleted = 0 
			INNER JOIN contacts_cstm T4 ON T3.id = T4.id_c 
			INNER JOIN pcp01_posconsprincipal_cstm T5 ON T5.id_c = T1.id 
			WHERE
			(1=1)
			AND 
			DATE(T4.dt_ult_net_c) <= DATE(T1.date_entered) 
			GROUP BY T3.id 
			LIMIT 100
			";

        $result = $GLOBALS['db'] -> query($sql);

        while ($row = $GLOBALS['db'] -> fetchByAssoc($result)) {

            $contact_bean = BeanFactory::retrieveBean('Contacts', $row['id'], array('disable_row_level_security' => true));
            $user_bean = BeanFactory::retrieveBean('Users', $contact_bean -> assigned_user_id, array('disable_row_level_security' => true));

            if (isset($contact_bean) && isset($contact_bean -> name) && !empty($contact_bean -> name)) {
                $GLOBALS['log'] -> warn($prefix . 'Contact ID:'. $contact_bean -> id . ' lftm_net_c bean: ' . $contact_bean -> lftm_net_c . ', lftm_net_c db: ' . $row['lftm_net_c']);
                if ($contact_bean -> lftm_net_c != $row['lftm_net_c']) {

                    if ($row['lftm_net_c'] < 1000) 
					{
                        $contact_bean -> lftm_status_cliente_c = 'Inativo';

                        if ($contact_bean -> lftm_segmentacao_cliente_c != 'Online') {

                            $contact_bean -> lftm_segmentacao_cliente_c = 'Online';
                            $contact_bean -> chk_email_net_c = 1;
                        }
                    }
                    elseif ($row['lftm_net_c'] >= 1000 && $row['lftm_net_c'] < 100000) 
					{
                        $contact_bean -> lftm_status_cliente_c = 'Ativo';

                        if ($contact_bean -> lftm_segmentacao_cliente_c != 'Online') {

                            $contact_bean -> lftm_segmentacao_cliente_c = 'Online';
                            $contact_bean -> chk_email_net_c = 1;
                        }
                    }
                    elseif ($row['lftm_net_c'] >= 100000 && $row['lftm_net_c'] < 300000) 
					{
                        $contact_bean -> lftm_status_cliente_c = 'Ativo';

                        if ($contact_bean -> lftm_segmentacao_cliente_c != 'Plus') {

                            $contact_bean -> lftm_segmentacao_cliente_c = 'Plus';
                            $contact_bean -> chk_email_net_c = 1;
                        }
                    }
                    elseif ($row['lftm_net_c'] >= 300000 && $row['lftm_net_c'] < 1000000) 
					{
                        $contact_bean -> lftm_status_cliente_c = 'Ativo';

                        if ($contact_bean -> lftm_segmentacao_cliente_c != 'Unique') {

                            $contact_bean -> lftm_segmentacao_cliente_c = 'Unique';
                            $contact_bean -> chk_email_net_c = 1;
                        }
                    }
                    elseif ($row['lftm_net_c'] >= 1000000) 
					{
                        $contact_bean -> lftm_status_cliente_c = 'Ativo';

                        if ($contact_bean -> lftm_segmentacao_cliente_c != 'Private') {

                            $contact_bean -> lftm_segmentacao_cliente_c = 'Private';
                            $contact_bean -> chk_email_net_c = 1;
                        }
                    }
					
                    $contact_bean -> lftm_net_c = $row['lftm_net_c'];

                }

                if (isset($contact_bean -> chk_email_net_c) && $contact_bean -> chk_email_net_c == 1) {
                    $values_to_parse = array(
                        '{::Contacts::first_name::}' => $contact_bean -> first_name,
                        '{::Contacts::last_name::}' => $contact_bean -> last_name,
                        '{::Contacts::lftm_numero_conta_c::}' => $contact_bean -> lftm_numero_conta_c,
                        '{::Contacts::lftm_segmentacao_cliente_c::}' => $contact_bean -> lftm_segmentacao_cliente_c
                    );
					
					/*
					* DISPARO DE EMAIL COMENTADO POR FALTA DE TEMPLATE NA BASE
					*/
					$GLOBALS['log'] -> fatal($prefix . 'Iniciando disparo de E-mail!!!');
                    $addresses = array($user_bean -> email1 => (trim($user_bean -> first_name) . ' ' . $user_bean -> last_name));
                    $bcc = array();
                    $source = 'PA';
                    customEmailTemplateSender('d8e343bf-2580-544e-c8d7-5671d1f91803', $values_to_parse, $addresses, $bcc, $source);
                    $contact_bean -> chk_email_net_c = 0;
					
					$GLOBALS['log'] -> fatal($prefix . 'Disparo de E-mail realizado!!!');
					
                }

				if(isset($contact_bean -> lftm_status_cliente_c) && $contact_bean -> lftm_status_cliente_c === 'Ativo'
				&& isset($contact_bean -> prazo_definido_c) && $contact_bean -> prazo_definido_c == 0) 
				{
					$contact_bean -> alerta_enviado_c = 0;
					$contact_bean -> estouro_enviado_c = 0;
					$contact_bean -> inicio_prazo_c = date('Y-m-d h:m:s');
					$contact_bean -> prazo_acompanhamento_c = date('Y-m-d h:m:s', strtotime(date('Y-m-d h:m:s'). ' + 90 days'));
					$contact_bean -> prazo_relacionamento_c = date('Y-m-d h:m:s', strtotime(date('Y-m-d h:m:s'). ' + 30 days'));
					$contact_bean -> prazo_definido_c = 1;
				}
				elseif (isset($contact_bean -> lftm_status_cliente_c) && $contact_bean -> lftm_status_cliente_c === 'Inativo'
				&& isset($contact_bean -> prazo_definido_c) && $contact_bean -> prazo_definido_c == 1 )
				{
					$contact_bean -> prazo_definido_c = 0;					
				}
				
				$GLOBALS['log'] -> warn($prefix . 'Salvando registro: '. $contact_bean -> dt_ult_net_c .' Data Atual: '.date('Y-m-d') );
                $contact_bean -> dt_ult_net_c = date('Y-m-d');
                $contact_bean -> save();

            }

        }

        return true;

    }
