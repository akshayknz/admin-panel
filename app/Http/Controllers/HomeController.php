<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomeService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeService $homeService)
    {
        $this->middleware('auth');
        $this->homeService = $homeService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function booking(Request $request){
        $data = $this->homeService->getBooking($request->all());

        return $data;
    }

    public function client(Request $request){
        $data = $this->homeService->getClient($request->all());

        return $data;
    }

    public function city(Request $request){
        $data = $this->homeService->getCity($request->all());

        return $data;
    }

    public function state(Request $request){
        $data = $this->homeService->getState($request->all());

        return $data;
    }

    public function age(Request $request){
        $data = $this->homeService->getAge($request->all());

        return $data;
    }

    public function revenue(Request $request){
        $data = $this->homeService->getRevenue($request->all());

        return $data;
    }

    public function tthdata(Request $request){
        $data = $this->homeService->getTthdata($request->all());

        return $data;
    }

    public function cook(Request $request){
        $data = $this->homeService->getCook($request->all());

        return $data;
    }

    public function leader(Request $request){
        $data = $this->homeService->getLeader($request->all());

        return $data;
    }

    public function salesteam(Request $request){
        $data = $this->homeService->getSalesteam($request->all());

        return $data;
    }

    public function test(Request $request){
        $data = $this->homeService->getTest($request->all());

        return $data;
    }
}

/**
 * "files": [
 *      "app/helpers.php"
 *   ],
 * 
 * change revenue from booking to trekkers list
 * 
 * amount type float
 * PaymentId type float
 * 
 */