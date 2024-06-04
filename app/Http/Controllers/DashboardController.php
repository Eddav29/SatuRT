<?php

namespace App\Http\Controllers;

use App\Models\DetailKeuangan;
use App\Models\Informasi;
use App\Models\KartuKeluarga;
use App\Models\Keuangan;
use App\Models\Pelaporan;
use App\Models\Penduduk;
use App\Models\Persuratan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $balance = $this->getBalanceRT();
            $fiveYearsAgo = [];

            for ($i = 0; $i < 5; $i++) {
                $fiveYearsAgo[] = date('Y') - $i;
            }

            if (Auth::user()->role->role_name === 'Ketua RT') {
                $residentCount = $this->getTotalResident();
                $familyCardCount = $this->getTotalFamilyCard();
                $informations = $this->getListOfAnnouncements();
                $documentRequestCount = $this->getTotalDocumentRequest();
                $listOfResidentReport = $this->getListOfResidentReports();

                return response()->view('pages.dashboard', [
                    'fiveYearsAgo' => $fiveYearsAgo,
                    'familyCardCount' => $familyCardCount,
                    'residentCount' => $residentCount,
                    'documentRequestCount' => $documentRequestCount,
                    'balance' => $balance,
                    'informations' => $informations,
                    'listOfResidentReport' => $listOfResidentReport
                ]);
            } else {
                $familyMemberCount = $this->getTotalFamilyMembers(Auth::user()->penduduk->kartu_keluarga_id);
                $incomeThisMonth = $this->getIncomeInThisMonth();
                $expenseThisMonth = $this->getExpenseInThisMonth();
                $detailFinance = $this->getFinanceTranpanceReport();
                $informations = $this->getAllInformation();

                return response()->view('pages.warga.dashboard.index', [
                    'fiveYearsAgo' => $fiveYearsAgo,
                    'familyMemberCount' => $familyMemberCount,
                    'incomeThisMonth' => $incomeThisMonth,
                    'expenseThisMonth' => $expenseThisMonth,
                    'balance' => $balance,
                    'detailFinance' => $detailFinance,
                    'informations' => $informations
                ]);
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }

    private function getTotalFamilyCard(): int
    {
        try {
            return KartuKeluarga::count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getTotalResident(): int
    {
        try {
            return Penduduk::count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getTotalDocumentRequest(): int
    {
        try {
            return Persuratan::whereHas('pengajuan', function ($query) {
                $query->where('status_id', 1);
            })->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getBalanceRT(): int
    {
        try {
            return Keuangan::orderBy('keuangan_id', 'DESC')->first()->total_keuangan;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getListOfAnnouncements(): Collection
    {
        try {
            return Informasi::where('jenis_informasi', 'Pengumuman')->orWhere('jenis_informasi', 'Dokumentasi Rapat')->orderBy('updated_at', 'desc')->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    private function getListOfResidentReports(): Collection
    {
        try {
            return Pelaporan::join('pengajuan', 'pelaporan.pengajuan_id', '=', 'pengajuan.pengajuan_id')
                ->with(['pengajuan', 'pengajuan.penduduk'])
                ->whereDate('pengajuan.updated_at', Carbon::today())
                ->orderBy('pengajuan.updated_at', 'desc')
                ->where('pengajuan.status_id', 1)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    private function getTotalFamilyMembers(string $kk_number): int
    {
        try {
            $count = Penduduk::where('kartu_keluarga_id', $kk_number)->count();

            return $count;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getIncomeInThisMonth(): int
    {
        try {
            $income = DetailKeuangan::where('jenis_keuangan', 'Pemasukan')
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->sum('nominal');

            return $income;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getExpenseInThisMonth(): int
    {
        try {
            $expense = DetailKeuangan::where('jenis_keuangan', 'Pengeluaran')
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->sum('nominal');
            return $expense;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getFinanceTranpanceReport(): Collection
    {
        try {
            $detail = DetailKeuangan::whereYear('updated_at', date('Y'))->get();

            return $detail;
        } catch (\Exception $e) {
            return collect();
        }
    }

    private function getAllInformation(): Collection
    {
        try {
            $informations = Informasi::with(['penduduk'])
                ->where('jenis_informasi', 'Pengumuman')
                ->orWhere('jenis_informasi', 'Dokumentasi Rapat')
                ->whereMonth('updated_at', '>=', (date('m') - 1))->get();

            $reports = Pelaporan::with(['pengajuan', 'pengajuan.penduduk', 'pengajuan.status'])->where('jenis_pelaporan', 'Pengaduan')->whereHas('pengajuan.status', function ($query) {
                $query->where('nama', 'Diterima');
            })->get();

            $informations = $informations->merge($reports);

            $informations = $informations->sortByDesc(function ($information) {
                if ($information instanceof Pelaporan) {
                    return $information->pengajuan->updated_at;
                } else {
                    return $information->updated_at;
                }
            });

            return $informations;
        } catch (\Exception $e) {
            return collect();
        }
    }
}
