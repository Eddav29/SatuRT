<?php

namespace App\Http\Controllers;

use App\Services\BusinessService;
use App\Services\Interfaces\RepositoryService;
use Illuminate\Http\Response;

class BusinessController extends Controller
{
    private RepositoryService $crudBusinessService;
    private BusinessService $businessService;

    public function __construct(BusinessService $businessService)
    {
        $this->crudBusinessService = app('business_service');
        $this->businessService = $businessService;
    }

    public function index(): Response
    {
        $statuses = $this->businessService->getAllStatuses();
        $types = $this->businessService->getAllTypes();
        $businesses = $this->businessService->getBusinessesWithPagination(request(['jenis_umkm', 'status']));
        return response()->view('pages.landing-page.usaha.index', [
            'businesses' => $businesses,
            'statuses' => $statuses,
            'types' => $types
        ]);
    }

    public function show(string $id): Response
    {
        $business = $this->crudBusinessService->find($id);
        return response()->view('pages.landing-page.usaha.show', [
            'business' => $business
        ]);
    }
}
