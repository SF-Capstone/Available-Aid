<?php

namespace App\Http\Controllers;

use Google_Service_Sheets;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;


class SheetsController extends Controller
{
    public function getFilterInfo() {

        $spreadsheetId = Env('SPREADSHEET_ID');
        $client = new Client();
        $client->setAuthConfig(storage_path('app/serviceCredentials.json'));
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);


        $range = 'Filters!E2:Z100';

        try {
            $result = $service->spreadsheets_values->get($spreadsheetId, $range);
            return view('welcome', compact('result'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function getShelterInfo() {
        $spreadsheetId = Env('SPREADSHEET_ID');
        $client = new Client();
        $client->setAuthConfig(storage_path('app/serviceCredentials.json'));
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);

        $infoRange = 'Info!A2:Z';

        try{
            $shelterResultInfo = $service->spreadsheets_values->get($spreadsheetId, $infoRange);
            $lastFormInput = array();
            foreach ($shelterResultInfo->values as $shelter) {
                $result = array();

                $lastRowHeaderRange = $shelter[0] . '!A1:Z1';
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
                
                $lastRowRange = $shelter[0] . '!A' . $shelter[3] . ':C' . $shelter[3];
                $mostRecent = $service->spreadsheets_values->get($spreadsheetId, $lastRowRange)->values[0];

                $result['beds'] = $mostRecent[$bedIndex];
                $result['timestamp'] = date('g:ia m/d/Y', strtotime($mostRecent[$timestampIndex]));
                $result['shelter'] = $shelter[0];
                $result['address'] = $shelter[1];
                $result['phone'] = $shelter[2];


                $lastFormInput[] = $result;
            }
            return view('results', compact('shelterResultInfo' , 'lastFormInput'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
        
    }
}