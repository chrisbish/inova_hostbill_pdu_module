<?php

/**
 * Get Apparent Power  of port in PDU device.
 *
 * Under $port variable HostBill will load port in question.
 * For instance: $port = '3';
 * So look for port 3 max current:
 * OID: .1.3.6.1.4.1.34097.3.1.1.7.3
 *
 * Save Apparent Power  into $apparent_power variable as string. Set in [VA]
 * Ie:
 * $apparent_power = '121'; //Apparent Power  now is 121 VA
 *
 * Connection details loaded from related App are available in $app array.
 * $app['ip'] - holds PDU ip address
 * $app['read'] - holds SNMP read community, default "public"
 * $app['write'] - holds SNMP write community, default "private"
 *
 *
 * If you wish to return error, throw new Exception.
 * like: throw new Exception('Something unexpected happen');
 */

$snmp = HBLoader::LoadComponent('Net/SNMP_wrapper',array('nocache'=>true));
$snmp->Connect($app['ip'],161,$app['read']);


$active_power = $snmp->Get('.1.3.6.1.4.1.63131.1.1.26.9.4.3.1.15.'.$port);
if(!$active_power) {
    throw new Exception("Unable to fetch  port's active power PDU");
}


$active_power = str_ireplace('INTEGER: ','',$active_power);



$power_factor = $snmp->Get('.1.3.6.1.4.1.63131.1.1.26.9.4.3.1.14');

if(!$power_factor) {
    $power_factor=1;
} else {
    $power_factor= str_ireplace('INTEGER: ','',$power_factor);
    $power_factor = $power_factor/100;
}


$apparent_power = floor($active_power / $power_factor);