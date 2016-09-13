<?php
require_once("/etc/inc/globals.inc");
require_once("/etc/inc/functions.inc");
require_once("classes/autoload.inc.php");

$return = new stdClass();
$op =  $argv[1];

/*
*************************************************************************************
* Pega todos os gateways cadastrados no pfsense
*************************************************************************************
*/

function getGateways(){
    $a_gateways = return_gateways_array();
    $dados = array();
    $a=0;
    foreach ($a_gateways as $gw){
        $dados[$a]['{#NAME}'] = (string)strtoupper($gw['name']);
        $dados[$a]['{#GW}']   = (string)strtoupper($gw['gateway']);
        $a++;
    }
    return $dados;
}

/** 
******************************************************************************
* traz o status do gateway
******************************************************************************
*/
function getStatusGateways($nome = '',$item){
    $gateways_status = array();
    $gateways_status = return_gateways_status(true);


    //se vazio 
    if ($nome==''){
        return 'ZBX_NOTSUPPORTED';
    }
        
    if ($item=='status'){
        if ($gateways_status[$nome][$item] == "none" ){
            return $gateways_status[$nome][$item] = 1;
        }elseif ($gateways_status[$nome][$item] == "down" ){
            return $gateways_status[$nome][$item] = 0;
        }elseif ($gateways_status[$nome][$item] == "loss" ){
            return $gateways_status[$nome][$item] = 2;
        }elseif ($gateways_status[$nome][$item] == "delay" ){
            return $gateways_status[$nome][$item] = 3;
        }else{
            return $gateways_status[$nome][$item] = 4;
        }
    //limpa delay
    }elseif($item=='delay'){
        return $gateways_status[$nome][$item] = (float)str_replace('ms','',$gateways_status[$nome][$item]);
    }elseif($item=='loss'){
        return $gateways_status[$nome][$item] = (float)str_replace('%','',$gateways_status[$nome][$item]);
    }elseif($item=='stddev'){
        return $gateways_status[$nome][$item] = (float)str_replace('ms','',$gateways_status[$nome][$item]);
    }else{
       return  $gateways_status[$nome][$item];
    }
    
}




switch ($op){
    case 'discovery':
         $return->data = array();
        $return->data = getGateways();

        echo json_encode($return);
        break;

    case 'status':
        echo getStatusGateways($argv[2],$argv[3]);
        break;
}



exit;
