<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MainController extends Controller {
    
    public function main() {
        return view('landing');
    }

}