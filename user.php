
<?php
    if(!isset($_SESSION['UserID']))
    {
        if(isset($_POST['b_gomb']))
        {
            $email = @$_POST['b_mail'];
            $result = dbquery("SELECT * FROM munkavallalok WHERE email='$email'", $connectionx);
            $result2 = dbquery("SELECT * FROM munkaadok WHERE email='$email'", $connectionx);
            if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0)
            {
                echo
                '
                <h4><b>Felhasználó</b></h4>
                <hr>
                <div class="c_content">
                    <span class="err_msg">Ez az E-Mail cím nincs regisztrálva!</span><br><br>
                    <form id="form_login_2" method="POST" action="index.php?pg=user">
                        <label for="b_mail">E-Mail:</label><br>
                        <input name="b_mail" type="email" value="'.$_POST['b_mail'].'" required><br>
                        <label for="b_jelszo">Jelszó:</label><br>
                        <input name="b_jelszo" type="password" value="'.$_POST['b_jelszo'].'" required minlength="8" maxlength="16"><br><br>
                        <div class="submitholder"><input name="b_gomb" type="submit" value="Bejelentkezés"><br><br>
                        <a href="index.php?pg=register"><b>Még nem regisztráltál?</b></a></div>
                    </form>
                </div>
                ';
            }
            else
            {
                if(mysqli_num_rows($result) != 0)
                {
                    $pass = escapeshellcmd($_POST['b_jelszo']);
                    $data = mysqli_fetch_assoc($result);
                    if(MD5($pass) != $data['jelszo'])
                    {
                        echo
                        '
                        <h4><b>Felhasználó</b></h4>
                        <hr>
                        <div class="c_content">
                            <span class="err_msg">A megadott jelszó hamis!</span><br><br>
                            <form id="form_login_2" method="POST" action="index.php?pg=user">
                                <label for="b_mail">E-Mail:</label><br>
                                <input name="b_mail" type="email" value="'.$_POST['b_mail'].'" required><br>
                                <label for="b_jelszo">Jelszó:</label><br>
                                <input name="b_jelszo" type="password" value="'.$_POST['b_jelszo'].'" required minlength="8" maxlength="16"><br><br>
                                <div class="submitholder"><input name="b_gomb" type="submit" value="Bejelentkezés"><br><br>
                                <a href="index.php?pg=register"><b>Még nem regisztráltál?</b></a></div>
                            </form>
                        </div>
                        ';
                    }
                    else
                    {
                        $_SESSION['UserID'] = $data['ID'];
                        $_SESSION['UserType'] = 1;
                        $_SESSION['UserName'] = $data['nev'];
                        $_SESSION['UserEmail'] = $data['email'];
                        $_SESSION['UserBirth'] = $data['szul_datum'];
                        $_SESSION['UserPhone'] = $data['telefonszam'];
                        $_SESSION['UserCategories'] = $data['kategorialista'];
                        $_SESSION['UserSchools'] = $data['tanulmanyok'];
                        $_SESSION['UserJobs'] = $data['munkahelyek'];
                        $_SESSION['UserHome'] = $data['lakhely'];
                        $id = $_SESSION['UserID'];
                        $log_date = date("y:m:d");
                        dbquery("UPDATE munkavallalok SET log_datum='$log_date' WHERE ID='$id'",$connectionx);
                        header("location: index.php?pg=user");
                    }
                }
                else if(mysqli_num_rows($result2) != 0)
                {
                    $pass = escapeshellcmd($_POST['b_jelszo']);
                    $data = mysqli_fetch_assoc($result2);
                    if(MD5($pass) != $data['jelszo'])
                    {
                        echo
                        '
                        <h4><b>Felhasználó</b></h4>
                        <hr>
                        <div class="c_content">
                            <span class="err_msg">A megadott jelszó hamis!</span><br><br>
                            <form id="form_login_2" method="POST" action="index.php?pg=user">
                                <label for="b_mail">E-Mail:</label><br>
                                <input name="b_mail" type="email" value="'.$_POST['b_mail'].'" required><br>
                                <label for="b_jelszo">Jelszó:</label><br>
                                <input name="b_jelszo" type="password" value="'.$_POST['b_jelszo'].'" required minlength="8" maxlength="16"><br><br>
                                <div class="submitholder"><input name="b_gomb" type="submit" value="Bejelentkezés"><br><br>
                                <a href="index.php?pg=register"><b>Még nem regisztráltál?</b></a></div>
                            </form>
                        </div>
                        ';
                    }
                    else
                    {
                        $_SESSION['UserID'] = $data['ID'];
                        $_SESSION['UserType'] = 2;
                        $_SESSION['UserName'] = $data['nev'];
                        $_SESSION['UserEmail'] = $data['email'];
                        $_SESSION['UserCompany'] = $data['cegnev'];
                        $_SESSION['UserPhone'] = $data['telefonszam'];
                        $_SESSION['UserCompanyPos'] = $data['telephely'];
                        $_SESSION['UserDescription'] = $data['leiras'];
                        $id = $_SESSION['UserID'];
                        $log_date = date("y:m:d");
                        dbquery("UPDATE munkaadok SET log_datum='$log_date' WHERE ID='$id'",$connectionx);
                        header("location: index.php?pg=user");
                    }
                }
            }
        }
        else
        {
            echo
            '
            <h4><b>Felhasználó</b></h4>
            <hr>
            <div class="c_content">
                <form id="form_login_2" method="POST" action="index.php?pg=user">
                    <label for="b_mail">E-Mail:</label><br>
                    <input name="b_mail" type="email" placeholder="valami@valami.com" required><br>
                    <label for="b_jelszo">Jelszó:</label><br>
                    <input name="b_jelszo" type="password" placeholder="********" required minlength="8" maxlength="16"><br><br>
                    <div class="submitholder"><input name="b_gomb" type="submit" value="Bejelentkezés"><br><br>
                    <a href="index.php?pg=register"><b>Még nem regisztráltál?</b></a></div>
                </form>
            </div>
            ';
        }
    }
    else
    {
        if(isset($_POST['l2_gomb']))
        {
            unset($_SESSION['UserID']);
            unset($_SESSION['UserName']);
            unset($_SESSION['UserEmail']);
            unset($_SESSION['UserBirth']);
            unset($_SESSION['UserType']);
            unset($_SESSION['UserCompany']);
            unset($_SESSION['UserDescription']);
            header("location: index.php?pg=user");
        }
        else
        {
            if($_SESSION['UserType'] == 1)
            {
                $cherror = 0;
                $userid = $_SESSION['UserID'];
                $picname = 'mvpic/mv_'.$userid.'.jpg';
                
                if(isset($_POST['deletepic'])) unlink($picname);
                else if(isset($_POST['fileup']))
                {
                    if (!empty($_FILES['fileToUpload']['tmp_name']))
                    {
                        if(check_image($_FILES['fileToUpload']['tmp_name']) == false) $cherror = 1;
                        else move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$picname);
                    }
                }
                
                if(empty($_SESSION['UserHome'])) $uhome = '<span class="err_msg">Nincs megadva</span>';
                else $uhome = $_SESSION['UserHome'];
                if(empty($_SESSION['UserPhone'])) $uphone = '<span class="err_msg">Nincs megadva</span>';
                else $uphone = $_SESSION['UserPhone'];
                echo
                '
                <h4><b>Álláskeresői profil</b></h4>
                <hr>
                <div id="showprofile">';
                if(!file_exists($picname)) echo '<div id="profilediv"><img id="profilepic" src="img/empty_user.jpg" alt="Saját kép"></div>';
                else echo '<div id="profilediv"><img id="profilepic" src="'.$picname.'" alt="Saját kép"></div>';
                echo
                '
                    <div id="profilediv2">
                    <table>
                    <tr><td class="data_1">Név:</td><td class="data_2">'.$_SESSION['UserName'].'</td></tr>
                    <tr><td class="data_1">Életkor:</td><td class="data_2">'.get_age($_SESSION['UserBirth']).'</td></tr>
                    <tr><td class="data_1">Lakhely:</td><td class="data_2">'.$uhome.'</td></tr>
                    <tr><td class="data_1">Telefonszám:</td><td class="data_2">'.$uphone.'</td></tr>
                    </table>
                    </div>
                    
                ';
                
                if(!file_exists($picname))
                {
                    echo '<div id="profextra">';
                    if($cherror == 1) echo '<span class="err_msg">A megadott fájl nem megfelelő képfájl! (JPG vagy PNG)</span>';
                    echo
                    '
                        <form action="index.php?pg=user" id="fileup" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
                        <input type="submit" value="Kép feltöltése" name="fileup">
                        </form>
                        <a class="job_link" href="index.php?pg=changedata&act=1"><div class="little_ch">Szerkesztés</div></a>
                        </div>
                    ';
                }
                else
                {
                    echo
                    '
                        <div id="profextra">
                        <form action="index.php?pg=user" id="filedel" method="post">
                        <input type="submit" value="Kép törlése" name="deletepic">
                        </form>
                        <a class="job_link" href="index.php?pg=changedata&act=1"><div class="little_ch">Szerkesztés</div></a>
                        </div>
                    ';
                } 
                echo 
                '
                    <div id="profilediv3">
                    <hr>
                    <h5><b>Tanulmányok:</b></h5>
                    <div id="profilediv4">
                ';
                $id = $_SESSION['UserID'];
                $sc_result = dbquery("SELECT * FROM tanulmanyok WHERE mvID='$id'",$connectionx);
                if(mysqli_num_rows($sc_result) == 0) echo '<span class="err_msg">Nincs megadva</span>';
                else
                {
                    while($sc_data = mysqli_fetch_assoc($sc_result))
                    {
                        echo '- '.$sc_data['iskola'].' '.$sc_data['datum'].' <b>('.$sc_data['vegzettseg'].')</b><br>';
                    }
                }
                echo 
                '
                    </div>
                    <a class="job_link" href="index.php?pg=changedata&act=2"><div class="little_ch">+ Hozzáadás</div></a>
                    <hr>
                    <h5><b>Munkahelyek:</b></h5>
                    <div id="profilediv5">
                ';
                $id = $_SESSION['UserID'];
                $sc_result = dbquery("SELECT * FROM munkahelyek WHERE mvID='$id'",$connectionx);
                if(mysqli_num_rows($sc_result) == 0) echo '<span class="err_msg">Nincs megadva</span>';
                else
                {
                    while($sc_data = mysqli_fetch_assoc($sc_result))
                    {
                        echo '- '.$sc_data['munkahely'].' '.$sc_data['datum'].' <b>('.$sc_data['munkakor'].')</b><br>';
                    }
                }
                echo 
                '
                    </div>
                    <a class="job_link" href="index.php?pg=changedata&act=3"><div class="little_ch">+ Hozzáadás</div></a>
                    </div>
                    </div>
                    <form id="form_logout" method="POST" action="index.php?pg=user">
                    <div class="submitholder"><input name="l2_gomb" type="submit" value="Kijelentkezés"><br><br></div>
                    </form>
                ';
            }
            else if($_SESSION['UserType'] == 2)
            {
                $userid = $_SESSION['UserID'];
                $picname = 'mapic/ma_'.$userid.'.jpg';
                echo
                '
                    <h4><b>Álláshirdetői profil</b></h4>
                    <hr>
                    <div id="c_showprofile">
                ';
                        /*if(!file_exists($picname)) 
                        {
                            echo 
                            '
                                <div id="c_profilediv">
                                <img id="c_profilepic" src="img/empty_user.jpg" alt="Cég logo">
                                </div>
                                <form action="index.php?pg=user" id="fileup_2" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <input type="submit" value="Feltöltés!" name="uppic">
                                </form>
                                <hr>
                            ';
                        }
                        else  
                        {
                            echo
                            '<div id="c_profilediv"><img id="c_profilepic" src="'.$picname.'" alt="Saját kép"></div>
                            <form action="index.php?pg=user" id="filedel" method="post">
                            <input type="submit" value="Kép törlése" name="deletepic">
                            </form>
                            <hr>
                            ';
                        }*/
                        echo 
                        '
                        <div id="c_profilediv2">
                        <table>
                        <tr><td class="data_1">Cégnév:</td><td class="data_2">'.$_SESSION['UserCompany'].'</td></tr>
                        <tr><td class="data_1">Képviselő:</td><td class="data_2">'.$_SESSION['UserName'].'</td></tr>
                        <tr><td class="data_1">Telephely:</td><td class="data_2">'.$_SESSION['UserCompanyPos'].'</td></tr>
                        <tr><td class="data_1">Telefonszám:</td><td class="data_2">'.$_SESSION['UserPhone'].'</td></tr>
                        </table>
                        </div>
                        <div id="c_profilediv3">
                        <h5><b>A cégről:</b></h5>
                        <hr>';
                        if(!empty($_SESSION['UserDescription'])) echo '<div id="c_profilediv4">'.$_SESSION['UserDescription'].'</div>';
                        else echo '<div id="c_profilediv4">Nincs megadva. (Nem kötelező)</div>';
                        echo
                        '
                        <hr>
                        <a class="job_link" href="index.php?pg=changedata"><div class="little_ch">Szerkesztés</div></a>
                        </div>
                    </div>
                    <form id="form_logout" method="POST" action="index.php?pg=user">
                    <div class="submitholder"><input name="l2_gomb" type="submit" value="Kijelentkezés"><br><br></div>
                    </form>
                ';
            }
            else echo 'Hiba az adatok betöltésekor!';
        }
    }
?>