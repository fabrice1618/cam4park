<?php 

class MovementModel extends Model
{
    const LISTE_CHAMPS = [
        'id' => [ 
            'valid' => 'Valid::alwaysTrue',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT
        ],
        'vehicles_id' => [ 
            'valid' => 'Valid::alwaysTrue',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT
        ],
        'device_id' => [ 
            'valid' => 'Valid::alwaysTrue',
            'default' => "",
            'pdo_type' => PDO::PARAM_INT
       ],
        'date' => [ 
            'valid' => 'Valid::checkDateTime',
            'default' => '',
            'pdo_type' => PDO::PARAM_STR
        ],
        'way' => [ 
            'valid' => 'Valid::checkStr',
            'default' => '',
            'pdo_type' => PDO::PARAM_STR
        ]
    ];    

    const QUERY_CREATE = "INSERT INTO movement(vehicles_id, device_id, date, way) VALUES (:vehicles_id, :device_id, :date, :way)"; 

    public function __construct( )
    {
        parent::__construct( self::LISTE_CHAMPS );
    }

    // Create - creation nouveau mouvement
    public function create() 
    {
        $nId = 0;

        $stmt = $this->dbh->prepare( self::QUERY_CREATE );
        if (
            $stmt !== false &&
            $stmt->bindValue(':vehicles_id', $this->vehicles_id, PDO::PARAM_INT) &&
            $stmt->bindValue(':device_id', $this->device_id, PDO::PARAM_INT) &&
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR) &&
            $stmt->bindValue(':way', $this->way, PDO::PARAM_STR) &&
            $stmt->execute()
        ) {
            $nId = intVal( $this->dbh->lastInsertId() );            
        }

        return( $nId );
    }

}
