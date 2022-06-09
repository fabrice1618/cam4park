<?php 

class VehicleModel extends Model
{
    const LISTE_CHAMPS = [
        'id' => [ 
            'valid' => 'Valid::checkId',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT
        ],
        'users_id' => [ 
            'valid' => 'Valid::checkId',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT
        ],
        'plate' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
       ],
        'date_added' => [ 
            'valid' => 'Valid::checkDateTime',
            'default' => '',
            'pdo_type' => PDO::PARAM_STR
        ]
    ];    

    const QUERY_FIND = "SELECT * FROM vehicle WHERE plate = :plate"; 

    public function __construct( )
    {
        parent::__construct( self::LISTE_CHAMPS );
    }

    // Find plate
    function find_plate( $plate ) 
    {
        if ( $this->validate('plate', $plate) ) {
            $stmt = $this->dbh->prepare( self::QUERY_FIND );
            if (
                $stmt !== false &&
                $stmt->bindValue(':plate', $plate, PDO::PARAM_STR) &&
                $stmt->execute()
            ) {
                $aRow = $stmt->fetch();   // recuperer un seul enregistrement

                if ($aRow !== false) {
                    $this->id = $aRow['id'];
                    $this->users_id = $aRow['users_id'];
                    $this->plate = $aRow['plate'];
                    $this->date_added = $aRow['date_added']; 
                }

            }
        }
    }

}
