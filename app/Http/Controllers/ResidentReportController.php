<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResidentReportResource;
use App\Models\Pelaporan;
use App\Models\Pengajuan;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ResidentReportController extends Controller
{
    public function getResidentReport(string $id): ResidentReportResource
    {
        $residentReport = Pelaporan::with(['pengajuan', 'pengajuan.penduduk', 'pengajuan.status', 'pengajuan.acceptedBy'])->find($id);

        if (!$residentReport) {
            throw new HttpResponseException(response()->json([
                'message' => 'Data not found',
            ])->setStatusCode(404));
        }

        return new ResidentReportResource($residentReport);
    }
}
