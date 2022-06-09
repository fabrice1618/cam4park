<?php 

class RemainingPlacesController
{
    private $remainingPlaces;
    private $dbh;

    const QUERY_REMAINING = "SELECT remaining FROM place ORDER BY id DESC LIMIT 1";

    public function __construct()
    {
        $this->dbh = Database::connexion();
    }

    public function run()
    {

        $stmt = $this->dbh->prepare( self::QUERY_REMAINING );
        if (
            $stmt !== false &&
            $stmt->execute()
        ) {
            $aRow = $stmt->fetch();   // recuperer un seul enregistrement
            $this->remainingPlaces = $aRow['remaining'];
        }
    }


    public function response()
    {
        $aResponse = ["remaining_places" => $this->remainingPlaces ];
        print( json_encode($aResponse, JSON_PRETTY_PRINT) );
    }
}