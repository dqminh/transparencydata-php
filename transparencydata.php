<?php
require_once('contribution_client.php');
require_once('lobbying_client.php');

class TransparencyData {
    private $apiKey;
    private $contributionClient;
    private $lobbyingClient;

    function __construct($apiKey = null) {
        $this->apiKey = $apiKey;
        $this->contributionClient = new ContributionClient($apiKey);
        $this->lobbyingClient = new LobbyingClient($apiKey);
    }

    function __call($method, $args) {
        // manipulating $args to return sensible array
        // since PHP auto add index [0] to our array
        $params = array();
        switch ($method) {
        case 'contributions':
            return $this->contributionClient->request($args[0]);
        case 'lobbying':
            return $this->lobbyingClient->request($args[0]);
        }
    }
}

?>
