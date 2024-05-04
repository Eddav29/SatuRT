<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $data = Kriteria::all()->map(function ($kriteria) {
                return [
                    'kriteria_id' => $kriteria->kriteria_id,
                    'nama_kriteria' => $kriteria->nama_kriteria,
                    'jenis_kriteria' => $kriteria->jenis_kriteria,
                    'bobot' => $kriteria->bobot
                ];
            });

            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function index()
    {
        $kriteria = Kriteria::all();
        $breadcrumb = [
            'list' => ['Home', 'SPK', 'Kriteria'],
            'url' => ['home', 'spk.kriteria.index', 'spk.kriteria.index'],
        ];
        return response()->view('pages.kriteria.index', [
            'breadcrumb' => $breadcrumb
        ]);
    }
}
