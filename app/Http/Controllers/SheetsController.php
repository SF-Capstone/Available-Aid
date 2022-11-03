<?php

namespace App\Http\Controllers;

use Google_Service_Sheets;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;
use Illuminate\Http\Request;

use Exception;

class SheetsController extends Controller
{
    public function getFilterInfo() {

        $spreadsheetId = Env('SPREADSHEET_ID');
        $client = new Client();
        $client->setAuthConfig(storage_path('app/serviceCredentials.json'));
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);


        $range = 'Filters!A2:Z';

        try {
            $result = $service->spreadsheets_values->get($spreadsheetId, $range);
            return view('welcome', compact('result'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function getShelterLocation(Request $request)
    {
        $shelterRow = $request->input('shelterRow');
        $spreadsheetId = Env('SPREADSHEET_ID');
        $client = new Client();
        $client->setAuthConfig(storage_path('app/serviceCredentials.json'));
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);

        $range = 'Info!A:C';

        try {
            $shelterResultInfo = $service->spreadsheets_values->get($spreadsheetId, $range);
            $headers = $shelterResultInfo[0];
            $info = $shelterResultInfo[$shelterRow];

            foreach ($headers as $key => $value) {
                $result[$value] = $info[$key];
            }
            $result['Row Number'] = $shelterRow;

            return view('mapView', compact('result'));
        } catch (Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' . $e->getMessage();
        }
    }
    
    public function getShelterInfo(Request $request) {
        $activeFilters = array_slice($request->all(), 1);
        
        $spreadsheetId = Env('SPREADSHEET_ID');
        $client = new Client();
        $client->setAuthConfig(storage_path('app/serviceCredentials.json'));
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);

        $infoRange = 'Info!A:Z';

        try{
            $shelterResultInfo = $service->spreadsheets_values->get($spreadsheetId, $infoRange);
            $headers = $shelterResultInfo['values'][0];
            $shelterResult = array_slice($shelterResultInfo['values'], 1);
            $lastFormInput = array();

            $mappedResults = array(); 
            
            foreach($shelterResult as $shelter) {
                $temp = array();
                foreach($shelter as $key => $value) {
                    $temp[$headers[$key]] = $value;
                }
                $mappedResults[] = $temp;
            }
        
            foreach ($mappedResults as $index => $shelter) {

                foreach($activeFilters as $key => $value) {
                    //strip out the underscores in the key
                    $key = str_replace('_', ' ', $key);

                    //if gender is unspecified, then skip it
                    if($key == "Gender" && $value == "Unspecified") {
                        continue;
                    } else {
                        //convert on values to yes
                        if($value == "on") {
                            $value = "Yes";
                        }
                        //check if the shelter has unspecified as a value, skip it if it does
                        if($shelter[$key] == "Unspecified") {
                            continue;
                        }
                        //if the shelter has the filter, and the values do not match, then skip it
                        if(array_key_exists($key, $shelter) && $shelter[$key] != $value) {
                            continue 2;
                        }
                    }
                }

                $result = array();
                $format = 'Beds Available: %d';
                $result['beds'] = sprintf($format, $shelter['Beds']);
                $result['timestamp'] = date('g:ia m/d/Y', strtotime($shelter['Timestamp']));
                $result['shelter'] = $shelter["Shelter Name"];
                #$result['address'] = $shelter["Location"];
                $result['phone'] = $shelter["Contact Info"];
                $result['row'] = $index + 1;


                $lastFormInput[] = $result;
            }

            return view('results', compact('shelterResultInfo' , 'lastFormInput'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function getMoreInfo(Request $request) {
        $shelterRow = $request->input('shelterRow');

        $spreadsheetId = Env('SPREADSHEET_ID');
        $client = new Client();
        $client->setAuthConfig(storage_path('app/serviceCredentials.json'));
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);

        $range = "Info!A:Z";

        try {
            $shelter = $service->spreadsheets_values->get($spreadsheetId, $range)->values;
            $result = array();

            $headers = $shelter[0];
            $info = $shelter[$shelterRow];

            foreach($headers as $key => $value) {
                $result[$value] = $info[$key];
            }
            $result['Row Number'] = $shelterRow;
            
            return view('information', compact('result'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }
}