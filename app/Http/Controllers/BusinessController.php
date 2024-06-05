<?php

namespace App\Http\Controllers;

use App\Models\UMKM;
use App\Services\BusinessService;
use App\Services\Interfaces\RepositoryService;
use Illuminate\Http\Response;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Str;

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
        $umkm = UMKM::filter(request(['jenis_umkm', 'status']))->orderBy('updated_at', 'desc')->paginate(5);

        foreach ($umkm as $item) {
            $model = Purify::clean($item->keterangan);
            $cleaned_string = strip_tags(preg_replace('/(<\/p>)/', '$1 ', $model));
            $cleaned_string = preg_replace('/[^\x20-\x7E]/u', ' ', $cleaned_string);
            $item->keterangan = Str::substr($cleaned_string, 0, 300);
        }

        return response()->json([
            'status' => 201,
            'data' => $umkm
        ], 201);
    }

}
