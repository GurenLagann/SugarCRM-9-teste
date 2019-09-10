
--UPDATE Nets
UPDATE contacts_cstm as cstm INNER JOIN (SELECT 
				T1.id as id_contact, T4.lftm_net_c as net_pos, T4.lftm_data_posicao_c  
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
				AND T5.deleted = 0) as pos ON pos.id_contact = cstm.id_c SET cstm.lftm_net_c = pos.net_pos WHERE pos.id_contact = cstm.id_c;

-- UPDATE Seg : Online
UPDATE contacts_cstm SET lftm_segmentacao_cliente_c = 'Online', lftm_status_cliente_c = 'Ativo' WHERE lftm_net_c < 100000 AND lftm_net_c > 1000;

-- UPDATE Seg : Plus
UPDATE contacts_cstm SET lftm_segmentacao_cliente_c = 'Plus', lftm_status_cliente_c = 'Ativo' WHERE lftm_net_c < 300000 AND lftm_net_c >= 100000;

-- UPDATE Seg : Private
UPDATE contacts_cstm SET lftm_segmentacao_cliente_c = 'Private', lftm_status_cliente_c = 'Ativo' WHERE lftm_net_c >= 1000000;

-- UPDATE Seg : Unique
UPDATE contacts_cstm SET lftm_segmentacao_cliente_c = 'Unique', lftm_status_cliente_c = 'Ativo' WHERE lftm_net_c < 1000000 AND lftm_net_c >= 300000;

-- UPDATE Data evasão
UPDATE contacts_cstm as cstm INNER JOIN (
  SELECT 
    T1.id as id_contact, T4.lftm_net_c as net_pos, T4.lftm_data_posicao_c as dataPos  
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
    T1.max_date = T4.lftm_data_posicao_c AND T4.lftm_net_c = 0 AND T5.deleted = 0
) as pos ON pos.id_contact = cstm.id_c SET cstm.lftm_evasao_c = dataPos WHERE pos.id_contact = cstm.id_c;
