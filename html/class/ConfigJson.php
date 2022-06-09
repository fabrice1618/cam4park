<?php 
//define( 'CONFIG_FILE', 'config.json' );

class ConfigJson
{
    private $configuration = array();

    private $filename;

    private const CONFIG_FILE = 'config.json';

    public function __construct( $sFileName ) 
    {        
        if ( ! file_exists( $sFileName ) ) {
            throw new Exception("Erreur {$sFileName} fichier n'existe pas.", 1);
        }       
        $this->filename = $sFileName;
        $this->configuration = $this->readJSONFile();
    }

    public function __destruct() 
    {
        $this->writeJSONFile();
    }

    public function getConfiguration()
    {
        return( $this->configuration );
    }

    function get($sParam)
    {
        if ( ! isset($this->configuration[$sParam]) ) {
            throw new Exception("Erreur {$this->filename} paramètre {$sParam} non défini.", 1);
        }

        return( $this->configuration[$sParam] );
    }

    function set($sParam, $value)
    {
        $this->configuration[$sParam] = $value;
    }
    
    private function writeJSONFile()
    {
        file_put_contents( $this->filename, json_encode($this->configuration, JSON_PRETTY_PRINT) );
    }

    private function readJSONFile()
    {

        $aContent = json_decode( file_get_contents($this->filename), true );

        if ( is_null($aContent) ) {
            throw new Exception("Erreur {$this->filename} données incorrectes.", 1);
        }    

        return($aContent);
    }

}





