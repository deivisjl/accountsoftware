<?php

$db = new mysqli("localhost", "root", "", "accountsoft");

mysqli_query($db, "SET NAMES ´utf8´");
// mysqldump --opt --user=root electronicadigital > Backup.sql
// mysql --user=root electronicadigital < Backup.sql
//127.0.0.1		localelectronica.com

/*
<VirtualHost *:80>
    ServerAdmin localelectronica.com
    DocumentRoot "D:/xampp/htdocs/localelectronica"
    ServerName localelectronica.com
    ##ErrorLog "logs/dummy-host2.example.com-error.log"
    ##CustomLog "logs/dummy-host2.example.com-access.log" common
</VirtualHost>
*/
?>