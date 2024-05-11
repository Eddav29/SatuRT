<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Services\DecisionMakerGenerator\DecisionMakerService;
use App\Services\DecisionMakerGenerator\Support\EddasService;
use App\Services\DecisionMakerGenerator\Support\MabacService;
use App\Services\DecisionMakerGenerator\Support\MooraService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Nette\Utils\Arrays;

class DecisionSupportController extends Controller
{
    private $decisionMakerService;
    private $edasService;
    private $mabacService;
    private $mooraService;


    public function __construct()
    {
        $this->decisionMakerService = new DecisionMakerService();
        $this->edasService = new EddasService();
        $this->mabacService = new MabacService();
        $this->mooraService = new MooraService();
    }

    public function index()
    {
        $rankingEdas = $this->getEdasData()['ranking'];

        $breadcrumb = [
            'list' => ['Home', 'SPK', 'Kegiatan'],
            'url' => ['home', 'spk.index', 'spk.index'],
        ];

        return response()->view('pages.spk.index', [
            'breadcrumb' => $breadcrumb,
            'rankingEdas' => $rankingEdas
        ]);
    }

    public function show(string $metode)
    {
        $alternatives = $this->decisionMakerService->getAlternatifs();
        $criterias = $this->decisionMakerService->getKriteria();
        $weights = $this->decisionMakerService->getBobot();

        switch ($metode) {
            case 'edas':

                $breadcrumb = [
                    'list' => ['Home', 'Pendukung Keputusan', 'Detail', 'EDAS'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];

                return response()->view('pages.spk.edas.show', [
                    'data' => $this->getEdasData(),
                    'criterias' => $criterias,
                    'weights' => $weights,
                    'alternatives' => $alternatives,
                    'breadcrumb' => $breadcrumb
                ]);
            case 'mabac':

                $breadcrumb = [
                    'list' => ['Home', 'Pendukung Keputusan', 'Detail', 'MABAC'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];

                return response()->view('pages.spk.mabac.show', [
                    'data' => $this->getMabacData(),
                    'criterias' => $criterias,
                    'weights' => $weights,
                    'alternatives' => $alternatives,
                    'breadcrumb' => $breadcrumb
                ]);

            case 'moora':
                $breadcrumb = [
                    'list' => ['Home', 'Pendukung Keputusan', 'Detail', 'MOORA'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];

                return response()->view('pages.spk.moora.show',[
                    'data'=> $this->getMooraData(),
                    'criterias' => $criterias,
                    'weights' => $weights,
                    'alternatives' => $alternatives,
                    'breadcrumb' => $breadcrumb
                ]);
            default:
                # code...
                break;
        }
    }

    // API
    public function ranking(string $metode): JsonResponse
    {
        $alternatives = $this->decisionMakerService->getAlternatifs();
        switch ($metode) {
            case 'edas':
                return response()->json(
                    [
                        'status' => 201,
                        'data' => [
                            'ranking' => $this->getEdasData()['ranking']
                        ]
                    ]
                );

            case 'mabac':
                return response()->json(
                    [
                        'status' => 201,
                        'data' => [
                            'ranking' => $this->getMabacData()['rankingMatrix']
                        ]
                    ]
                );

            case 'moora':
                return response()->json([
                    'status' => 201,
                    'data' => [
                        'ranking' => $this->getMooraData()['ranking']
                    ]
                ]);

            case 'metode4':
                return response()->json([
                    'status' => 201,
                    'data' => "Sedang dalam pengembangan"
                ]);

            case 'metode5':
                return response()->json([
                    'status' => 201,
                    'data' => "Sedang dalam pengembangan"
                ]);

            case 'all':
                return response()->json([
                    'status' => 201,
                    'data' => [
                        [
                            'metode' => "Evaluation Based on Distance From Average Solution (EDAS)",
                            'ranking' => $this->getEdasData()['ranking']
                        ],
                        [
                            'metode' => "Multi-Attribute Border Approximation Area Comparison (MABAC)",
                            'ranking' => $this->getMabacData()['rankingMatrix']
                        ],
                        [
                            'metode' => "Multi-Objective Optimization by Ratio Analysis (MOORA)",
                            'ranking' => $this->getMooraData()['ranking']
                        ]
                    ]
                ]);
            default:
                abort(404, "Page not found");
        }
    }

    private function getMabacData(): array
    {
        return $this->mabacService->getData();
    }

    private function getEdasData(): array
    {
        return $this->edasService->getStepData();
    }

    private function getMooraData(): array
    {
        return $this->mooraService->getStepData();
    }
}
