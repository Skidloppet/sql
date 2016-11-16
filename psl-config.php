<?php
/**början på säker login...
 * These are the database login details
 */  

// att göra: flytta filen ur root till en egen mapp så att den inte kan bli upptäckt.

define("HOST", "localhost");     // The host you want to connect to.
define("USER", "sec_user");    // The database username. 
define("PASSWORD", "pass");    // The database password. 
define("DATABASE", "SlitABSkidloppet");    // The database name.
 
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
?>