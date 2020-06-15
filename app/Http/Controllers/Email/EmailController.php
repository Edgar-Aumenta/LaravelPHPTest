<?php

namespace App\Http\Controllers\Email;
use App\ContactUs;
use App\FeatureRequest;
use App\Http\Controllers\ApiController;
use App\Mail\ContactUsReceived;
use App\Mail\FeatureRequestReceived;
use App\Mail\RequestMoreInfoReceived;
use App\RequestMoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class EmailController extends ApiController
{   

    private $featureRequestRules = [
        'pmSerial' => 'required',
        'requestedFeature' => 'required',
        'contactName' => 'required',
        'contactPhone' => 'required',
        'contactEmail' => 'required',
        'storeName' => 'required'
    ];

    private $contatUsRules = [
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ];

    private $requestMoreInfoRules = [
        'name' => 'required',
        'email' => 'required|email',
        'phoneNumber' => 'required',
    ];


    public function __construct()
    {
        $this->middleware('auth:api')->except(['sendEmailContactUs', 'sendEmailRequestMoreInfo']);
    }

    public function sendEmailFeatureRequest(Request $request)
    {
        $this->validate($request, $this->featureRequestRules);
        $httpClient = new GuzzleAdapter(new Client());        
        $sparky = new SparkPost($httpClient, ["key" => env('SPARKPOST_API_KEY')]);        
        
        $featureRequest = new FeatureRequest(
            $request['pmSerial'],
            $request['requestedFeature'],
            $request['contactName'],
            $request['contactPhone'],
            $request['contactEmail'],
            $request['storeName']
        );

        $promise = $sparky->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'PC Synergy Website',
                    'email' => 'mailserver@notify.postalmate.net',
                ],
                'subject' => 'Feature Request Received',
                'html' => '<html><body><h2>Postalmate Feature Request</h2><p>Name: {{contactName}} <br> Phone Number: {{contactPhone}} <br/> E-mail Address: {{contactEmail}} <br/> Postalmate Serial Number : {{pmSerial}} <br/> Store Name: {{storeName}} <br/> Requested Feature: {{requestedFeature}}</p></body></html>',
                'text' => 'Postalmate Feature Request. Name: {{contactName}}, Phone Number: {{contactPhone}}, E-mail Address: {{contactEmail}}, Postalmate Serial Number : {{pmSerial}}, Store Name: {{storeName}}, Requested Feature: {{requestedFeature}}',
            ],
            'substitution_data' => ['pmSerial' => $featureRequest->pmSerial, 'requestedFeature' => $featureRequest->requestedFeature, 'contactName' => $featureRequest->contactName, 'contactPhone' => $featureRequest->contactPhone, 'contactEmail' => $featureRequest->contactEmail, 'storeName' => $featureRequest->storeName],
            'recipients' => [
                [
                    'address' => [
                        'name' => 'Flex Sales',
                        'email' => env('MAIL_FEATURE_REQUEST'),
                    ],
                ],
            ],            
        ]);

        try {
            $response = $promise->wait();
            return $this->messageResponse("Feature Request sent");            
        }
        catch (\Exception $e) {
            echo $e->getCode()."\n";
            echo $e->getMessage()."\n";
        }        
    }

    public function sendEmailContactUs(Request $request)
    {
        $this->validate($request, $this->contatUsRules);
        $httpClient = new GuzzleAdapter(new Client());        
        $sparky = new SparkPost($httpClient, ["key" => env('SPARKPOST_API_KEY')]);
        
        $contactUs = new ContactUs(
            $request['name'],
            $request['email'],
            $request['message'],
            $request['city'],
            $request['state'],
            $request['phoneNumber']
        );
        
        $promise = $sparky->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'PC Synergy Website',
                    'email' => 'mailserver@notify.postalmate.net',
                ],
                'subject' => 'Contact Us Received',
                'html' => '<html><body><h2>Postalmate Contact Us</h2><p>Name: {{name}} <br> E-mail Address: {{contactEmail}} <br/> Phone Number: {{phoneNumber}} </br> City: {{city}} </br> State/Country: {{state}} </br> Message : {{message}}</p></body></html>',
                'text' => 'Postalmate Contact Us. Name: {{name}}, E-mail Address: {{contactEmail}}, Phone Number: {{phoneNumber}}, City: {{city}}, State/Country: {{state}}, Message: {{message}}',
            ],
            'substitution_data' => ['name' => $contactUs->name, 'contactEmail' => $contactUs->email, 'phoneNumber' => $contactUs->phoneNumber, 'city' => $contactUs->city, 'state' => $contactUs->state, 'message' => $contactUs->message],
            'recipients' => [
                [
                    'address' => [
                        'name' => 'Flex Sales',
                        'email' => env('MAIL_SALES_FLEX'),
                    ],
                ],
            ],            
        ]);

        try {
            $response = $promise->wait();
            return $this->messageResponse("Contact us mail sent");            
        }
        catch (\Exception $e) {
            echo $e->getCode()."\n";
            echo $e->getMessage()."\n";
        }        
    }

    public function sendEmailRequestMoreInfo(Request $request)
    {
        $this->validate($request, $this->requestMoreInfoRules);        
        $httpClient = new GuzzleAdapter(new Client());        
        $sparky = new SparkPost($httpClient, ["key" => env('SPARKPOST_API_KEY')]);

        $contactUs = new RequestMoreInfo(
            $request['name'],
            $request['email'],
            $request['phoneNumber'],
            $request['storeName'],
            $request['address'],
            $request['city'],
            $request['state'],
            $request['zipCode'],
            $request['currentSoftware'],
            $request['requestPMTrial'],
            $request['storeStatus'],
            $request['comments']
        );

        $promise = $sparky->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'PC Synergy Website',
                    'email' => 'mailserver@notify.postalmate.net',
                ],
                'subject' => 'Request More Information Received',
                'html' => '<html><body><h2>Postalmate Request More Information</h2><p>Name: {{name}} <br> E-mail Address: {{contactEmail}} <br/> Phone Number : {{phoneNumber}}<br/> Store Name: {{storeName}}</br> Address: {{contactAddress}}<br/> City: {{city}}<br/> State: {{state}}<br> Zip Code: {{zipCode}}<br/> Current Software: {{currentSoftware}}<br/> Request PM Trial: {{requestPMTrial}}<br/> Store Status: {{storeStatus}}<br/> Comments: {{comments}}</p></body></html>',
                'text' => 'Postalmate Request More Information. Name: {{name}}, E-mail Address: {{contactEmail}}, Phone Number : {{phoneNumber}}, Store Name: {{storeName}}, Address: {{contactAddress}}, City: {{city}}, State: {{state}}, Zip Code: {{zipCode}}, Current Software: {{currentSoftware}}, Request PM Trial: {{requestPMTrial}}, Store Status: {{storeStatus}}, Comments: {{comments}}.',
            ],
            'substitution_data' => ['name' => $contactUs->name, 'contactEmail' => $contactUs->email, 'phoneNumber' => $contactUs->phoneNumber, 'storeName' => $contactUs->storeName, 'contactAddress' => $contactUs->address, 'city' => $contactUs->city, 'state' => $contactUs->state, 'zipCode' => $contactUs->zipCode, 'currentSoftware' => $contactUs->currentSoftware, 'requestPMTrial' => $contactUs->requestPMTrial, 'storeStatus' => $contactUs->storeStatus, 'comments' => $contactUs->comments],
            'recipients' => [
                [
                    'address' => [
                        'name' => 'Flex Sales',
                        'email' => env('MAIL_SALES_CLASSIC'),
                    ],
                ],
            ],            
        ]);

        try {
            $response = $promise->wait();
            return $this->messageResponse("Request more information sent");            
        }
        catch (\Exception $e) {
            echo $e->getCode()."\n";
            echo $e->getMessage()."\n";
        }        
    }    
}
