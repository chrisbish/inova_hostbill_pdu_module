<?php

/**
 * Get Active Power  of port in PDU device.
 *
 * Under $port variable HostBill will load port in question.
 * For instance: $port = '3';
 * So look for port 3 max current:
 * OID: .1.3.6.1.4.1.34097.3.1.1.7.3
 *
 * Save Active Power  into $active_power variable as string. Set in [W]
 * Ie:
 * $active_power = '121'; //Active Power  now is 121 W
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

$active_power = $snmp->Get('.1.3.6.1.4.1.63131.1.1.26.9.4.3.1.7.'.$port);
if(!$active_power) {
    throw new Exception("Unable to fetch  port's active power PDU");
}


$active_power = str_ireplace('INTEGER: ','',$active_power);

