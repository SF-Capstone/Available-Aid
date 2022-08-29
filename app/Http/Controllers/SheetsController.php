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
        $result = $service->spreadsheets_values->get($spreadsheetId, $range);
        
        try{
            $numRows = $result->getValues() != null ? count($result->getValues()) : 0;
            
            return response()->json($result);
        }

        catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }
}