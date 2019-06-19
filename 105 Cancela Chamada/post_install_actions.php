<?php

//the language files have not been integrated at this point so we use directly the message
if ($GLOBALS['current_language'] == "pt_BR") {
    $message = "Voce sera redirecionado automaticamente para o proximo passo de instalacao. Por favor espere alguns instantes...";
} else {
    $message = "You will be automatically redirected to the next step of the installation. Please wait a moment...";
}

echo "<script type='text/javascript'>
    SUGAR.util.doWhen('document.getElementById(\"install_complete_bar\").innerHTML == \"100%\"', function () {
        document.getElementById('displayLog').style.display='';
        $('form[action*=\"index.php?module=Administration&view=module&action=UpgradeWizard\"]').hide();
        $('#displayLog').append(\"<br /><br /><p><font size='4' color='red'>".$message."</font></p>\");
        setTimeout(function () {
            document.location='index.php?module=Administration&action=repair';
          }, 5000 );
    });
</script>";

