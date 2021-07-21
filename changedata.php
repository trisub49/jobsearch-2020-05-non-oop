<?php
    if(isset($_SESSION['UserID']))
    {
        echo 
        '
            <h4><b>Adataid szerkesztése</b></h4><hr>
            <div class="c_content">
        ';
        if($_SESSION['UserType'] == 1)
        {
            $mvid = $_SESSION['UserID'];
            $action = @$_GET['act'];
            if($action == 3)
            {
                $del = @$_GET['del'];
                if(isset($del))
                {
                    $result = dbquery("DELETE FROM munkahelyek WHERE ID='$del' AND mvID='$mvid'",$connectionx);
                }
                else if(isset($_POST['r_submit']))
                {
                    $school = $_POST['r_iskola'];
                    $date = $_POST['r_datum'];
                    $type = $_POST['r_vegz'];
                    dbquery("INSERT INTO munkahelyek VALUES(null,'$mvid','$school','$date','$type')",$connectionx);
                }
                echo
                '
                <form id="form_changedata_3" method="POST" action="index.php?pg=changedata&act=3">
                <label for="r_iskola">Munkahely/cég neve:</label><br>
                <input name="r_iskola" type="text" placeholder="pl.: Türr István Gazdasági Szakgimnázium" required><br>
                <label for="r_datum">Mettől, meddig dolgoztál itt?:</label><br>
                <input name="r_datum" type="text" placeholder="pl.: 2016-2020" required><br>
                <label for="r_vegz">Betöltött munkakör:</label><br>
                <input name="r_vegz" type="text" placeholder="pl.: Rendszergazda" required>
                <br><br>
                <div class="submitholder"><input name="r_submit" type="submit" value="Hozzáadás"></div><br>
                </form>
                ';
                $schools = dbquery("SELECT * FROM munkahelyek WHERE mvID='$mvid'",$connectionx);
                if(mysqli_num_rows($schools) != 0)
                {
                    echo '<table>';
                    while($sc = mysqli_fetch_assoc($schools))
                    {
                        echo '<tr class="schools_tr"><td>'.$sc['munkahely'].'</td><td>'.$sc['datum'].'</td><td>'.$sc['munkakor'].'</td><td><a class="job_link" href="index.php?pg=changedata&act=3&del='.$sc['ID'].'"><i class="icono-cross"></i></a></tr>';
                    }
                    echo '</table>';
                }
                echo '</div>';
            }
            else if($action == 2)
            {
                $del = @$_GET['del'];
                if(isset($del))
                {
                    $result = dbquery("DELETE FROM tanulmanyok WHERE ID='$del' AND mvID='$mvid'",$connectionx);
                }
                else if(isset($_POST['r_submit']))
                {
                    $school = $_POST['r_iskola'];
                    $date = $_POST['r_datum'];
                    $type = $_POST['r_vegz'];
                    dbquery("INSERT INTO tanulmanyok VALUES(null,'$mvid','$school','$date','$type')",$connectionx);
                }
                echo
                '
                <form id="form_changedata_2" method="POST" action="index.php?pg=changedata&act=2">
                <label for="r_iskola">Oktatási intézmény neve:</label><br>
                <input name="r_iskola" type="text" placeholder="pl.: Türr István Gazdasági Szakgimnázium" required><br>
                <label for="r_datum">Mettől, meddig tanultál itt?:</label><br>
                <input name="r_datum" type="text" placeholder="pl.: 2016-2020" required><br>
                <label for="r_vegz">Megszerzett végzettség:</label><br>
                <input name="r_vegz" type="text" placeholder="pl.: Rendszergazda" required>
                <br><br>
                <div class="submitholder"><input name="r_submit" type="submit" value="Hozzáadás"></div><br>
                </form>
                ';
                $schools = dbquery("SELECT * FROM tanulmanyok WHERE mvID='$mvid'",$connectionx);
                if(mysqli_num_rows($schools) != 0)
                {
                    echo '<table>';
                    while($sc = mysqli_fetch_assoc($schools))
                    {
                        echo '<tr class="schools_tr"><td>'.$sc['iskola'].'</td><td>'.$sc['datum'].'</td><td>'.$sc['vegzettseg'].'</td><td><a class="job_link" href="index.php?pg=changedata&act=2&del='.$sc['ID'].'"><i class="icono-cross"></i></a></tr>';
                    }
                    echo '</table>';
                }
                echo '</div>';
            }
            else if($action == 1)
            {
                if(isset($_POST['r_submit']))
                {
                    $newname = $_SESSION['UserName'];
                    $newemail = $_SESSION['UserEmail'];
                    $newpos = $_SESSION['UserHome'];
                    $newtel = $_SESSION['UserPhone'];
                    $error = 0;
                    $set = 0;
                    if($_POST['r_nev'] != $_SESSION['UserName']) 
                    {
                        $newname = $_POST['r_nev'];
                        $set = 1;
                    }
                    if($_POST['r_mail'] != $_SESSION['UserEmail'])
                    {
                        $set = 1;
                        $newemail = $_POST['r_mail'];
                        $result = dbquery("SELECT * FROM munkavallalok WHERE email='$newemail'",$connectionx);
                        if(mysqli_num_rows($result) != 0)
                        {
                            echo '<span class="err_msg">Ez az email cím már regisztrálva van!</span><br>';
                            $error = 1;
                        }
                    }
                    if($_POST['r_hely'] != $_SESSION['UserHome']) 
                    {
                        $newpos = $_POST['r_hely'];
                        $set = 1;
                    }
                    if($_POST['r_tel'] != $_SESSION['UserPhone']) 
                    {
                        $newtel = $_POST['r_tel'];
                        $set = 1;
                    }
                    if($error == 0)
                    {
                        if($set == 1)
                        {
                            $uid = $_SESSION['UserID']; 
                            dbquery("UPDATE munkavallalok SET nev='$newname', email='$newemail', lakhely='$newpos', telefonszam='$newtel' WHERE ID='$uid'",$connectionx);
                            $_SESSION['UserName'] = $newname;
                            $_SESSION['UserEmail'] = $newemail;
                            $_SESSION['UserHome'] = $newpos;
                            $_SESSION['UserPhone'] = $newtel;
                            echo '<div class="msg_box">Sikeres adatmódosítás!</div>';
                        } 
                        else echo '<div class="msg_box">Nem végeztél el semmilyen módosítást.</div>';
                    }
                    echo
                    '
                        <form id="form_changedata_1" method="POST" action="index.php?pg=changedata&act=1">
                        <label for="r_nev">Saját név:</label><br>
                        <input name="r_nev" type="text" value="'.$newname.'" required><br>
                        <label for="r_mail">E-Mail:</label><br>
                        <input name="r_mail" type="email" value="'.$newemail.'" required><br>
                        <label for="r_hely">Lakhely (város):</label><br>
                        <input name="r_hely" type="search" value="'.$newpos.'" required><br>
                        <label for="r_tel">Telefonszám:</label><br>
                        <input name="r_tel" type="tel" value="'.$newtel.'" required><br>
                        <br><br>
                        <div class="submitholder"><input name="r_submit" type="submit" value="Megváltoztat"></div><br>
                        </form>
                        </div>
                    ';
                }
                else
                {
                    echo
                    '
                    <form id="form_changedata_1" method="POST" action="index.php?pg=changedata&act=1">
                    <label for="r_nev">Saját név:</label><br>
                    <input name="r_nev" type="text" value="'.$_SESSION['UserName'].'" required><br>
                    <label for="r_mail">E-Mail:</label><br>
                    <input name="r_mail" type="email" value="'.$_SESSION['UserEmail'].'" required><br>
                    <label for="r_hely">Lakhely (város):</label><br>
                    <input name="r_hely" type="search" value="'.$_SESSION['UserHome'].'" required><br>
                    <label for="r_tel">Telefonszám:</label><br>
                    <input name="r_tel" type="tel" value="'.$_SESSION['UserPhone'].'" required><br>
                    <br><br>
                    <div class="submitholder"><input name="r_submit" type="submit" value="Megváltoztat"></div><br>
                    </form>
                    </div>
                    ';
                }
            }
        }
        else if($_SESSION['UserType'] == 2)
        {
            if(isset($_POST['r_submit']))
            {
                $newcname = $_SESSION['UserCompany'];
                $newname = $_SESSION['UserName'];
                $newemail = $_SESSION['UserEmail'];
                $newcomppos = $_SESSION['UserCompanyPos'];
                $newtel = $_SESSION['UserPhone'];
                $newdesc = $_SESSION['UserDescription'];
                $error = 0;
                $set = 0;
                if($_POST['r_cnev'] != $_SESSION['UserCompany'])
                {
                    $set = 1;
                    $newcname = $_POST['r_cnev'];
                    $result = dbquery("SELECT * FROM munkaadok WHERE cegnev='$newcname'",$connectionx);
                    if(mysqli_num_rows($result) != 0)
                    {
                        echo '<span class="err_msg">Ez a cégnév már regisztrálva van!</span><br>';
                        $error = 1;
                    }
                }
                if($_POST['r_nev'] != $_SESSION['UserName']) 
                {
                    $newname = $_POST['r_nev'];
                    $set = 1;
                }
                if($_POST['r_mail'] != $_SESSION['UserEmail'])
                {
                    $set = 1;
                    $newemail = $_POST['r_mail'];
                    $result = dbquery("SELECT * FROM munkaadok WHERE email='$newemail'",$connectionx);
                    if(mysqli_num_rows($result) != 0)
                    {
                        echo '<span class="err_msg">Ez az email cím már regisztrálva van!</span><br>';
                        $error = 1;
                    }
                }
                if($_POST['r_hely'] != $_SESSION['UserCompanyPos']) 
                {
                    $newcomppos = $_POST['r_hely'];
                    $set = 1;
                }
                if($_POST['r_tel'] != $_SESSION['UserPhone']) 
                {
                    $newtel = $_POST['r_tel'];
                    $set = 1;
                }
                if($_POST['r_desc'] != $_SESSION['UserDescription']) 
                {
                    $newdesc = $_POST['r_desc'];
                    $set = 1;
                }
                if($error == 0)
                {
                    if($set == 1)
                    {
                        $uid = $_SESSION['UserID']; 
                        dbquery("UPDATE munkaadok SET cegnev='$newcname', nev='$newname', email='$newemail', telephely='$newcomppos', telefonszam='$newtel', leiras='$newdesc' WHERE ID='$uid'",$connectionx);
                        $_SESSION['UserCompany'] = $newcname;
                        $_SESSION['UserName'] = $newname;
                        $_SESSION['UserEmail'] = $newemail;
                        $_SESSION['UserCompanyPos'] = $newcomppos;
                        $_SESSION['UserPhone'] = $newtel;
                        $_SESSION['UserDescription'] = $newdesc;
                        echo '<div class="msg_box">Sikeres adatmódosítás!</div>';
                    } 
                    else echo '<div class="msg_box">Nem végeztél el semmilyen módosítást.</div>';
                }
                echo 
                '
                    <form id="form_changedata_2" method="POST" action="index.php?pg=changedata">
                    <label for="r_cnev">Cégnév:</label><br>
                    <input name="r_cnev" type="text" value="'.$newcname.'" required><br>
                    <label for="r_nev">Saját név:</label><br>
                    <input name="r_nev" type="text" value="'.$newname.'" required><br>
                    <label for="r_mail">E-Mail:</label><br>
                    <input name="r_mail" type="email" value="'.$newemail.'" required><br>
                    <label for="r_hely">Telephely (város):</label><br>
                    <input name="r_hely" type="search" value="'.$newcomppos.'" required><br>
                    <label for="r_tel">Telefonszám:</label><br>
                    <input name="r_tel" type="tel" value="'.$newtel.'" required><br>
                    <label for="r_desc">Leírás a cégről:</label>
                    <textarea id="r_desc" name="r_desc" maxlength="1024">'.nl2br($newdesc).'</textarea>
                    <br><br>
                    <div class="submitholder"><input name="r_submit" type="submit" value="Megváltoztat"></div><br>
                    </form>
                    </div>
                ';
            }
            else
            {
                echo 
                '
                    <form id="form_changedata_2" method="POST" action="index.php?pg=changedata">
                    <label for="r_cnev">Cégnév:</label><br>
                    <input name="r_cnev" type="text" value="'.$_SESSION['UserCompany'].'" required><br>
                    <label for="r_nev">Saját név:</label><br>
                    <input name="r_nev" type="text" value="'.$_SESSION['UserName'].'" required><br>
                    <label for="r_mail">E-Mail:</label><br>
                    <input name="r_mail" type="email" value="'.$_SESSION['UserEmail'].'" required><br>
                    <label for="r_hely">Telephely (város):</label><br>
                    <input name="r_hely" type="search" value="'.$_SESSION['UserCompanyPos'].'" required><br>
                    <label for="r_tel">Telefonszám:</label><br>
                    <input name="r_tel" type="tel" value="'.$_SESSION['UserPhone'].'" required><br>
                    <label for="r_desc">Leírás a cégről:</label>
                    <textarea id="r_desc" name="r_desc" maxlength="1024">'.nl2br($_SESSION['UserDescription']).'</textarea>
                    <br><br>
                    <div class="submitholder"><input name="r_submit" type="submit" value="Megváltoztat"></div><br>
                    </form>
                    </div>
                ';
            }
        }
    }
    else echo $noenter;
?>