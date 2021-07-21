<?php
{
    $result = dbquery("SELECT *, hirdetesek.ID AS hID FROM hirdetesek INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID ORDER BY fel_datum DESC",$connectionx);
    if(mysqli_num_rows($result) == 0)
    {
        echo
        '
        <h4><b>Hiba!</b></h4>
        <hr>
        <div class="c_content">
            <span class="err_msg">Jelenleg még nincsenek álláshírdetések!</span><br><br>
        </div>
        ';
    }
    else
    {
        echo '<h4><b>Legújabb álláshirdetések</b></h4><hr>';
        $news;
        while($news = mysqli_fetch_assoc($result))
        {
            $category_id = $news['kategoria'];
            $result2 = dbquery("SELECT kategoria_nev FROM kategoriak WHERE ID='$category_id'",$connectionx);
            $category_name = mysqli_fetch_assoc($result2);
            echo
            '
            <a class="job_link" href="index.php?pg=showjob&id='.$news['hID'].'">
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
    }
}
