# check_snmp_interface
This script is intended to be an icinga, nagios or naemon plugin which measures the network traffic of one or more network interfaces via SNMP.

The php script is needed by pnp4nagios and is made for one network interface.

# Usage
First of all, don't run this script as root. It will create a temporary file called /tmp/<hostname>_check_snmp_interface___IF__.gap, with the actual measures. Where _IF_ gets replaced by the network interface name. The script comes with a help option.
```
$ ./check_snmp_interface -h
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
   The host name of the requested network interfaces.
 -C, --community=STRING
   The SNMP readonly community string.
 --username=STRING
   The username, needed for SNMP version 3.
 --authpassword=STRING
   The authentication password, needed for SNMP version 3.
 --authprotocol=STRING
   The privacy type, needed for SNMP version 3.
 --privpass=STRING
   The private key, optional for SNMP version 3.
 --privproto=STRING
   The privacy type, optional for SNMP version 3.
 --snmpversion=INTEGER
   Specify the SNMP Protocoll version (one of 1, 2 or 3, default is 2).
 --port=INTEGER
   The service port for SNMP (default is 161).
 -d, --directory=STRING
   The name of the directory where to stor the gap file (default /tmp)
 -g, --gapfile=STRING
   The name of the gap file (default check_snmp_interface___IF__.gap)
 -i, --name=STRING
   The name of the network interface that needs to be observerd.
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

# Example

Measure the network traffic of eth0 on localhost.

```
./check_snmp_interface -H localhost -C mycommunity -i eth0 -u bps -s ifoutoctets,ifinoctets,ifoutdiscards,ifindiscards,ifouterrors,ifinerrors -w none,none,none,none,none,none -c none,none,none,none,none,none

Network Interface OK - eth0 Outbound=42343.97bps  Inbound=5952.30bps  | 'eth0_ifoutoctets'=42343.96812749bps;;;;1000000000 'eth0_ifinoctets'=5952.29747675963bps;;;;1000000000 'eth0_ifoutdiscards'=0pkts;; 'eth0_ifindiscards'=0pkts;; 'eth0_ifouterrors'=0pkts;; 'eth0_ifinerrors'=0pkts;;
```

The resulting graph would look like this:
![check_snmp_interface](https://cloud.githubusercontent.com/assets/9155784/12415535/83af5378-be9c-11e5-8637-75aa1372f123.png)
