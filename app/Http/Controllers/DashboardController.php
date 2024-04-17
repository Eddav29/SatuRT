<?php

namespace App\Http\Controllers;

use App\Models\DetailKeuangan;
use App\Models\Informasi;
use App\Models\KartuKeluarga;
use App\Models\Keuangan;
use App\Models\Pelaporan;
use App\Models\Penduduk;
use App\Models\Persuratan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $balance = $this->getBalanceRT();
        $financeReport = $this->getMonthlyFinanceReport();

        if (Auth::user()->role->role_name === 'Ketua RT') {
            $residentCount = $this->getTotalResident();
            $familyCardCount = $this->getTotalFamilyCard();
            $informations = $this->getListOfAnnouncements();
            $documentRequestCount = $this->getTotalDocumentRequest();
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
        } else {
            $familyMemberCount = $this->getTotalFamilyMembers();
            $incomeThisMonth = $this->getIncomeInThisMonth();
            $expenseThisMonth = $this->getExpenseInThisMonth();
            $detailFinance = $this->getFinanceTranpanceReport();
            $informations = $this->getAllInformation();

            return response()->view('pages.warga.dashboard.index', [
                'familyMemberCount' => $familyMemberCount,
                'financeReportMonthly' => $financeReport,
                'incomeThisMonth' => $incomeThisMonth,
                'expenseThisMonth' => $expenseThisMonth,
                'balance' => $balance,
                'detailFinance' => $detailFinance,
                'informations' => $informations
            ]);
        }
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

    public function getTotalFamilyMembers(string $kk_number = '762ff3c6-2dcf-4735-a45a-64c8860abaf7'): int
    {
        $count = Penduduk::where('kartu_keluarga_id', $kk_number)->count();

        return $count;
    }

    public function getIncomeInThisMonth(): int
    {
        $income = DetailKeuangan::where('jenis_keuangan', 'Pemasukan')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->sum('nominal');
        return $income;
    }

    public function getExpenseInThisMonth(): int
    {
        $expense = DetailKeuangan::where('jenis_keuangan', 'Pengeluaran')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->sum('nominal');
        return $expense;
    }

    public function getFinanceTranpanceReport(): Collection
    {
        $detail = DetailKeuangan::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->get();

        return $detail;
    }

    public function getAllInformation(): Collection
    {
        return Informasi::with(['penduduk'])->where('jenis_informasi', 'Pengumuman')->get();
    }
}
