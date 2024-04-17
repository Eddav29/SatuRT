<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AlternativeController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $data = Alternatif::all()->map(function ($alternatif) {
                return [
                    'alternatif_id' => $alternatif->alternatif_id,
                    'nama_alternatif' => $alternatif->nama_alternatif,
                    'created_at' => Carbon::parse($alternatif->created_at)->format('d-m-Y'),
                    'updated_at' => Carbon::parse($alternatif->updated_at)->format('d-m-Y'),
                ];
            });

            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function index(){
        $alternatif = Alternatif::all();
        $breadcrumb = [
            'list' => ['Home', 'SPK'],
            'url' => ['home', 'spk.index'],
        ];
        return response()->view('pages.alternatif.index', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function create(){
        $alternatif = Alternatif::all();

        $breadcrumb = [
            'list' => ['Home', 'SPK', 'Tambah Kegiatan'],
            'url' => ['home', 'spk.index','spk.create'],
        ];
        return response()->view('pages.alternatif.create', [
            'breadcrumb' => $breadcrumb, 'alternatif'=>$alternatif
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'nama_alternatif'=>'required|string|max:255'
        ]);

        Alternatif::create([
            'nama_alternatif'=> $request->nama_alternatif
        ]);
    }

    public function edit(string $id): Response
    {
        $alternatif = Alternatif::find($id);
        $breadcrumb = [
            'list' => ['Home', 'SPK', 'Edit Data UMKM'],
            'url' => ['home', 'spk.index', ['spk.edit',  $id]],
        ];
        $alternatif = Alternatif::find($id);

        return response()->view('pages.alternatif.edit', [
            'breadcrumb' => $breadcrumb, 'alternatif' => $alternatif
        ]);
    }

    public function update(Request $request, String $id){
        $alternatif = Alternatif::find($id);
        $validated = $request->validate([
            'alternatif_id' => ['required', 'exists:alternatif,alternatif_id'],
            'nama_alternatif' => ['required', 'string', 'min:3', 'max:255'],

        ]);
    }

    public function show(string $id){
        $alternatif = Alternatif::find($id);

        $breadcrumb = [
            'list' => ['Home', 'SPK', 'Detail Kegiatan'],
            'url' => ['home', 'spk.index',['spk.show', $id]],
        ];
        return response()->view('pages.alternatif.show', [
            'breadcrumb' => $breadcrumb,'alternatif'=>$alternatif
        ]);
    }
}
