<?php 

class MovementController
{
    private $request;
    private $request_http_authorization;
    private $http_status_code;
    private $authorized = "";
    private $movement;

    const HTTPcode2message = [
        201 => "HTTP/1.1 201 Created",
        418 => "HTTP/1.1 418 I am a teapot",
        422 => "HTTP/1.1 422 Unprocessable entity"
    ];

    public function __construct($aRequest, $sRequestHTTP_authorisation)
    {
        $this->request = $aRequest;
        $this->request_http_authorization = $sRequestHTTP_authorisation;
    }

    public function run()
    {
        $this->authorized = "unauthorized";

        // Controle du parametre "way"
        if ( !in_array($this->request['way'], ["entry", "exit", "undetermined"]) ) {
            $this->http_status_code = 422;
            return;
        }

        // Controle validite de la date
        $movementDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->request['date'], null);
        if ($movementDate == false) {
            printf("Erreur date :\n" );
            $this->http_status_code = 422;
            return;
        }

        // Controle device avec API_KEY
        $oDevice = new DeviceModel();
        $oDevice->find_api_key( $this->request_http_authorization );
        if ($oDevice->id == 0) {
            $this->http_status_code = 418;
            return;
        }

        // Creation du mouvement par defaut
        $this->movement = new MovementModel();
        $this->movement->vehicles_id = 0;
        $this->movement->device_id = $oDevice->id; 
        $this->movement->date = $this->request['date'];
        $this->movement->way = $this->request['way'];

        // Recherche du vehicule avec plaque immatriculation
        $oVehicle = new VehicleModel();
        $oVehicle->find_plate( $this->request['plate'] );
        if ($oVehicle->id == 0) {
            $this->http_status_code = 201;
            $this->movement->create();
            return;
        }

        // Controle de la date du vehicule
        $vehicleDate = DateTime::createFromFormat("Y-m-d H:i:s", $oVehicle->date_added, null);
        if ($vehicleDate > $movementDate) {
            $this->http_status_code = 201;
            $this->movement->create();
            return;
        }

        // MAJ du mouvement avec id du vehicule
        $this->movement->vehicles_id = $oVehicle->id;

        // Recherche de l'utilisateur proprietaire du vehicule
        $oUser = new UserModel();
        $oUser->find_id( $oVehicle->users_id );
        if ($oUser->id == 0) {
            $this->http_status_code = 201;
            $this->movement->create();
            return;
        }

        // Verification de la date de l'utilisateur
        $userDate = DateTime::createFromFormat("Y-m-d H:i:s", $oUser->creation, null);
        if ($userDate > $movementDate) {
            $this->http_status_code = 201;
            $this->movement->create();
            return;
        }
        
        // Controle du role de l'utilisateur
        $aRoles = json_decode($oUser->roles, true);
        if (in_array("ROLE_USER", $aRoles)) {
            $this->authorized = "authorized";
            $this->http_status_code = 201;
            $this->movement->create();
        }

    }

    public function response()
    {
        $aResponse = ['authorized'=> $this->authorized];

        header(self::HTTPcode2message[$this->http_status_code], true, $this->http_status_code);
        print( json_encode($aResponse, JSON_PRETTY_PRINT) );
    }
    
}