<?php

/**
 * Get voltage of port in PDU device.
 *
 * Under $port variable HostBill will load port in question.
 * For instance: $port = '3';
 * So look for port 3 max current:
 * OID: .1.3.6.1.4.1.34097.3.1.1.7.3
 *
 * Save voltage into $voltage variable as string. Set in [mV]
 * Ie:
 * $voltage = '121'; //Maximum current now is 121 mV
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

$snmp = HBLoader::LoadComponent('Net/SNMP_wrapper');
$snmp->Connect($app['ip'],161,$app['read']);

$voltage = $snmp->Get('.1.3.6.1.4.1.318.1.1.26.6.3.1.6.1'); //.$port);
if(!$voltage) {
    throw new Exception("Unable to fetch voltage from PDU");
}


$voltage = str_ireplace('INTEGER: ','',$voltage); //v
$voltage*=1000;

