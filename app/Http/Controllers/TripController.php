<?php

namespace App\Http\Controllers;

use App\Models\driver;
use App\Models\Driver as ModelsDriver;
use App\Models\trip;
use App\Models\vehicle;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function SearchTrip(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from_place' => 'required',
            'to_place' => 'required',
            'from_date' => 'required',
            'return_date' => 'required',
            // 'people_adult' => 'required',
            // 'people_child' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' =>$validator->errors()
            ],430);
        }
        else{
            $trip = new trip;
            $trip->from_place = $request->from_place;
            $trip->to_place = $request->to_place;
            $trip->from_date = $request->from_date;
            $trip->return_date = $request->return_date;

            $response = $this->getLatLngByCity($request->from_place,$request->to_place);
            $responseData = json_decode($response->getContent(), true);

            $trip->from_lat = isset($responseData['latitude']) ? $responseData['latitude'] : null;
            $trip->from_lng = isset($responseData['longitude']) ? $responseData['longitude'] : null;

            $trip->to_lat = isset($responseData['latitude1']) ? $responseData['latitude1'] : null;
            $trip->to_lng = isset($responseData['longitude1']) ? $responseData['longitude1'] : null;

            // dd($trip->from_lat,$trip->from_lng,$trip->to_lat,$trip->to_lng);        ( " OKY " )

            $vehicle = vehicle::where('id', $request->id)->first();
            // $driver = ModelsDriver::where('id', $request->id)->first();

            // $driver = driver::where('id', 2)->first();
            // return($driver);
            if($vehicle){
                return($vehicle);
                $vendors = $vehicle->user->getSelfDriverProfile;
                if($vendors){
                    dd($vendors);
                }
            }
            else{
                echo "vehicle not found";
            }

        }
    }
    public function getLatLngByCity($from_place,$to_place)
    {
        // Replace 'YOUR_GOOGLE_API_KEY' with your actual Google API key
        $apiKey = 'AIzaSyDRnWPFPLvEgKnTwxWOJDAIH8Yyek00cmM';

        $client = new Client();

        $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
            'query' => [
                'address' => $from_place . ', United States',
                'key' => $apiKey,
            ],

        ]);
        $response1 = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
            'query' => [
                'address' => $to_place . ', United States',
                'key' => $apiKey,
            ],

        ]);


        $data = json_decode($response->getBody(), true);
        $data1 = json_decode($response1->getBody(), true);
        

        if ($data['status'] === 'OK' && isset($data['results'][0]['geometry']['location']) && $data1['status'] === 'OK' && isset($data1['results'][0]['geometry']['location'])) {
            $location = $data['results'][0]['geometry']['location'];
            $location1 = $data1['results'][0]['geometry']['location'];

            
            $latitude = $location['lat'];
            $longitude = $location['lng'];

            $latitude1 = $location1['lat'];
            $longitude1 = $location1['lng'];

            return response()->json(['latitude' => $latitude, 'longitude' => $longitude,'latitude1' => $latitude1, 'longitude1' => $longitude1]);
        } else {
            // Handle error if necessary
            return response()->json(['error' => 'Failed to fetch location details'], 500);
        }
    }
}
