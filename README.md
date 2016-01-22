# check_snmp_interface
This script is intended to be an icinga, nagios or naemon plugin which measures the network traffic of one or more network interfaces via SNMP.

The php script is needed by pnp4nagios and is made for one network interface.

# Usage
First of all, don't run this script as root. It will create a temporary file called /tmp/<hostname>_check_snmp_interface___IF__.gap, with the actual measures. Where _IF_ gets replaced by the network interface name. The script comes with a help option.

```
$ ./check_snmp_interface -h
check_snmp_interface 0.0.4

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
 -A, --adminstat=STRING
   Observe the administration status flag of the interface (Available flags are up, down, testing and none, default is none)
 -O, --operstat=STRING
   Observe the operation status flag of the interface (Available flags are up, down, testing, unknown, dormant, notpresent, lowerlayerdown and none, default is none)
 -P, --promiscuous=STRING
   Observe the promiscuous mode status flag of the interface (Available flags are on, off and none, default is none)
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

Measure the network traffic of eth0 on localhost. Only Inbound and outbound traffic is needed.

```
$ ./check_snmp_interface -H localhost -C mycommunity -i eth0
Network Interface OK - eth0 Outbound=408.96Bps  Inbound=161.42Bps  | 'eth0_ifoutoctets'=408.96Bps;;;0;125000000 'eth0_ifinoctets'=161.42Bps;;;0;125000000
```

Lets show the output in the status as percent.

```
$ ./check_snmp_interface -H localhost -C mycommunity -i eth0 -u %
Network Interface OK - eth0 Outbound=0.00%  Inbound=0.00%  | 'eth0_ifoutoctets'=77.16Bps;;;0;125000000 'eth0_ifinoctets'=110.58Bps;;;0;125000000
```

Add some thresholds for in- and outbound traffic in percent.

```
$ ./check_snmp_interface -H localhost -C mycommunity -i eth0 -u % -w 80,80 -c 90,90
Network Interface OK - eth0 Outbound=0.00%  Inbound=0.00%  | 'eth0_ifoutoctets'=8.71Bps;100000000.00;112500000.00;0;125000000 'eth0_ifinoctets'=15.95Bps;100000000.00;112500000.00;0;125000000
```

Show me also the operation status flag of the interface and alarm me if it is differen as expected.

```
$ ./check_snmp_interface -H localhost -C mycommunity -i eth0 -u % -w 80,80 -c 90,90 -O down
Network Interface OK - eth0 O=<span class="serviceCRITICAL">up</span> Outbound=0.00%  Inbound=0.00%  | 'eth0_ifoutoctets'=31.64Bps;100000000.00;112500000.00;0;125000000 'eth0_ifinoctets'=50.76Bps;100000000.00;112500000.00;0;125000000
```

Show me all available information and flags but do not alarm me for thrueput.

```
./check_snmp_interface -H localhost -C mycommunity -i eth0 -u bps -s ifoutoctets,ifinoctets,ifoutdiscards,ifindiscards,ifouterrors,ifinerrors -w none,none,none,none,none,none -c none,none,none,none,none,none -A up -O up -P off
Network Interface OK - eth0 A=<span class="serviceOK">up</span> O=<span class="serviceOK">up</span> P=<span class="serviceOK">off</span> Outbound=1805.89bps  Inbound=2024.84bps  | 'eth0_ifoutoctets'=225.74Bps;;;0;125000000 'eth0_ifinoctets'=253.11Bps;;;0;125000000 'eth0_ifoutdiscards'=0.00Pkts;; 'eth0_ifindiscards'=0.00Pkts;; 'eth0_ifouterrors'=0.00Pkts;; 'eth0_ifinerrors'=0.00Pkts;;
```

Show me the output of all interfaces

```
$ ./check_snmp_interface -H localhost -C mycommunity
Network Interface OK - eth0 Outbound=83.33Bps  Inbound=34.65Bps lo Outbound=0.00Bps  Inbound=0.00Bps xif1 Outbound=786.28Bps  Inbound=649.06Bps xif2 Outbound=140.48Bps  Inbound=185.21Bps xif3 Outbound=132.67Bps  Inbound=177.64Bps xif4 Outbound=0.00Bps  Inbound=0.00Bps xif5 Outbound=0.00Bps  Inbound=0.00Bps  | 'eth0_ifoutoctets'=83.33Bps;;;0;125000000 'eth0_ifinoctets'=34.65Bps;;;0;125000000 'lo_ifoutoctets'=0.00Bps;;;0;1250000 'lo_ifinoctets'=0.00Bps;;;0;1250000 'xif1_ifoutoctets'=786.28Bps;;;0;0 'xif1_ifinoctets'=649.06Bps;;;0;0 'xif2_ifoutoctets'=140.48Bps;;;0;0 'xif2_ifinoctets'=185.21Bps;;;0;0 'xif3_ifoutoctets'=132.67Bps;;;0;0 'xif3_ifinoctets'=177.64Bps;;;0;0 'xif4_ifoutoctets'=0.00Bps;;;0;0 'xif4_ifinoctets'=0.00Bps;;;0;0 'xif5_ifoutoctets'=0.00Bps;;;0;0 'xif5_ifinoctets'=0.00Bps;;;0;0
```

Show me the output for virtual interfaces only

```
$ ./check_snmp_interface -H localhost -C mycommunity -i xif -r
Network Interface OK - xif1 Outbound=687.67Bps  Inbound=528.74Bps xif2 Outbound=178.08Bps  Inbound=209.15Bps xif3 Outbound=149.46Bps  Inbound=192.52Bps xif4 Outbound=0.89Bps  Inbound=0.71Bps xif5 Outbound=0.89Bps  Inbound=0.71Bps  | 'xif1_ifoutoctets'=687.67Bps;;;0;0 'xif1_ifinoctets'=528.74Bps;;;0;0 'xif2_ifoutoctets'=178.08Bps;;;0;0 'xif2_ifinoctets'=209.15Bps;;;0;0 'xif3_ifoutoctets'=149.46Bps;;;0;0 'xif3_ifinoctets'=192.52Bps;;;0;0 'xif4_ifoutoctets'=0.89Bps;;;0;0 'xif4_ifinoctets'=0.71Bps;;;0;0 'xif5_ifoutoctets'=0.89Bps;;;0;0 'xif5_ifinoctets'=0.71Bps;;;0;0
```

The resulting graph would look like this:
![check_snmp_interface](https://cloud.githubusercontent.com/assets/9155784/12415535/83af5378-be9c-11e5-8637-75aa1372f123.png)
