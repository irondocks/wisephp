<?php declare(strict_types = 1);
namespace Adoms\src\lib;

require_once __DIR__ . '../../../../vendor/autoload.php';


class Version
{
    public function about($vbool)
    {
        if ($vbool == 0) {
            echo 'Adoms::Helium v4.1.3<br>';
            echo 'Adoms Object Oriented Framework / Wireframe Model-View-Controller / Pipes Routing';
        } elseif ($vbool == 1) {
            echo 'Adoms::Helium v4.1.3';
        } else {
            for ($i = 0 ; $i < $vbool ; $i++) {
                echo 'Was \$vbool too complex an idea for you? ... ';
            }
        }
    }
}
