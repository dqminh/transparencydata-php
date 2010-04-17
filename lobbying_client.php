<?php
require_once('transparencydata_client.php');
class LobbyingClient extends TransparencyDataClient {
    private $endpoint = 'lobbying.json';
    private $parameters = array(
        'amount', 'client_ft', 'client_parent_ft', 'filling_type',
        'lobbyist_ft', 'registrant_ft', 'transaction_id', 'transaction_type',
        'year'
    );

    public function getEndpoint() {
        return $this->endpoint;
    }

    public function getParameters() {
        return $this->parameters;
    }
}

?>
