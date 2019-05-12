# WEBTE ZADANIE
<https://147.175.121.210:4493/webte_zadanie/>  
login student - AIS  
login admin - admin/admin12345  


## ADMIN CODE
```php
<?php
    include "config.php";
    $mysqli = new mysqli($hostname,$username,$password,$db);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");


    if (isAdmin($_SESSION['user'],$mysqli)) {...}


    function isAdmin($name,$mysqli) {
        $query = "SELECT id, login, password
                           FROM admins
                           WHERE login='".$name."'";
        $result = $mysqli->query($query);
        if(mysqli_num_rows($result)==1) {
            return true;
        }
        else return false;
    }
?> 

```

## SK/ENG
-do filov lang_en.php a lang_sk.php treba definovať všetok text, ktorý sa prekladá ako konšatnty, aby bola stránka dvojjazyčná  
-najlepšie by bolo aby v oboch súboroch išli konšanty rovnako po sebe

## DB admins
| id | login | password |
|----|-------|----------|
| 1 | admin | admin12345|

password_hash($password, PASSWORD_DEFAULT)
