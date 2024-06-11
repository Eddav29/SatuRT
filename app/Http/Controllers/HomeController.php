<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    private HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(): Response
    {
        $informations = $this->homeService->getFourLastInformation();
        $businesses = $this->homeService->getThreeLastUMKM();
        $leader = $this->homeService->getLeader();

        return response()->view('pages.landing-page.home.index', [
            'informations' => $informations,
            'businesses' => $businesses,
            'leader' => $leader
        ]);
    }
}
