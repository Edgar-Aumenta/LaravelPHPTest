<?php


namespace App\Http\Controllers\Email;
use App\FeatureRequest;
use App\Http\Controllers\ApiController;
use App\Mail\FeatureRequestReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends ApiController
{
    private $reatureRequestRules = [
        'pmSerial' => 'required',
        'requestedFeature' => 'required',
        'contactName' => 'required',
        'contactPhone' => 'required',
        'contactEmail' => 'required',
        'storeName' => 'required'
    ];

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function sendEmailFeatureRequest(Request $request)
    {
        $this->validate($request, $this->reatureRequestRules);
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
}
