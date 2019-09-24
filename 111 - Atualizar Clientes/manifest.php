<?php

$dt = new DateTime();
$manifest = array(
	'key' => 20190924101553,
	'name' => 'atualizacao_clientes',
	'acceptable_sugar_flavors' => array('PRO', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array('regex_matches' => array('9.*', '10.*')),
	'author' => 'Lifetime TI',
	'description' => 'Atualizar Clientes Diariamente',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => $dt->format('Y-m-d H:i:s'),
	'type' => 'module',
	'version' => '5.1',
);

$installdefs = array(

	'id' => 'pck_20190924101553',
	'copy' => array(
		0 => 
			array(
				'from' => '<basepath>/atualizacao_clientes.php',
				'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/atualizacao_clientes.php',
			),

		1 => 
			array(
				'from' => '<basepath>/pt_BR.atualizacao_clientes.php',
				'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.atualizacao_clientes.php',
			)
    ),
    
	'post_execute' => array(
		'<basepath>/post_install_actions.php'
	)
);



