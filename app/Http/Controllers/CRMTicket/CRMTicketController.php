<?php

namespace App\Http\Controllers\CRMTicket;

use App\CRMAuth;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\XMLHelpers;
use Illuminate\Http\Request;
use SoapClient;
use SoapFault;
use SoapHeader;

class CRMTicketController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function sendSupportTicket()
    {
        /*
         <s:element name="NewWebTicket">
            <s:complexType>
                <s:sequence>
                    <s:element minOccurs="0" maxOccurs="1" name="PMSerial" type="s:string"/>
                    <s:element minOccurs="0" maxOccurs="1" name="Issue" type="s:string"/>
                    <s:element minOccurs="0" maxOccurs="1" name="IssueTypeID" type="s:string"/>
                    <s:element minOccurs="0" maxOccurs="1" name="ContactName" type="s:string"/>
                    <s:element minOccurs="0" maxOccurs="1" name="ContactPhone" type="s:string"/>
                    <s:element minOccurs="0" maxOccurs="1" name="ContactEmail" type="s:string"/>
                </s:sequence>
            </s:complexType>
        </s:element>
         * */
    }

    public function getIssues()
    {
        $TechKey = 'Joe';
        $password ='';
        $myClient = $this->CRMSoapClient();
        if($myClient == null) {
            return $this->errorResponse("Site support data unavailable", 503,
                "Site support data unavailable postalmate, Check with your administrator.");
        }
        $auth = new CRMAuth($TechKey, $password);
        $header = new SoapHeader("http://www.pcsynergy.com/","Auth", $auth, false);
        $myClient->__setSoapHeaders($header);
        try
        {
            $result = $myClient->__soapCall("GetTypeIncidents", array(
                "GetTypeIncidents" => array(
                    "PMSerial"        => '12345'
                )
            ), NULL,$header);
        }
        catch (SoapFault $e) {
            echo $this->errorResponse($e->getMessage(), 503, $e->getMessage());
        }
        return response(XMLHelpers::namespacedXMLToArray($result->GetTypeIncidentsResult), 200);
    }

    private function CRMSoapClient()
    {
        $url = env('CRM_URL');
        try {
            $arrContextOptions = array("ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT));
            $options = array(
                'soap_version'=>SOAP_1_2,
                'exceptions'=>true,
                'trace'=>1,
                'cache_wsdl'=>WSDL_CACHE_NONE,
                'stream_context' => stream_context_create($arrContextOptions)
            );
            return new SoapClient($url, $options);
        } catch (SoapFault $e) {
            return null;
        }
    }
}
