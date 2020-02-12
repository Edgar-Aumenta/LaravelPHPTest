<?php

namespace App\Http\Controllers\CRMTicket;

use App\CRMAuth;
use App\Http\Controllers\ApiController;
use App\XMLHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SoapClient;
use SoapFault;
use SoapHeader;

class CRMTicketController extends ApiController
{
    private $webTicketRules = [
        'pmSerial' => 'required',
        'issue' => 'required',
        'issueTypeId' => 'required',
        'contactName' => 'required',
        'contactPhone' => 'required',
        'contactEmail' => 'required'
    ];

    public function __construct()
    {
        $this->middleware('auth:api');
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
            return $this->errorResponse($e->getMessage(), 503, $e->getMessage());
        }
        return response()->json(XMLHelpers::namespacedXMLToArray($result->GetTypeIncidentsResult), 200);
    }

    public function newWebTicket(Request $request)
    {
        $this->validate($request, $this->webTicketRules);

        $myClient = $this->CRMSoapClient();
        $TechKey = 'Joe';
        $password ='';
        $authTicket         = new CRMAuth($TechKey, $password);
        $headerTicket    = new SoapHeader("http://www.pcsynergy.com/", "Auth", $authTicket, false);

        $myClient->__setSoapHeaders($headerTicket);

        try
        {
            $result = $myClient->__soapCall("NewWebTicket", array(
                "NewWebTicket" => array(
                    "PMSerial"      => $request['pmSerial'],
                    "Issue"         => $request['issue'],
                    "IssueTypeID"   => $request['issueTypeId'],
                    "ContactName"   => $request['contactName'],
                    "ContactPhone"  => $request['contactPhone'],
                    "ContactEmail"  => $request['contactEmail']
                )
            ), NULL, $headerTicket);

        }
        catch (SoapFault $e) {
            return $this->errorResponse($e->getMessage(), 503, $e->getMessage());
        }
        return response()->json($result, 200);
    }

    public function newFeatureRequest(Request $request)
    {
        // ['karen@pcsynergy.com', 'larrys@pcsynergy.com']
        Mail::to('omaralejandrocy@gmail.com')->send();
    }
}
