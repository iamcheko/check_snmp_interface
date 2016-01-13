# check_snmp_interface
This script is intended to be an icinga, nagios or naemon plugin which measures the network traffic of one or mor network interfaces via SNMP.

# Usage
First of all, don't run this script as root. It will create a temporary file called /tmp/<hostname>_check_snmp_interface___IF__.gap, with the actual measures. Where _IF_ gets replaced by the network interface name. The script comes with a help option.
```
$ ./check_snmp_interface --help
check_snmp_interface 0.0.1

GNU v2 or later, see <http://www.fsf.org/copyleft/gpl.txt>

 -?, --usage
   Print usage information
 -h, --help
   Print detailed help screen
 -V, --version
   Print version information
 --extra-opts=[section][@file]
   Read options from an ini file. See http://nagiosplugins.org/extra-opts for usage
 -H, --hostname=STRING
   The host name of the requested interfaces
 -C, --community=STRING
   The SNMP readonly community string
 --username=STRING
   The username, needed for SNMP version 3
 --authpassword=STRING
   The authentication password, needed for SNMP version 3
 --authprotocol=STRING
   
 --privpass=STRING
   
 --privproto=STRING
   
 --snmpversion=INTEGER
   Specify the SNMP Protocoll version (one of 1, 2, 3, default is 2)
 --port=INTEGER
   The service port for SNMP (default is 161)
 -d, --directory=STRING
   name of the directory where to stor the gap file (default /tmp)
 -g, --gapfile=STRING
   name of the gap file (default check_snmp_interface___IF__.gap)
 -i, --name=STRING
   View this help message
 -F, --viewflags
   View flags in statusline
 -A, --adminstat
   Observe the administration status of the interface
 -O, --operstat
   Observe the operation status of the interface
 -P, --promiscuous
   Observe the promiscuous mode status of the interface
 -r, --regex
   Do use regex to match name
 -f, --field=STRING
   One of ifName, ifDescr, or ifAlias
 -l, --label=STRING
   Which of the defined fields in the show argument shall be shown in the status line
 -a, --alias=STRING
   replace the label with an alias
 -w, --warning=STRING
   List of thresholds for warnings, has to be in order of show arguments
 -c, --critical=STRING
   List of thresholds for criticals, has to be in order of show arguments
 -s, --show=STRING
   Select which fields shall be shown and observerd (ifoutoctets,ifinoctets,ifoutdiscards,ifindiscards,ifouterrors,ifinerrors)
 -u, --unit=STRING
   use one of bps, Bps, kbps, kBps, Mbps, MBps, Gbps, GBps or % as unit
 -t, --timeout=INTEGER
   Seconds before plugin times out (default: 15)
 -v, --verbose
   Show details for command-line debugging (can repeat up to 3 times)
```
