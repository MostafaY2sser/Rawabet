<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function list(){
        $providers = Provider::paginate(1);
        return view("site.providers.list",compact("providers"));
    }
     
public function show(Provider $provider){

    // $provider = Provider::findOrFail($id);
    return view('site.providers.details', compact('provider'));
}
}
