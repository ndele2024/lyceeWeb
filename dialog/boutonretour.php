<?php
function boutonretour()
{
    $li=func_get_arg(0); //arg 1er lien du bouton
    $langue=func_get_arg(1); //arg 2eme langue
    
    if ($langue=="F")
    {
        $im1="Retour";
    }
    else
    {
        $im1="Back";
    }
    $bouton="<a href='$li' class='boutonRetour'>$im1</a>";
    return $bouton;
}
