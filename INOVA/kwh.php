<?php

/**
 * Get current acumulated kWh of a port
 * This is used by power meter billing
 *
 * This is "fake" kwh readout, it uses avg amperage stored in db trough \power_collector module
 *
 * For instance: $port = '3';
 * Load current state into $kwh variable.
 * like: $kwh = 1120;
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

$power = ModuleFactory::singleton()->getModuleByFname('class.power_collector.php');
if(!$power) {
    throw new Exception("Power_Collector module is not active");
}
$date_to = date('Y-m-d H:i:s');
$date_from = date('Y-m-d H:i:s',strtotime($date_to.' - 1 hour'));
$kwh = $power->getPower($app['id'],$port,$date_from,$date_to);
