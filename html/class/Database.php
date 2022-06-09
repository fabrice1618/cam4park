<?php

class Database
{
    private static $instance = null;     // Singleton
    private static $dbh = null;     // Database connexion 
    private $configuration = array();
    
    private function __construct()
    {
        try {
            $oConfig = new ConfigJson('config.json');
            if (
                ! empty($oConfig->get('MYSQL_HOST')) &&
                ! empty($oConfig->get('MYSQL_DATABASE')) &&
                ! empty($oConfig->get('MYSQL_USER')) &&
                ! empty($oConfig->get('MYSQL_PASSWORD')) 
                ) {
                    $this->configuration = $oConfig->getConfiguration();
                }
        } catch (Exception $e)  {
                $oConfig = new ConfigJson('');
                $oConfig->set('MYSQL_HOST', '');
                $oConfig->set('MYSQL_DATABASE', '');
                $oConfig->set('MYSQL_USER', '');
                $oConfig->set('MYSQL_PASSWORD', '');
                throw new Exception("Erreur config.json non configuré.", 1);
        }
            
        $this->openDatabase();
    }
        
    public static function connexion()
    {
            
        if (is_null(self::$instance)) {
            self::$instance = new Database();  
        }
            
        return( self::$dbh );
    }
        
    private function openDatabase()
    {
        $sPDOConnectString = sprintf( "mysql:host=%s;dbname=%s;charset=utf8",
            $this->configuration['MYSQL_HOST'],
            $this->configuration['MYSQL_DATABASE'],
            );
        
        self::$dbh = new PDO(
            $sPDOConnectString, 
            $this->configuration['MYSQL_USER'], 
            $this->configuration['MYSQL_PASSWORD']
        );
        self::$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    
    public function __destruct() 
    {
        self::$dbh = null;
    }
    
}
