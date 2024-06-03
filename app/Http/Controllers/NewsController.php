<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Services\Interfaces\RepositoryService;
use App\Services\NewsService;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    private Informasi $latestInformation;
    private RepositoryService $crudNewsService;
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->crudNewsService = app('news_service');
        $this->newsService = $newsService;
        $this->latestInformation = $this->newsService->getLatestNews();
    }

    public function index(): Response
    {
        $types = $this->newsService->getAllTypes();

        return response()->view(
            'pages.landing-page.berita.index',
            [
                'newInformation' => $this->latestInformation,
                'types' => $types,
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

    public function paginate()
    {
        $informasi = Informasi::where('jenis_informasi', '!=', 'Pengumuman')
            ->where('jenis_informasi', '!=', 'Dokumentasi Rapat')
            ->where('informasi_id', '!=', $this->latestInformation->informasi_id)
            ->filter(request(['search', 'jfsi']))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 201,
            'data' => $informasi
        ], 201);
    }
}
