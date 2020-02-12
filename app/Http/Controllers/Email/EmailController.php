<?php


namespace App\Http\Controllers\Email;
use App\ContactUs;
use App\FeatureRequest;
use App\Http\Controllers\ApiController;
use App\Mail\ContactUsReceived;
use App\Mail\FeatureRequestReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function __construct()
    {
        $this->middleware('auth:api')->except(['sendEmailRequestMoreInfo']);
    }

    public function sendEmailFeatureRequest(Request $request)
    {
        $this->validate($request, $this->featureRequestRules);
        // ['karen@pcsynergy.com', 'larrys@pcsynergy.com']
        $receivers = explode(",", env('MAIL_TO'));
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

    public function sendEmailRequestMoreInfo(Request $request)
    {
        $this->validate($request, $this->contatUsRules);
        $receivers = explode(",", env('MAIL_TO'));
        $contactUs = new ContactUs(
            $request['name'],
            $request['email'],
            $request['message']
        );
        Mail::to($receivers)->send(new ContactUsReceived($contactUs));
        return $this->messageResponse("sent");
    }
}
