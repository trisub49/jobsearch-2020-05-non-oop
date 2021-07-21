<ul class="d-none d-sm-block">
    <a href="index.php?pg=news"><li class="m_style"><i class="icono-textAlignLeft"></i>Friss</li></a>
    <a href="index.php?pg=search"><li class="m_style"><i class="icono-search"></i>Keresés</li></a>
    <a href="index.php?pg=user"><li class="m_style"><i class="icono-user"></i>Profil</li></a>
    <?php
        if(isset($_SESSION['UserType']) && isset($_SESSION['UserID']))
        {
            if($_SESSION['UserType'] == 1) echo '<a href="index.php?pg=lister"><li class="m_style"><i class="icono-document"></i>Jelentkezéseim</li></a>';
            else echo '<a href="index.php?pg=lister"><li class="m_style"><i class="icono-document"></i>Hirdetéseim</li></a>';
        }
    ?>
</ul>
<ul class="d-block d-sm-none mobile">
    <a href="index.php?pg=news"><li class="m_style"><i class="icono-textAlignLeft"></i></li></a>
    <a href="index.php?pg=search"><li class="m_style"><i class="icono-search"></i></li></a>
    <a href="index.php?pg=user"><li class="m_style"><i class="icono-user"></i></li></a>
    <?php
        if(isset($_SESSION['UserType']) && isset($_SESSION['UserID'])) echo '<a href="index.php?pg=lister"><li class="m_style"><i class="icono-document"></i></li></a>';
    ?>
</ul>