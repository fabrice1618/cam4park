<?php 

class DeviceModel extends Model
{
    const LISTE_CHAMPS = [
        'id' => [ 
            'valid' => 'Valid::checkId',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT
        ],
        'name' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
       ],
        'type' => [ 
            'valid' => 'Valid::checkStr',
            'default' => '',
            'pdo_type' => PDO::PARAM_STR
        ],       
        'api_key' => [ 
            'valid' => 'Valid::checkStr',
            'default' => '',
            'pdo_type' => PDO::PARAM_STR
            ]       
        ];    

    const QUERY_FIND = "SELECT * FROM device WHERE api_key = :api_key"; 

    public function __construct( )
    {
        parent::__construct( self::LISTE_CHAMPS );
    }

    // Find API_key
    function find_api_key( $api_key ) 
    {
        if ( $this->validate('api_key', $api_key) ) {
            $stmt = $this->dbh->prepare( self::QUERY_FIND );
            if (
                $stmt !== false &&
                $stmt->bindValue(':api_key', $api_key, PDO::PARAM_INT) &&
                $stmt->execute()
            ) {
                $aRow = $stmt->fetch();   // recuperer un seul enregistrement

                if ($aRow !== false) {
                    $this->id = $aRow['id'];
                    $this->name = $aRow['name'];
                    $this->type = $aRow['type'];
                    $this->api_key = $aRow['api_key']; 
                }
                
            }
        }
    }

}
