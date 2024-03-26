<?php

namespace App\Http\Controllers;

use App\Events\TestingEvent;

use Illuminate\Http\Request;

class TeEventController extends Controller
{
    //
    function testingEvents()
    {
     event(new TestingEvent);
    }
}
