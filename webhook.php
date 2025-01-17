<?php
    const TOKEN_CLOUDBAZED = 'CLOUDBAZEDPHPAPIMETA';
    const WEBHOOK_URL = 'http://test.cloudbazed.s3-website.us-east-2.amazonaws.com/webhook.php';

    function verificarToken($req, $res){
        try{
            $token = $req['hub_verify_token'];
            $challenge = $req['hub_challenge'];

            if(isset($challenge) && isset($token) && $token==TOKEN_CLOUDBAZED){
                $res -> send($challenge);
            } else {
                $res -> status(400)->send();
            }
        } catch(Exception $e) {
            $res -> status(400) -> send();

        }
    }

    function recibirMensajes($req, $res){
        try{
            $res -> send("EVENT_RECEIVED");
        } catch(Exception $e) {
            $res -> send("EVENT_RECEIVED");
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        recibirMensajes($data, http_response_code());
    } elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['hub_mode']) && isset($_GET['hub_verify_token']) && isset($_GET['hub_challenge']) && $_GET['hub_mode'] === 'suscribe' && $_GET['hub_verify_token'] === TOKEN_ANDERCODE){
            echo $_GET['hub_challenge'];
        } else {
            http_response_code(403);
        }
    }
?>