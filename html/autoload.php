<?php
// autoloader des classes
// Remarquer que l'autoloader utilise une fonction anomyme
// voir documentation https://www.php.net/manual/en/language.oop5.autoload.php

spl_autoload_register( function ($sClassname) {
    global $sBasepath;

//    echo "Autoload class: " . $sClassname . PHP_EOL;

    if (!isset($sBasepath)) {
        throw new \Exception("Autoload: global \$sBasepath not defined", 1);
    }

    // Liste des dossiers où sont stockées les classes
    $aDirectoryList = [ 'class', 'model', 'controller' ];

    $lLoaded = false;
    foreach ($aDirectoryList as $sDirectory) {
        $sFile = $sBasepath. $sDirectory.'/'.$sClassname.'.php';

        if ( !$lLoaded && file_exists($sFile) ) {
            // Class file found
            $lLoaded = true;
            require_once($sFile);
            break;
        }
    }
    if (! $lLoaded) {
        throw new \Exception("Autoload: Unable to load class " . $sClassname, 1);
    }
} 
);