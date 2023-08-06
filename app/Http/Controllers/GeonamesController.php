<?php

// app/Http/Controllers/GeonamesController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeonamesController extends Controller
{
    private $geonamesBaseUrl = 'http://api.geonames.org/';

    public function getCountries()
    {
        $response = Http::get($this->geonamesBaseUrl . 'countryInfo', [
            'username' => 'dean854',
        ]);

        return $response->json();
    }

    public function getCitiesByCountry($countryCode)
    {
        $response = Http::get($this->geonamesBaseUrl . 'search', [
            'country' => $countryCode,
            'featureClass' => 'P',
            'username' => 'dean854',
        ]);

        return $response->json();
    }
}
