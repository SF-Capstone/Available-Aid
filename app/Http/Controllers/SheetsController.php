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
                $lastRowRange = $shelter[0] . '!A' . $shelter[3] . ':C' . $shelter[3];
                $mostRecent = $service->spreadsheets_values->get($spreadsheetId, $lastRowRange);
                $lastFormInput[] = $mostRecent->values;
            }
            return view('results', compact('shelterResultInfo' , 'lastFormInput'));
        } catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
        
    }
}