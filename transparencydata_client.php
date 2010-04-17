<?php
/**
 * Base Transparency Data Client
 * @author: dqminh
 */
abstract class TransparencyDataClient {
    private $apiKey;
    private $apiUrl = 'http://transparencydata.com/api/1.0/';
    private $defaultParams = array('apikey','page','per_page');

    abstract protected function getEndpoint();
    abstract protected function getParameters();

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function request($args) {
        if (!isset ($args) || empty($args)) {
            throw new TransparencyDataException('undefined arguments');
        }
        $args['apikey'] = $this->apiKey;
        $query = array();
        foreach ($args as $key => $value) {
            $param = "";
            list($name, $operator) = 
                (strpos($key, '__')) ? explode('__', $key) : array($key, null);
            if (!in_array($name, $this->getParameters()) 
                && !in_array($name, $this->defaultParams)) 
            {
                throw new TransparencyDataException($name.' is not a valid 
                    parameters');
            }

            $param .= $key;
            switch ($operator) {
            case 'in':
                if (isset($value) && !empty($value)) {
                    $this->addOperatorIn($param, $value);
                } else {
                    $operator = null;
                }
                break;
            case 'gt':
                $this->addOperatorGreaterThan($param, $value);
                break;
            case 'lt':
                $this->addOperatorSmallerThan($param, $value);
                break;
            case 'between':
                $this->addOperatorBetween($param, $value);
                break;
            default:
                $param.='='.$value;
                break;
            }
            $query[] = $param;
        }

        //query transparencydata's server
        $url = $this->apiUrl.$this->getEndpoint().'?'.urlencode(implode('&',$query));
        return $this->performQuery($url);
    }

    /*
     * perform a GET query to server and retrieve JSON response
     */
    private function performQuery($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response,true);
    }

    private function addOperatorIn(&$query, $value) {
        $vals = implode("|",$value);
        $query .= $vals;
    }

    private function addOperatorGreaterThan(&$query, $value) {
        $query .= ">|".$value;
    }

    private function addOperatorSmallerThan(&$query, $value) {
        $query .= "<|".$value;
    }

    private function addOperatorBetween(&$query, $value) {
        $query .= "><|".$value[0]."|".$value[1];
    }
}

class TransparencyDataException extends Exception { }
?>
