<?php
function __autoload($class_name) { 
    include_once($class_name . ".php"); 
} 

class Authentication
{
    public $accountId;
    public $apiName;
    public $securityWord;
    
    function __construct($accountId, $apiName, $securityWord)
    {
        $this->accountId    = $accountId;
        $this->apiName      = $apiName;
        $this->securityWord = $securityWord;
    } 
    
    public function createAuthToken()
    {
        $datePart = gmdate("Ymd");
        $timePart = gmdate("H");
        
        $authString = $this->securityWord . ":" . $datePart . ":" . $timePart;
        $sha256     = bin2hex(mhash(MHASH_SHA256, $authString));
        return strtoupper($sha256);
    }
}

interface IApiService
{
    function balance($currency);
    function accountName($accountToRetrieve);   
}

class ApiAgentFactory
{
   const XML = "xml";
   const NVP = "nvp";
   const JSON = "json";
   const SOAP = "soap";
    
   public function createApiAgent($type, Authentication $auth)
   {
        switch($type)
        {
           case "xml": 
              return new XmlApiAgent($auth); break;
           case "nvp":
              return new NvpApiAgent($auth); break;
           case "json": 
              return new JsonApiAgent($auth); break;       
           case "soap": 
              return new SoapApiAgent($auth); break;          
           default: 
              die("Error"); 
              break;
        }     
   }
}


class HistoryItem
{
    public $Batch;
    public $Date; 
    public $Amount; 
    public $Fee; 
    public $Balance; 
    public $Currency; 
    public $Payer; 
    public $PayerName; 
    public $Payee;
    public $PayeeName;
    public $Memo;
    public $Private;
    public $Reference;
    public $Source;
}



