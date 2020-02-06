<?php

    $hook_version = 1;  

    $hook_array['before_save'][] = Array(
        //Processing index. For sorting the array.
        10,
    
        //Label. A string value to identify the hook.
        'Before save - pré calcula o campo de renda bruta antes',
    
        //The PHP file where your class is located.
        'custom/Extension/modules/Opportunities/Ext/hook_camb_opp.php',
    
        //The class the method is in.
        'Opportunities_hooks',
    
        //The method to call.
        'calc_cambio'
    );
