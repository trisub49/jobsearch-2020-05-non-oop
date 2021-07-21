<?php
    if(!isset($_SESSION['UserID']) || (isset($_SESSION['UserID']) && $_SESSION['UserType'] == 1)) echo $noenter;
    else
    {
        $now = date("Y-m-d");
        if(isset($_POST['addjob4']))
        {
            $userid = $_SESSION['UserID'];
            $job_name = $_SESSION['fjob_name'];
            $job_categoryname = $_SESSION['fjob_category'];
            $result = dbquery("SELECT * FROM kategoriak WHERE kategoria_nev='$job_categoryname'",$connectionx);
            $result2 = mysqli_fetch_assoc($result);
            $category_id = $result2['ID']; 
            $job_deadline = $_SESSION['fjob_deadline'];
            $job_pos = $_SESSION['fjob_pos'];
            $job_desc = $_SESSION['fjob_desc'];
            $whattodo = "INSERT INTO hirdetesek VALUES(null, $userid, 1, '$job_name', $category_id, '$job_desc', '$now', '$job_deadline', '$job_pos')";
            dbquery($whattodo,$connectionx);
            unset($_SESSION['fjob_name']);
            unset($_SESSION['fjob_category']);
            unset($_SESSION['fjob_pos']);
            unset($_SESSION['fjob_deadline']);
            unset($_SESSION['fjob_desc']);
            header("location: index.php?pg=lister");
        }
        else if(isset($_POST['addjob2']))
        {
            $_SESSION['fjob_name'] = $_POST['fjob_name'];
            $_SESSION['fjob_category'] = $_POST['fjob_category'];
            $_SESSION['fjob_pos'] = $_POST['fjob_pos'];
            $_SESSION['fjob_deadline'] = $_POST['fjob_deadline'];
            $_SESSION['fjob_desc'] = $_POST['fjob_desc'];
            echo 
            '
                <h4><b>Hirdetés ellenőrzése</b></h4><hr>
                <div class="msg_box">A feladni kívánt hirdetés így nézne ki. Ha hibát találsz kattints lent a "Vissza" gombra, ha pedig minden megfelel kattints a "Kész!"-re.
                </div>
            ';
            echo 
            '
                <div class="job_all_2">
                <div class="job_header">
                <span class="job_name">'.$_POST['fjob_name'].'</span>
                <div class="job_regtime">'.$now.'</div>
                </div>
                <div class="job_content">
                <table class="job_table d-none d-sm-block">
                <tr><td class="icono-folder iex"</td><td class="job_bla">Feladó:</td><td class="job_company">'.$_SESSION['UserCompany'].'</td></tr>
                <tr><td class="icono-list iex"</td><td class="job_bla">Kategória:</td><td class="job_category">'.$_POST['fjob_category'].'</td></tr>
                <tr><td class="icono-locationArrow iex"</td><td class="job_bla">Munkavégzés helye:</td><td class="job_category">'.$_POST['fjob_pos'].'</td></tr>
                <tr><td class="icono-exclamationCircle iex"</td><td class="job_bla">Jelentkezési határidő:</td><td class="job_deadline">'.$_POST['fjob_deadline'].'</td></tr>
                </table>
                <table class="d-block d-sm-none">
                <tr><td class="icono-folder iex"</td><td class="job_company">'.$_SESSION['UserCompany'].'</td></tr>
                <tr><td class="icono-list iex"></td><td class="job_category">'.$_POST['fjob_category'].'</td></tr>
                <tr><td class="icono-locationArrow iex"></td><td class="job_category">'.$_POST['fjob_pos'].'</td></tr>
                <tr><td class="icono-exclamationCircle iex"></td><td class="job_deadline">'.$_POST['fjob_deadline'].'</td></tr>
                </table>
                </div>
                <div class="job_desc">
                <h5><b>A munkáról:</b></h5>
                <div class="job_desc_2">'.nl2br($_POST['fjob_desc']).'</div>
                </div>
            ';
            if(!empty($_SESSION['UserDescription']))
            {
                echo
                '
                    <div class="comp_desc">
                    <h5><b>A cégről: </b></h5>
                    '.nl2br($_SESSION['UserDescription']).'
                    </div>
                ';
            }
            echo 
            '
                </div>
                <br><br>
                <form id="form_add_job_3" method="POST" action="index.php?pg=addjob">
                <input name="addjob3" type="button" value="Vissza" onClick="history.go(-1)"><input name="addjob4" type="submit" value="Kész!">
                </form>
            ';
        }
        else
        {
            $now = date("Y-m-d");
            $result = dbquery("SELECT kategoria_nev FROM kategoriak",$connectionx);
            echo '<datalist id="fjob_category">';
            while($categories = mysqli_fetch_assoc($result))
            {
                echo '<option value="'.$categories['kategoria_nev'].'">';
            }
            echo '</datalist><datalist id="fjob_pos">';
            $result2 = dbquery("SELECT * FROM telepulesek GROUP BY nev",$connectionx);
            while($citys = mysqli_fetch_assoc($result2))
            {
                echo '<option value="'.$citys['nev'].'">';
            }
            echo 
            '
                </datalist>
                <h4><b>Hirdetés feladása</b></h4><hr>
                <div class="c_content">
                <form id="form_add_job_2" method="POST" action="index.php?pg=addjob">
                <label for="fjob_name">Munkakör megnevezése:</label>
                <input name="fjob_name" type="text" placeholder="Kőműves, java programozó, stb..." required><br>
                <label for="fjob_category">Kategória:</label>
                <input list="fjob_category" name="fjob_category" required><br>
                <label for="fjob_desc">Információ a munkáról, feltételek, juttatások:</label>
                <textarea id="fjob_desc" name="fjob_desc" maxlength="1024" placeholder="Az itt megadott leírás fog megjelenni a hirdetésben" required></textarea>
                <label for="fjob_pos">Munkavégzés helye:</label>
                <input list="fjob_pos" name="fjob_pos" required><br>
                <label for="fjob_deadline">Jelentkezési határidő:</label><br>
                <input type="date" name="fjob_deadline" min='.$now.' required><br><br>
                <div class="submitholder"><input name="addjob2" type="submit" value="Hirdetés"><br><br></div>
                </div>
            ';
        }
    }
?>