/*
ANVÄNDARE & RÄTTIGHETER
1. login attempt user

*/
-- select user, host from mysql.user;




-- 1. user för login
-- (redan skapad) CREATE USER 'sec_user'@'localhost' IDENTIFIED BY 'pass';
GRANT SELECT, INSERT, UPDATE ON SlitABSkidloppet.* TO 'sec_user' @'localhost';

