<?php

    $hook_version = 1;  

    $hook_array['before_save'][] = Array(
        //Processing index. For sorting the array.
        10,
    
        //Label. A string value to identify the hook.
        'Before save - bloqueia a edição de Leads convertidos para usuários comuns ',
    
        //The PHP file where your class is located.
        'custom/Extension/modules/Leads/Ext/hook_lead.php',
    
        //The class the method is in.
        'Leads_hooks',
    
        //The method to call.
        'block_converted_lead'
    );
