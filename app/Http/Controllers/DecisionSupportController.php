<?php

namespace App\Http\Controllers;

use App\Services\DecisionMakerGenerator\DecisionMakerService;
use App\Services\DecisionMakerGenerator\Support\EddasService;
use App\Services\DecisionMakerGenerator\Support\ElectreService;
use App\Services\DecisionMakerGenerator\Support\MabacService;
use App\Services\DecisionMakerGenerator\Support\MooraService;
use App\Services\DecisionMakerGenerator\Support\SAWService;
use Illuminate\Http\JsonResponse;

class DecisionSupportController extends Controller
{
    private $decisionMakerService;
    private $edasService;
    private $mabacService;
    private $mooraService;
    private $sawService;    private $electreService;


    public function __construct()
    {
        $this->decisionMakerService = new DecisionMakerService();
        $this->edasService = new EddasService();
        $this->mabacService = new MabacService();
        $this->mooraService = new MooraService();
        $this->sawService = new SAWService();
        $this->electreService = new ElectreService();
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
            'rankingEdas' => array_map(function ($item) {
                $item['Score'] = $item['AS'];
                unset($item['AS']);
                return $item;
            }, $rankingEdas,),
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
                    'breadcrumb' => $breadcrumb,
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
                    'breadcrumb' => $breadcrumb,
                ]);

            case 'moora':
                $breadcrumb = [
                    'list' => ['Home', 'Pendukung Keputusan', 'Detail', 'MOORA'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];

                return response()->view('pages.spk.moora.show',  [
                    'data'  => $this->getMooraData(),
                    'criterias' => $criterias,
                    'weights' => $weights,
                    'alternatives' => $alternatives,
                    'breadcrumb' => $breadcrumb,
                ]);

            case 'saw':
                $breadcrumb = [
                    'list' => ['Home', 'Pendukung Keputusan', 'Detail', 'SAW'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];

                return response()->view('pages.spk.saw.show', [
                    'data' => $this->getSAWData(),
                    'criterias' => $criterias,
                    'weights' => $weights,
                    'alternatives' => $alternatives,
                    'breadcrumb' => $breadcrumb
                ]);

            case 'electre':
                $breadcrumb = [
                    'list' => ['Home', 'Pendukung Keputusan', 'Detail', 'ELECTRE'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];

                return response()->view('pages.spk.electre.show', [
                    'data' => $this->getElectreData(),
                    'criterias' => $criterias,
                    'weights' => $weights,
                    'alternatives' => $alternatives,
                    'breadcrumb' => $breadcrumb,
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
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['AS'];
                                unset($item['AS']);
                                return $item;
                            }, $this->getEdasData()['ranking']),
                        ],
                    ]
                );

            case 'mabac':
                return response()->json(
                    [
                        'status' => 201,
                        'data' => [
                            'ranking' => $this->getMabacData()['rankingMatrix'],
                        ],
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['S'];
                                unset($item['S']);
                                return $item;
                            }, $this->getMabacData()['rankingMatrix'])
                        ]
                    ]
                );

            case 'moora':
                return response()->json([
                    'status' => 201,
                    'data' => [
                        'ranking' => $this->getMooraData()['ranking'],
                    ],
                        'ranking' => array_map(function ($item) {
                            $item['Score'] = $item['Yi(Benefit-Cost)'];
                            unset($item['Yi(Benefit-Cost)']);
                            return $item;
                        }, $this->getMooraData()['ranking'])
                    ]
                ]);

            case 'saw':
                return response()->json([
                    'status' => 201,
                    'data' => "Sedang dalam pengembangan",
                ]);

            case 'electre':
                return response()->json([
                    'status' => 201,
                    'data' => [
                        'ranking' => array_map(function ($item) {
                            $item['Score'] = $item['E'];
                            unset($item['E']);
                            return $item;
                        }, $this->getElectreData()['ranking'])
                    ]
                ]);


            case 'all':
                return response()->json([
                    'status' => 201,
                    'data' => [
                        [
                            'metode' => "Evaluation Based on Distance From Average Solution (EDAS)",
                            'ranking' => $this->getEdasData()['ranking'],
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['AS'];
                                unset($item['AS']);
                                return $item;
                            }, $this->getEdasData()['ranking'])
                        ],
                        [
                            'metode' => "Multi-Attribute Border Approximation Area Comparison (MABAC)",
                            'ranking' => $this->getMabacData()['rankingMatrix'],
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['S'];
                                unset($item['S']);
                                return $item;
                            }, $this->getMabacData()['rankingMatrix'])
                        ],
                        [
                            'metode' => "Multi-Objective Optimization by Ratio Analysis (MOORA)",
                            'ranking' => $this->getMooraData()['ranking'],
                        ],
                    ],
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['Yi(Benefit-Cost)'];
                                unset($item['Yi(Benefit-Cost)']);
                                return $item;
                            }, $this->getMooraData()['ranking'])
                        ],
                        [
                            'metode' => "ELimination Et Choix TRaduisant la realitE (ELECTRE)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['E'];
                                unset($item['E']);
                                return $item;
                            }, $this->getElectreData()['ranking'])
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

    private function getSAWData(): array
    {
        return $this->sawService->getStepData();
    }

    private function getElectreData(): array
    {
        return $this->electreService->getStepData();
    }
}
