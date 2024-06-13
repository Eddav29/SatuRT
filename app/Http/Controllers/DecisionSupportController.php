<?php

namespace App\Http\Controllers;

use App\Services\DecisionMakerGenerator\DecisionMakerService;
use App\Services\DecisionMakerGenerator\Support\EddasService;
use App\Services\DecisionMakerGenerator\Support\MabacService;
use App\Services\DecisionMakerGenerator\Support\MooraService;
use App\Services\DecisionMakerGenerator\Support\ArasService;
use App\Services\DecisionMakerGenerator\Support\ElectreService;
use App\Services\DecisionMakerGenerator\Support\SAWService;
use App\Services\DecisionMakerGenerator\Support\SmartService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\JsonResponse;

class DecisionSupportController extends Controller
{
    private $decisionMakerService;
    private $edasService;
    private $mabacService;
    private $mooraService;
    private $electreService;
    private $sawService;
    private $arasService;
    private $smartService;


    public function __construct()
    {
        $this->decisionMakerService = new DecisionMakerService();
        $this->edasService = new EddasService();
        $this->mabacService = new MabacService();
        $this->mooraService = new MooraService();
        $this->arasService = new ArasService();
        $this->sawService = new SAWService();
        $this->electreService = new ElectreService();
        $this->smartService = new SmartService();
    }

    public function index()
    {
        $breadcrumb = [
            'list' => ['Home', 'Prioritas Kegiatan', 'Kegiatan'],
            'url' => ['home', 'spk.index', 'spk.index'],
        ];


        return response()->view('pages.spk.index', [
            'breadcrumb' => $breadcrumb,
            'method' => 'all'
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
                    'list' => ['Home', 'Prioritas Kegiatan', 'Detail', 'EDAS'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];
                try {
                    $eddas = $this->getEdasData();
                    return response()->view('pages.spk.edas.show', [
                        'data' => $eddas,
                        'criterias' => $criterias,
                        'weights' => $weights,
                        'alternatives' => $alternatives,
                        'breadcrumb' => $breadcrumb
                    ]);
                } catch (\Exception $e) {
                    NotificationPusher::error($e->getMessage());
                    return response()->redirectToRoute('spk.index');
                }
            case 'mabac':
                $breadcrumb = [
                    'list' => ['Home', 'Prioritas Kegiatan', 'Detail', 'MABAC'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];
                try {
                    $mabac = $this->getMabacData();
                    return response()->view('pages.spk.mabac.show', [
                        'data' => $mabac,
                        'criterias' => $criterias,
                        'weights' => $weights,
                        'alternatives' => $alternatives,
                        'breadcrumb' => $breadcrumb
                    ]);
                } catch (\Exception $e) {
                    NotificationPusher::error($e->getMessage());
                    return response()->redirectToRoute('spk.index');
                }
            case 'moora':
                $breadcrumb = [
                    'list' => ['Home', 'Prioritas Kegiatan', 'Detail', 'MOORA'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];
                try {
                    $moora = $this->getMooraData();
                    return response()->view('pages.spk.moora.show', [
                        'data' => $this->getMooraData(),
                        'criterias' => $criterias,
                        'weights' => $weights,
                        'alternatives' => $alternatives,
                        'breadcrumb' => $breadcrumb
                    ]);
                } catch (\Exception $e) {
                    NotificationPusher::error($e->getMessage());
                    return response()->redirectToRoute('spk.index');
                }
            case 'aras':
                $breadcrumb = [
                    'list' => ['Home', 'Prioritas Kegiatan', 'Detail', 'ARAS'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];
                try {
                    $aras = $this->getArasData();
                    return response()->view('pages.spk.aras.show', [
                        'data' => $aras,
                        'criterias' => $criterias,
                        'weights' => $weights,
                        'alternatives' => $alternatives,
                        'breadcrumb' => $breadcrumb
                    ]);
                } catch (\Exception $e) {
                    NotificationPusher::error($e->getMessage());
                    return response()->redirectToRoute('spk.index');
                }
            case 'saw':
                $breadcrumb = [
                    'list' => ['Home', 'Prioritas Kegiatan', 'Detail', 'SAW'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];
                try {
                    $saw = $this->getSAWData();
                    return response()->view('pages.spk.saw.show', [
                        'data' => $saw,
                        'criterias' => $criterias,
                        'weights' => $weights,
                        'alternatives' => $alternatives,
                        'breadcrumb' => $breadcrumb
                    ]);
                } catch (\Exception $e) {
                    NotificationPusher::error($e->getMessage());
                    return response()->redirectToRoute('spk.index');
                }

            case 'electre':
                $breadcrumb = [
                    'list' => ['Home', 'Prioritas Kegiatan', 'Detail', 'ELECTRE'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];
                try {
                    $electre = $this->getElectreData();
                    return response()->view('pages.spk.electre.show', [
                        'data' => $electre,
                        'criterias' => $criterias,
                        'weights' => $weights,
                        'alternatives' => $alternatives,
                        'breadcrumb' => $breadcrumb
                    ]);
                } catch (\Exception $e) {
                    NotificationPusher::error($e->getMessage());
                    return response()->redirectToRoute('spk.index');
                }
            case 'smart':
                $breadcrumb = [
                    'list' => ['Home', 'Prioritas Kegiatan', 'Detail', 'SMART'],
                    'url' => ['home', 'spk.index', 'spk.index', 'spk.index', 'spk.index'],
                ];
                try {
                    $smart = $this->getSmartData();
                    return response()->view('pages.spk.smart.show', [
                        'data' => $smart,
                        'criterias' => $criterias,
                        'weights' => $weights,
                        'alternatives' => $alternatives,
                        'breadcrumb' => $breadcrumb
                    ]);
                } catch (\Exception $e) {
                    NotificationPusher::error($e->getMessage());
                    return response()->redirectToRoute('spk.index');
                }
            default:
                # code...
                break;
        }
    }

    // API
    public function ranking(string $metode): JsonResponse
    {
        switch ($metode) {
            case 'edas':
                try {
                    return response()->json(
                        [
                            'status' => 201,
                            'data' => [
                                'ranking' => array_map(function ($item) {
                                    $item['Score'] = $item['AS'];
                                    unset($item['AS']);
                                    return $item;
                                }, $this->getEdasData()['ranking'])
                            ]
                        ]
                    );
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => 500,
                            'timestamp' => now(),
                            'message' => $e->getMessage()
                        ]
                    );
                }

            case 'mabac':
                try {
                    return response()->json(
                        [
                            'status' => 201,
                            'data' => [
                                'ranking' => array_map(function ($item) {
                                    $item['Score'] = $item['S'];
                                    unset($item['S']);
                                    return $item;
                                }, $this->getMabacData()['rankingMatrix'])
                            ]
                        ]
                    );
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => 500,
                            'timestamp' => now(),
                            'message' => $e->getMessage()
                        ]
                    );
                }

            case 'moora':
                try {
                    return response()->json([
                        'status' => 201,
                        'data' => [
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['Yi(Benefit-Cost)'];
                                unset($item['Yi(Benefit-Cost)']);
                                return $item;
                            }, $this->getMooraData()['ranking'])
                        ]
                    ]);
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => 500,
                            'timestamp' => now(),
                            'message' => $e->getMessage()
                        ]
                    );
                }

