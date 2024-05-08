<?php

namespace App\Http\Controllers;

use App\Models\UMKM;
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

        return response()->view('pages.landing-page.usaha.index', [
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

    public function paginate()
    {
        $umkm = UMKM::filter(request(['jenis_umkm', 'status']))->paginate(5);

        return response()->json([
            'status' => 201,
            'data' => $umkm
        ], 201);
    }

}
