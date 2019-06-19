<?php

$manifest = array(    
    'acceptable_sugar_versions' =>
        array (
            'regex_matches' => array(
                0 => '8\.*'
            )
        ),
    'acceptable_sugar_flavors' =>
        array (
            0 => 'ENT',
            1 => 'ULT',
            2 => 'PRO'
        ),
    'readme' => '',
    'key' => '190620181355',
    'name' => 'TASK-AUDIT',
    'author' => 'giovanni.marazzi',
    'description' => 'Tarefas atrasadas em um dia (util) sao enviadas para auditoria',
    'is_uninstallable' => true,
    'published_date' => '2018-06-15',
    'type' => 'module',
    'version' => '1.0 Bean',
    'remove_tables' => 'prompt'
);

$installdefs = array (
    'id' => 'LATE-TASK',
    'copy' => array(
		array(
			'from' => '<basepath>/lang/pt_BR.lftm_it_task_audit_job.php',
			'to'   => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.lftm_it_task_audit_job.php',
		),
		array(
			'from' => '<basepath>/code/lftm_it_task_audit_job.php',
			'to'   => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/lftm_it_task_audit_job.php',
		)
	),
	'post_execute' => 
    array (
         '<basepath>/actions/post_install_actions.php'
    )
);
