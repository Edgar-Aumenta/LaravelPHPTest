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
    private $transmissionData = [
        'content' => [
            'from' => [
                'name' => 'PCSynergy Team',
                'email' => 'mailserver@notify.postalmate.net',
            ],
            'subject' => 'Mailing via PHP library 2.x',
            'text' => 'Mensaje de prueba enviado correctamente!',
        ],
        'recipients' => [
            [
                'address' => [
                    'name' => 'Edgar Flores',
                    'email' => 'eflores@aumenta.mx',
                ],
            ],
        ],               
    ];



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
        $this->middleware('auth:api')->except(['sendEmailContactUs', 'sendEmailRequestMoreInfo', 'sendSparkPostMail']);
    }

    public function sendEmailFeatureRequest(Request $request)
    {
        $this->validate($request, $this->featureRequestRules);
        // ['karen@pcsynergy.com', 'larrys@pcsynergy.com']
        $receivers = explode(",", env('MAIL_FEATURE_REQUEST'));
        $featureRequest = new FeatureRequest(
            $request['pmSerial'],
            $request['requestedFeature'],
            $request['contactName'],
            $request['contactPhone'],
            $request['contactEmail'],
            $request['storeName']
        );
        Mail::to($receivers)->send(new FeatureRequestReceived($featureRequest));
        return $this->messageResponse("Feature Request sent");
    }

    public function sendEmailContactUs(Request $request)
    {
        $this->validate($request, $this->contatUsRules);
        $receivers = explode(",", env('MAIL_SALES_FLEX'));
        $contactUs = new ContactUs(
            $request['name'],
            $request['email'],
            $request['message']
        );
        Mail::to($receivers)->send(new ContactUsReceived($contactUs));
        return $this->messageResponse("sent");
    }

    public function sendEmailRequestMoreInfo(Request $request)
    {
        $this->validate($request, $this->requestMoreInfoRules);
        $receivers = explode(",", env('MAIL_SALES_CLASSIC'));
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
        Mail::to($receivers)->send(new RequestMoreInfoReceived($contactUs));
        return $this->messageResponse("Request more information sent");
    }

    public function sendSparkPostMail()
    {
        $httpClient = new GuzzleAdapter(new Client());
        $sparky = new SparkPost($httpClient, ['key'=>'74551f5a617261df6f3a9fd12f7278eaac8a6c4c', 'async' => 
        false]);

        try {
            $response = $sparky->transmissions->post($this->transmissionData);
            return $response->getStatusCode()."\n";            
        }
        catch (\Exception $e) {
            echo $e->getCode()."\n";
            echo $e->getMessage()."\n";
        }
    }
}
