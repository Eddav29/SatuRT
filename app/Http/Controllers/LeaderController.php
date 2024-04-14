<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\KartuKeluarga;
use App\Models\Keuangan;
use App\Models\Pelaporan;
use App\Models\Penduduk;
use App\Models\Persuratan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LeaderController extends Controller
{
    public function index(): Response
    {
        $familyCardCount = $this->getTotalFamilyCard();
        $residentCount = $this->getTotalResident();
        $documentRequestCount = $this->getTotalDocumentRequest();
        $balance = $this->getBalanceRT();
        $informations = $this->getListOfAnnouncements();
        $financeReport = $this->getMonthlyFinanceReport();
        $listOfResidentReport = $this->getListOfResidentReports();

        return response()->view('pages.dashboard', [
            'familyCardCount' => $familyCardCount,
            'residentCount' => $residentCount,
            'documentRequestCount' => $documentRequestCount,
            'balance' => $balance,
            'informations' => $informations,
            'financeReport' => $financeReport,
            'listOfResidentReport' => $listOfResidentReport
        ]);
    }

    public function getTotalFamilyCard(): int
    {
        return KartuKeluarga::count();
    }

    public function getTotalResident(): int
    {
        return Penduduk::count();
    }

    public function getTotalDocumentRequest(): int
    {
        return Persuratan::with('pengajuan')->whereHas('pengajuan', function ($query) {
            $query->where('status_id', 1);
        })->count();
    }

    public function getBalanceRT(): int
    {
        $keuangan = Keuangan::orderBy('tanggal', 'desc')->first();

        return $keuangan->total_keuangan;
    }

    public function getListOfAnnouncements(): Collection
    {
        return Informasi::where('jenis_informasi', 'Pengumuman')->get();
    }

    public function getMonthlyFinanceReport(): array
    {
        $results = DB::select("
        SELECT jenis_keuangan, MONTH(created_at) as month, SUM(nominal) as nominal
        FROM detail_keuangan
        WHERE jenis_keuangan IN ('Pemasukan', 'Pengeluaran') AND YEAR(created_at) = YEAR(NOW())
        GROUP BY jenis_keuangan, MONTH(created_at)");

        $monthly = [];

        $range = range(1, 12);

        foreach ($range as $month) {
            $monthly['expenses'][$month] = 0;
            $monthly['incomes'][$month] = 0;

            foreach ($results as $result) {
                if ($result->month == $month) {
                    if ($result->jenis_keuangan == 'Pemasukan') {
                        $monthly['incomes'][$month] = $result->nominal;
                    } elseif ($result->jenis_keuangan == 'Pengeluaran') {
                        $monthly['expenses'][$month] = $result->nominal;
                    }
                }
            }
        }

        return $monthly;
    }

    public function getListOfResidentReports(): Collection
    {
        return Pelaporan::with(['pengajuan', 'pengajuan.penduduk'])->get();
    }
}
