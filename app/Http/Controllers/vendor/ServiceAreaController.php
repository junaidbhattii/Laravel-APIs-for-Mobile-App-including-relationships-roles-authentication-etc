<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\servicearea;
use App\Models\vendorInfo;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class ServiceAreaController extends Controller
{
    public function ServiceArea(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cityName' => 'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ],430);
        }
        else{
            $vendor = vendorInfo::where('id', $request->id)->first();
            if(!$vendor)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'vendor not found'
                ],404);
            }
            else{
                $serviceArea = new servicearea;
                $serviceArea->user_id = $vendor->user_id;
                $serviceArea->cityName = $request->cityName;
                $response = $this->getLatLngByCity($request->cityName);
                $responseData = json_decode($response->getContent(), true);

                $serviceArea->latitude = isset($responseData['latitude']) ? $responseData['latitude'] : null;
                $serviceArea->longitude = isset($responseData['longitude']) ? $responseData['longitude'] : null;
                $serviceArea->is_update = true;

                if($serviceArea->save())
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'Service areas added successfully',
                        'record' => $this->getResponseData($serviceArea)

                    ],200);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Service areas not added, something went wrong'
                    ],430);
                }

            }
        }
    }
    public function getLatLngByCity($cityName)
    {
        // Replace 'YOUR_GOOGLE_API_KEY' with your actual Google API key
        $apiKey = 'AIzaSyDRnWPFPLvEgKnTwxWOJDAIH8Yyek00cmM';

        $client = new Client();

        $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
            'query' => [
                'address' => $cityName . ', United States',
                'key' => $apiKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['status'] === 'OK' && isset($data['results'][0]['geometry']['location'])) {
            $location = $data['results'][0]['geometry']['location'];

            $latitude = $location['lat'];
            $longitude = $location['lng'];

            return response()->json(['latitude' => $latitude, 'longitude' => $longitude]);
        } else {
            // Handle error if necessary
            return response()->json(['error' => 'Failed to fetch location details'], 500);
        }
    }
    public function getResponseData($serviceArea)
    {
        $json = [
            'cityName' => $serviceArea->cityName,
            'latitude' => $serviceArea->latitude,
            'longitude' => $serviceArea->longitude
        ];
        return $json;
    }
}

