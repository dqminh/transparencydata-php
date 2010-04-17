<?php
require_once('lib/simpletest/autorun.php');
require_once('../transparencydata.php');

class TransparencyDataTest extends UnitTestCase {
    private $apiKey = '08b06096eb214e0d94c08b74cf6c3acf';
    private $email = 'dqminh89@gmail.com';

    public function testQueryExactContributorAmount() {
        $query = array('amount' => 100);
        $td = new TransparencyData($this->apiKey);
        $result = $td->contributions($query);
        var_dump($result);
    }
}

?>