            case 'aras':
                try {
                    return response()->json([
                        'status' => 201,
                        'data' => [
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['K'];
                                unset($item['K']);
                                return $item;
                            }, $this->getArasData()['utilityRanking'])
                        ]
                    ]);
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => 500,
                            'timestamp' => now(),
                            'message' => $e->getMessage()
                        ]
                    );
                }

            case 'saw':
                try {
                    return response()->json([
                        'status' => 201,
                        'data' => [
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['Nilai Preferensi'];
                                unset($item['Nilai Preferensi']);
                                return $item;
                            }, $this->getSAWData()['ranking'])
                        ]
                    ]);
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => 500,
                            'timestamp' => now(),
                            'message' => $e->getMessage()
                        ]
                    );
                }

            case 'electre':
                try {
                    return response()->json([
                        'status' => 201,
                        'data' => [
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['E'] ?? $item['Total'];
                                if (isset($item['E'])) {
                                    unset($item['E']);
                                } else {
                                    unset($item['Total']);
                                }
                                return $item;
                            }, $this->getElectreData()['ranking'])
                        ]
                    ]);
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => 500,
                            'timestamp' => now(),
                            'message' => $e->getMessage()
                        ]
                    );
                }

            case 'smart':
                try {
                    return response()->json([
                        'status' => 201,
                        'data' => [
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['S'];
                                unset($item['S']);
                                return $item;
                            }, $this->getSmartData()['ranking'])
                        ]
                    ]);
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => 500,
                            'timestamp' => now(),
                            'message' => $e->getMessage()
                        ]
                    );
                }


            case 'all':
                return response()->json([
                    'status' => 201,
                    'data' => [
                        [
                            'metode' => "Evaluation Based on Distance From Average Solution (EDAS)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['AS'];
                                unset($item['AS']);
                                return $item;
                            }, $this->getEdasData()['ranking'])
                        ],
                        [
                            'metode' => "Multi-Attribute Border Approximation Area Comparison (MABAC)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['S'];
                                unset($item['S']);
                                return $item;
                            }, $this->getMabacData()['rankingMatrix'])
                        ],
                        [
                            'metode' => "Multi-Objective Optimization by Ratio Analysis (MOORA)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['Yi(Benefit-Cost)'];
                                unset($item['Yi(Benefit-Cost)']);
                                return $item;
                            }, $this->getMooraData()['ranking'])
                        ],
                        [
                            'metode' => "Additive Ratio Assesment (ARAS)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['K'];
                                unset($item['K']);
                                return $item;
                            }, $this->getArasData()['utilityRanking'])
                        ],
                        [
                            'metode' => "Simple Additive Weighted (SAW)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['Nilai Preferensi'];
                                unset($item['Nilai Preferensi']);
                                return $item;
                            }, $this->getSAWData()['ranking'])
                        ],
                        [
                            'metode' => "ELimination Et Choix TRaduisant la realitE (ELECTRE)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['E'] ?? $item['Total'];
                                if (isset($item['E'])) {
                                    unset($item['E']);
                                } else {
                                    unset($item['Total']);
                                }
                                return $item;
                            }, $this->getElectreData()['ranking'])
                        ],
                        [
                            'metode' => "Simple Multi Attribute Rating Technique (SMART)",
                            'ranking' => array_map(function ($item) {
                                $item['Score'] = $item['S'];
                                unset($item['S']);
                                return $item;
                            }, $this->getSmartData()['ranking'])
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

    private function getArasData(): array
    {
        return $this->arasService->getStepData();
    }

    private function getElectreData(): array
    {
        return $this->electreService->getStepData();
    }

    private function getSAWData(): array
    {
        return $this->sawService->getStepData();
    }

    private function getSmartData(): array
    {
        return $this->smartService->getStepData();
    }
}
