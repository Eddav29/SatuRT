<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Services\CRUDService;
use App\Services\NewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    private CRUDService $crudNewsService;
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->crudNewsService = app('news_service');
        $this->newsService = $newsService;
    }

    public function index(): Response
    {
        $newInformation = $this->newsService->getLatestNews();
        $informations = $this->newsService->getNewsWithPagination($newInformation->informasi_id ?? null, request(['search', 'jfsi'])) ?? null;
        $types = $this->newsService->getAllTypes();

        return response()->view(
            'pages.landing-page.berita.index',
            [
                'informations' => $informations,
                'newInformation' => $newInformation,
                'types' => $types
            ]
        );
    }

    public function show(string $id): Response
    {
        $information = $this->crudNewsService->find($id);
        $otherInformations = $this->newsService->getRandomNews();
        return response()->view('pages.landing-page.berita.show', [
            'information' => $information,
            'otherInformations' => $otherInformations
        ]);
    }
}
