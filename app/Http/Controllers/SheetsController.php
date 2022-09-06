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


        $range = 'Filters!A2:Z100';

        try {
            $result = $service->spreadsheets_values->get($spreadsheetId, $range);
            return view('welcome', compact('result'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function getShelterLocation()
    {
        $spreadsheetId = Env('SPREADSHEET_ID');
        $client = new Client();
        $client->setAuthConfig(storage_path('app/serviceCredentials.json'));
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);


        $range = 'Info!A2:C';

        try {
            $locations = $service->spreadsheets_values->get($spreadsheetId, $range);
            return view('mapView', compact('locations'));
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
        
            foreach ($mappedResults as $shelter) {

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

                $lastRowHeaderRange = $shelter["Shelter Name"] . '!A1:Z1';
                $lastRowHeader = $service->spreadsheets_values->get($spreadsheetId, $lastRowHeaderRange)->values[0];

                //loop through all of the headers and get the index of the row that contains the word bed case insensitive
                $bedIndex = 0;
                foreach ($lastRowHeader as $header) {
                    if (stripos($header, 'bed') !== false) {
                        $bedIndex = array_search($header, $lastRowHeader);
                    }
                }

                //loop through all of the headers and get the index of the row that contains the word timestamp case insensitive
                $timestampIndex = 0;
                foreach ($lastRowHeader as $header) {
                    if (stripos($header, 'timestamp') !== false) {
                        $timestampIndex = array_search($header, $lastRowHeader);
                    }
                }
                
                $lastRowRange = $shelter["Shelter Name"] . '!A' . $shelter["Most Recent entry row"] . ':C' . $shelter["Most Recent entry row"];
                $mostRecent = $service->spreadsheets_values->get($spreadsheetId, $lastRowRange)->values[0];

                $result['beds'] = $mostRecent[$bedIndex];
                $result['timestamp'] = date('g:ia m/d/Y', strtotime($mostRecent[$timestampIndex]));
                $result['shelter'] = $shelter["Shelter Name"];
                $result['address'] = $shelter["Location"];
                $result['phone'] = $shelter["Contact Info"];


                $lastFormInput[] = $result;
            }

            return view('results', compact('shelterResultInfo' , 'lastFormInput'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
        
    }
}