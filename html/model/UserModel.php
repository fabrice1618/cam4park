<?php 

class UserModel extends Model
{
    const LISTE_CHAMPS = [
        'id' => [ 
            'valid' => 'Valid::checkId',
            'default' => 0,
            'pdo_type' => PDO::PARAM_INT
        ],
        'email' => [ 
            'valid' => 'Valid::checkEmail',
            'default' => '',
            'pdo_type' => PDO::PARAM_STR
        ],
        'roles' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
       ],
        'password' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'firstname' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'lastname' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'slug' => [ 
            'valid' => 'Valid::checkStr',
            'default' => "",
            'pdo_type' => PDO::PARAM_STR
        ],
        'creation' => [ 
            'valid' => 'Valid::checkDateTime',
            'default' => '',
            'pdo_type' => PDO::PARAM_STR
        ]
    ];    

    const QUERY_FIND = "SELECT * FROM user WHERE id = :id"; 

    public function __construct( )
    {
        parent::__construct( self::LISTE_CHAMPS );
    }

    // Find user id
    function find_id( $nId ) 
    {
        if ( $this->validate('id', $nId) ) {
            $stmt = $this->dbh->prepare( self::QUERY_FIND );
            if (
                $stmt !== false &&
                $stmt->bindValue(':id', $nId, PDO::PARAM_INT) &&
                $stmt->execute()
            ) {
                $aRow = $stmt->fetch();   // recuperer un seul enregistrement

                if ($aRow !== false) {
                    $this->id = $aRow['id'];
                    $this->email = $aRow['email'];
                    $this->roles = $aRow['roles'];
                    $this->password = $aRow['password']; 
                    $this->firstname = $aRow['firstname'];
                    $this->lastname = $aRow['lastname'];
                    $this->slug = $aRow['slug'];
                    $this->creation = $aRow['creation']; 
                }
            }
        }
    }

}

