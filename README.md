# ProKreedz plugin  [![GitHub release](https://img.shields.io/github/release/michaelkheel/ProKreedz.svg)](https://github.com/MichaelKheel/ProKreedz/releases)
This repository is dedicated to the ProKreedz plugin, designed to showcase the top table in a web-based format.

### Supported Build
* ReHLDS 3.4.0.X
* Linux 5787 and higher
* Windows 5758 and higher

### AMXMODX Version
* 1.8.1+

### Required modules
* amxmodx
* amxmisc
* cstrike
* engine
* fun
* fakemeta
* hamsandwich
* dhudmessage
* geoip
* mysql

### Install Guide
1. **MySQL Database:**
- Ensure you have a MySQL database set up.
2. **Configure MySQL Connection:**
- Open the `config.php` file.
- Configure the MySQL connection details:
```C#
    define("DB_HOST", "localhost");
    define("DB_USER", "your_user");
    define("DB_PASS", "your_password");
    define("DB_NAME", "db_name");
    define("DB_TYPE", "mysql");
```

