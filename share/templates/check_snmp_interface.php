<?php
#------------------------------------------------------------------------------
#
#   Konfiguration   : check_snmp_interface.php
#
#------------------------------------------------------------------------------
#
#   Beschreibung    : PNP Graph Template fuer check_snmp_interface
#
#   Author          : Marek Zavesicky
#   Version         : $Revision: $
#   Erstellt        : 2016/01/18
#   Letztes Update  : $Date: $
#
#   $Id: $
#   Change history  :
#                     $Log: $
#-------------------------------------------------------------------------------

#-------------------------------------------------------------------------------
#   General settings
#-------------------------------------------------------------------------------
#   Arrays start with 0 while DS starts with 1. Fill index 0 with some garbage.
$A_COLORS = array(
    '',
    '#71B90580', '#316BBB80', '#EA644A80', '#EC9D4880', '#ECD74880', '#48C4EC80'
);
$L_COLORS = array(
    '',
    '#A1BF04',   '#093572',   '#CC3118',   '#CC7016',   '#C9B215',   '#1598C3'
);

$LABELS = array(
    '',
    'Inbound', 'Outbound', 'Out discard', 'In discard', 'Out error', 'In errors'
);

#-------------------------------------------------------------------------------
#   General settings
#-------------------------------------------------------------------------------
$slen = 12;
$opt[1] = "";
$def[1] = "";
$opt[2] = "";
$def[2] = "";

#-------------------------------------------------------------------------------
#   Label and Titel settings
#-------------------------------------------------------------------------------
$ifname = str_replace("Network_Traffic_","",$servicedesc);
$ifname = str_replace("_","/",$ifname);
$ds_name[1] = "Interface Utilization for $hostname";
$opt[1] .= "--vertical-label \"$UNIT[1]\" ";
$opt[1] .= "--slope-mode ";
$opt[1] .= "--title \"Interface Utilization in bits per second for $ifname\" ";
$opt[1] .= "--watermark=\"Template: " . $TEMPLATE[1] . " by Marek Zavesicky\" ";

$ds_name[2] = "Interface Errors and Discards for $hostname";
$opt[2] .= "--vertical-label \"$UNIT[3]\" ";
$opt[2] .= "--title \"Interface Utilization in packets per second for $ifname\" ";
$opt[2] .= "--watermark=\"Template: " . $TEMPLATE[1] . " by Marek Zavesicky\" ";

#
#   Body definition graph
#-------------------------------------------------------------------------------
foreach ( $DS as $I )
{
    if (preg_match('/.*octets/', $NAME[$I]) ? true : false)
    {
        $def[1] .= rrd::def( "var$I", $rrdfile, $DS[$I], 'AVERAGE' );
        $def[1] .= rrd::area( "var$I", $A_COLORS[$I], rrd::cut( $LABELS[$I], $slen ) );
        $def[1] .= rrd::line1( "var$I", $L_COLORS[$I] );
        $def[1] .= rrd::gprint( "var$I", array("AVERAGE", "MAX", "LAST"), "%8.2lf%s");
    }
    else
    {
        $def[2] .= rrd::def( "var$I", $rrdfile, $DS[$I], 'AVERAGE' );
        $def[2] .= rrd::area( "var$I", $A_COLORS[$I], rrd::cut( $LABELS[$I], $slen ) );
        $def[2] .= rrd::line1( "var$I", $L_COLORS[$I] );
        $def[2] .= rrd::gprint( "var$I", array("AVERAGE", "MAX", "LAST"), "%8.2lf%s");
    }
}

?>
