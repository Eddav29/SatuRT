<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinanceReportResource;
use App\Models\DetailKeuangan;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    public function financeReport(string $id): FinanceReportResource
    {
        $financeReport = DetailKeuangan::with(['keuangan'])->find($id);

        if (!$financeReport) {
            throw new HttpResponseException(response()->json([
                'message' => 'Data not found',
            ])->setStatusCode(404));
        }

        return new FinanceReportResource($financeReport);
    }
}
