<?php
    // adatbázis kapcsolódás
    function dbconnect($dbhost, $dbname, $dbuser, $dbpass)
    {
        if (!($link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)))
        {
            die("Hiba a kiszolgálóhoz történő csatlakozáskor! Hibakód: ".mysqli_connect_errno());
        }
        else
        {
            mysqli_query($link, "SET NAMES utf8");
          //  mysqli_set_charset($link, "utf8");
            return $link;
        }
    }

    // adatbázis lekérdezés
    function dbquery($sql, $connection)
    {
        $result = mysqli_query($connection, $sql);
        if ($result) return $result;
    }
    // kor számítás dátumból
    function get_age($dob)
    {
        if(!empty($dob))
        {
            $birthdate = new DateTime($dob);
            $today = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        }
        else return 0;
    }
    // város adatok betöltése
    function GetCategoryName($cid)
    {
        $result = dbquery("SELECT kategoria_nev FROM kategoriak WHERE ID='$cid'",$connectionx);
        $result2 = mysqli_fetch_assoc($result);
        return $result2['kategoria_nev'];
    }
    function check_image($path)
    {
        $a = getimagesize($path);
        $image_type = $a[2];
        if(in_array($image_type , array(IMAGETYPE_JPEG ,IMAGETYPE_PNG))) return true;
        return false;
    }
?>