<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $token = '527036b8cbc2889aa51c6b28ec8d04cde0fd4ad3fd100dddb5985a405dcfaf6f'; // token de banxico
        $idSerie = 'SF43718';
        
        $response = Http::withHeaders([
            'Bmx-Token' => $token
        ])->get("https://www.banxico.org.mx/SieAPIRest/service/v1/series/{$idSerie}/datos/oportuno");

        $tipoCambio = 'No disponible';
        if($response->successful()){
            $data = $response->json();
            $tipoCambio = $data['bmx']['series'][0]['datos'][0]['dato'];
        }

        return view('home', compact('tipoCambio'));
    }
}