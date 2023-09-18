<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Laporan_pendapatan;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardsController extends Controller
{
    public function index(){  
        // Ambil bulan dan tahun saat ini
        $harisekarang = now()->format('d');
        $bulanSekarang = now()->format('m');
        $tahunSekarang = now()->format('Y');

        $categoryData = Product::select('category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        $category = Product::all();

        $categoryData1 = Pendapatan::select('category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();
            
            $totalquantity = Pendapatan::select('category')
            ->selectRaw('SUM(total_quantity) as count')
            ->whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->take(3) // Memuat hanya 3 data teratas
            ->pluck('count', 'category')
            ->toArray();
        

        //<!--awal::target-->

        // Ambil data pendapatan untuk bulan ini
        $tujuanBulanIni = Laporan_pendapatan::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get();

        $pendapatanBulanIni = Pendapatan::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get();

        $pendapatanhariIni = Pendapatan::WhereDate('created_at',  now()->toDateString())
        ->sum('total_price');

        $pengeluaranhariini = Pengeluaran::WhereDate('created_at',  now()->toDateString())
        ->sum('price');
            
        $quantityBulanIni = Pendapatan::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get();

        $pengeluaranBulanIni = Pengeluaran::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get();

        $targetP = Laporan_pendapatan::select('tujuan_penghasilan')->whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get();

        // Hitung total quantity dan total price untuk data bulan ini
        $penghasilantahun = pendapatan::sum('total_price');
        $stockterjual = $pendapatanBulanIni->sum('total_quantity');
        $stockterjualkategori = $quantityBulanIni->sum('total_quantity');
        $penjualanTerjual = $pendapatanBulanIni->sum('total_price');
        $targetPenjualan = $targetP->sum('tujuan_penghasilan');
        $pengeluaranT = $pengeluaranBulanIni->sum('price');
        $pendaparanbersihhariini = $pendapatanhariIni - $pengeluaranhariini;

        // Pastikan $targetPenjualan tidak null dan bukan nol sebelum melakukan pembagian
        if (!is_null($targetPenjualan) && $targetPenjualan != 0) {
            $persentaseTerjual = ($penjualanTerjual / $targetPenjualan) * 100;
        } else {
            $persentaseTerjual = 0; // Atur ke 0 jika $targetPenjualan adalah null atau nol untuk menghindari pembagian oleh nol.
        }
        //<!--akhir::target-->

        //----------------

        $dailyExpenses = [];
        $pendapatanBersih = [];
        $persentase = [];
        $currentMonth = now()->startOfMonth();
        
        // Menghitung jumlah hari dalam bulan saat ini
        $daysInMonth = $currentMonth->daysInMonth;
        
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $startDate = $currentMonth->copy()->addDays($i - 1);
            $endDate = $currentMonth->copy()->addDays($i);
        
            $dailyExpenses[] = Pengeluaran::whereBetween('created_at', [$startDate, $endDate])
                ->sum('price');
        }

        //----------------
        
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $startDate = $currentMonth->copy()->addDays($i - 1);
            $endDate = $currentMonth->copy()->addDays($i);
        
            $weeklyExpensesPenghasilan[] = Pendapatan::whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_price');
        }

        for ($i = 0; $i < count($weeklyExpensesPenghasilan); $i++) {
            $startDate = $currentMonth->copy()->addDays($i);
            $endDate = $currentMonth->copy()->addDays($i + 1);
            
            $weeklyIncomeForDate = $weeklyExpensesPenghasilan[$i];
            $dailyExpenseForDate = $dailyExpenses[$i];
            
            $pendapatanBersih[] = $weeklyIncomeForDate - $dailyExpenseForDate;
        }


        $year = now()->format('Y'); // Menggunakan tahun saat ini
        $monthlyExpensesPenghasilan = [];
        $monthlyExpensesPengeluaran = [];
        $monthlyExpensesbersih = [];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            
            $monthlyExpensesPenghasilan[] = Pendapatan::whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_price');
        }

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            
            $monthlyExpensesPengeluaran[] = Pengeluaran::whereBetween('created_at', [$startDate, $endDate])
                ->sum('price');
        }

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
            // Menggunakan $month - 1 sebagai indeks untuk mengakses data pada bulan tersebut
            $pendapatanB = $monthlyExpensesPenghasilan[$month - 1];
            $pengeluaranB = $monthlyExpensesPengeluaran[$month - 1];
        
            $monthlyExpensesbersih[] = $pendapatanB - $pengeluaranB;
        }
    

        
        return view('dashboard', compact('persentaseTerjual','penghasilantahun','monthlyExpensesbersih','monthlyExpensesPenghasilan','pendaparanbersihhariini', 'pendapatanBersih','penjualanTerjual', 'dailyExpenses','pengeluaranT','weeklyExpensesPenghasilan','stockterjual','categoryData1','category','stockterjualkategori','totalquantity','targetPenjualan'), [
            "title" => "Dashboard",
            'categoryData' => $categoryData,
    ]);
}
}
