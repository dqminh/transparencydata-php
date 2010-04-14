<?php

class ContributionClient {
    private $endpoint = 'contributions.json';
    private $parameters = array(
        'amount', 'contributor_ft', 'contributor_state', 'cycle',
        'date', 'employer_ft', 'recipient_ft', 'recipient_state',
        'seat', 'transaction_namespace', 'contributor_industry'
    );

    public function getEndpoint() {
        return $this->endpoint;
    }

    public function getParameters() {
        return $this->parameters;
    }
}

?>
