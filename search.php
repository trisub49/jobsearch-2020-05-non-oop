<?php
    $notfind = 0;
    if(isset($_POST['a_gomb']))
    {
        $whattodo;
        $pos = @$_POST['a_hely'];
        $category = @$_POST['a_kategoria'];
        $search = @$_POST['a_kereses'];
        if(empty($_POST['a_kereses']) && empty($_POST['a_kategoria']) && !empty($_POST['a_hely'])) 
        {
            $whattodo = "SELECT * FROM hirdetesek INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE BINARY hely='$pos'";
        }
        else if(empty($_POST['a_kereses']) && !empty($_POST['a_kategoria']) && !empty($_POST['a_hely'])) 
        {
            $result2 = dbquery("SELECT ID FROM kategoriak WHERE kategoria_nev='$category'",$connectionx);
            $category_id = mysqli_fetch_assoc($result2);
            $category_id = $category_id['ID'];
            $whattodo = "SELECT * FROM hirdetesek INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE BINARY hely='$pos' AND BINARY kategoria='$category_id'";
        }
        else if(!empty($_POST['a_kereses']) && empty($_POST['a_kategoria']) && !empty($_POST['a_hely'])) 
        {
            $whattodo = "SELECT * FROM hirdetesek INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE BINARY hely='$pos' AND munkakor LIKE '%$search%'";
        }
        else if(!empty($_POST['a_kereses']) && !empty($_POST['a_kategoria']) && !empty($_POST['a_hely']))
        {
            $result2 = dbquery("SELECT ID FROM kategoriak WHERE kategoria_nev='$category'",$connectionx);
            $category_id = mysqli_fetch_assoc($result2);
            $category_id = $category_id['ID'];
            $whattodo = "SELECT * FROM hirdetesek INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE BINARY hely='$pos' AND BINARY kategoria='$category_id' AND BINARY munkakor LIKE '%$search%'";
        }
        $selected = dbquery($whattodo,$connectionx);
        if(mysqli_num_rows($selected) == 0) $notfind = 1;
        else
        {
            echo '<h4><b>'.mysqli_num_rows($selected).' találat:</b></h4><hr>';
            while($news = mysqli_fetch_assoc($selected))
            {
                $category_id = $news['kategoria'];
                $result2 = dbquery("SELECT kategoria_nev FROM kategoriak WHERE ID='$category_id'",$connectionx);
                $category_name = mysqli_fetch_assoc($result2);
                echo
                '
                <a class="job_link" href="index.php?pg=showjob&id='.$news['ID'].'">
                <div class="job_all">
                    <div class="job_header">
                        <span class="job_name">'.$news['munkakor'].'</span>
                        <div class="job_regtime">'.$news['fel_datum'].'</div>
                    </div>
                    <div class="job_content">
                        <table class="job_table d-none d-sm-block">
                            <tr><td class="icono-folder iex"</td><td class="job_bla">Feladó:</td><td class="job_company">'.$news['cegnev'].'</td></tr>
                            <tr><td class="icono-list iex"</td><td class="job_bla">Kategória:</td><td class="job_category">'.$category_name['kategoria_nev'].'</td></tr>
                            <tr><td class="icono-locationArrow iex"</td><td class="job_bla">Munkavégzés helye:</td><td class="job_category">'.$news['hely'].'</td></tr>
                            <tr><td class="icono-exclamationCircle iex"</td><td class="job_bla">Jelentkezési határidő:</td><td class="job_deadline">'.$news['hatarido'].'</td></tr>
                        </table>
                        <table class="d-block d-sm-none">
                            <tr><td class="icono-folder iex"</td><td class="job_company">'.$news['cegnev'].'</td></tr>
                            <tr><td class="icono-list iex"></td><td class="job_category">'.$category_name['kategoria_nev'].'</td></tr>
                            <tr><td class="icono-locationArrow iex"></td><td class="job_category">'.$news['hely'].'</td></tr>
                            <tr><td class="icono-exclamationCircle iex"></td><td class="job_deadline">'.$news['hatarido'].'</td></tr>
                        </table>
                    </div>
                </div>
                </a>
                ';
            }
            return 1;
        }
    }
    $result = dbquery("SELECT kategoria_nev FROM kategoriak",$connectionx);
    echo '<datalist id="categories">';
    while($categories = mysqli_fetch_assoc($result))
    {
        echo '<option value="'.$categories['kategoria_nev'].'">';
    }
    echo 
        '
        </datalist>
        <datalist id="cities">
        ';
    $result2 = dbquery("SELECT * FROM telepulesek GROUP BY nev",$connectionx);
    while($citys = mysqli_fetch_assoc($result2))
    {
        echo '<option value="'.$citys['nev'].'">';
    }
    echo
    '
    </datalist>
    <h4><b>Álláskeresés</b></h4>
    <hr>';
    if($notfind == 1) echo '<div class="msg_box">A keresési feltételek alapján nincs találat!</div>';
    echo '<div class="c_content">
        <form id="form_kereses" method="POST" action="index.php?pg=search">
            <label for="a_kereses">Kulcsszó:</label><br>
            <input name="a_kereses" type="text" placeholder="kőműves, java programozó, stb..."><br>
            <label for="a_kategoria">Kategória:</label><br>
            <input list="categories" name="a_kategoria" placeholder="IT, könyvelés, stb..."><br>
            <label for="a_hely">Város:</label><br>
            <input list="cities" name="a_hely" placeholder="pl.: Budapest" required><br><br>
            <div class="submitholder"><input name="a_gomb" type="submit" value="Keresés"></div>
            <br>
        </form>
    </div>
    ';
?>

