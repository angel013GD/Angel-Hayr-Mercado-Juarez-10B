<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;
class ConfigurationController extends Controller
{
    //OK
    public function index()
    {

        $registros = Configuration::first();

        return response()->json($registros,200);
    }
}
