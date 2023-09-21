<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\Product;
use App\Models\Target_pendapatan;
use App\Models\Manage;
use App\Models\Ingredients_category;
use App\Models\Ingredients_category_sale;

class PageController extends Controller
{
    //----Pembelian bahan
    public function pengeluaran(){
        $transaksi = Pengeluaran::orderBy('created_at', 'desc')->get();
        $dataKategori = Ingredients_category::pluck('category');
        return view('pages.pembelian-bahan',compact('transaksi','dataKategori'),[
            "title" => "Pengeluaran"
        ]);
    }

    //POST
    public function pengeluaranT(Request $request){
        // Validasi data jika diperlukan
        $request->validate([
            'category' => 'required',
            'requirement' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);
    
        // Mendapatkan tanggal dari input form
        $data = [
            'category' => $request->category,
            'requirement' => $request->requirement,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ];
    

        Pengeluaran::Create($data);
    
        // Redirect atau lakukan tindakan lain sesuai kebutuhan
        return redirect()->route('PengeluaranB')->with('success', 'Data berhasil disimpan.');
    }
    //----Pembelian bahan

    //----Penjualan
    public function penjualanM()
        {   $dataKategori = Ingredients_category_sale::pluck('category');
            $categories = Product::select('category')->distinct()->pluck('category');
    
            $itemsByCategory = [];
            foreach ($categories as $category) {
                $itemsByCategory[$category] = Product::where('category', $category)->get();
            }
    
            return view('pages.penjualan', compact('dataKategori'),['categories' => $itemsByCategory, "title" => "Penjualan"]);
        }

    public function saveChanges(Request $request){
        if ($request->isMethod('post') && $request->has('changes')) {
            $changes = $request->input('changes');

                // Update or insert into pendapatan table
                // Simpan data pendapatan dalam koleksi array
                $currentDate = now();
                $categories = [];

                foreach ($changes as $change) {
                    $itemName = $change["itemName"];
                    $adjustedQuantity = $change["adjustedQuantity"];
                
                    $product = Product::where('name', $itemName)->first();
                    $product->base_quantity -= $adjustedQuantity;
                    $product->save();
                
                    $categoryData = [
                        'name' => $itemName,
                        'category' => $product->category,
                        'total_price' => $product->price * $adjustedQuantity,
                        'total_quantity' => $adjustedQuantity,
                        'created_at' => $currentDate,
                        'updated_at' => $currentDate
                    ];
                
                    $categories[] = $categoryData;
                }
                
                // Update or create Pendapatan
                Pendapatan::insert($categories);
        }
        return redirect()->route('penjualanM')->with('success', 'Operasi berhasil dilakukan.');
    }
    //----Penjualan

    //----Laba Rugi
    public function calculateLabaRugi($tanggal) {
        $pendapatan = Pendapatan::whereDate('created_at', $tanggal)->sum('total_price');
        $pengeluaran = Pengeluaran::whereDate('created_at', $tanggal)->sum('price');
    
        return $pendapatan - $pengeluaran;
    }

    public function getLabaRugiForDates($start_date, $end_date) {
        $labaRugi = [];
    
        $current_date = $start_date;
    
        while ($current_date <= $end_date) {
            $pendapatan = Pendapatan::whereDate('created_at', $current_date)->sum('total_price');
            $pengeluaran = Pengeluaran::whereDate('created_at', $current_date)->sum('price');
    
            $labaRugi[$current_date] = [
                'pendapatan' => $pendapatan,
                'pengeluaran' => $pengeluaran,
                'labaRugi' => $pendapatan - $pengeluaran,
            ];
    
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
        }
    
        return $labaRugi;
    }    
    
    public function labarugi() {
        $bulanSekarang = now()->format('m');
        $bulanSekarang1 = now()->format('M');
        $tahunSekarang = now()->format('Y');
        $stokterjual = Pendapatan::whereMonth('created_at', $bulanSekarang)
                                        ->whereYear('created_at', $tahunSekarang)
                                        ->sum('total_quantity');
        $penghasilan = Pendapatan::whereMonth('created_at', $bulanSekarang)
                                        ->whereYear('created_at', $tahunSekarang)
                                        ->sum('total_price');
        $pengeluaran = Pengeluaran::whereMonth('created_at', $bulanSekarang)
                                        ->whereYear('created_at', $tahunSekarang)
                                        ->sum('price');
        // Mengambil tanggal awal untuk bulan ini
        $start_date = now()->startOfMonth()->format('Y-m-d');
        
        // Mengambil tanggal akhir untuk bulan ini
        $end_date = now()->endOfMonth()->format('Y-m-d');
    
        $labaRugi = $this->getLabaRugiForDates($start_date, $end_date);
    
        return view('pages.laba_rugi', compact('bulanSekarang','bulanSekarang1','tahunSekarang','stokterjual','penghasilan','pengeluaran'),[
            'labaRugi' => $labaRugi,
            'title' => 'Laba Rugi'
        ]);
    }       
    
    public function viewlabarugi($tanggal){
        $tanggalK = Carbon::parse($tanggal);
        $kemarin = clone $tanggalK;
        $kemarin->subDay();
        $kemarinFormatted = $kemarin->format('Y-m-d');

        $pendapatanK = Pendapatan::whereDate('created_at', $kemarinFormatted)->sum('total_price');
        $pendapatan = Pendapatan::whereDate('created_at', $tanggal)->get();
        $stok = Pendapatan::whereDate('created_at', $tanggal)->sum('total_quantity');
        $pendapatanL = Pendapatan::whereDate('created_at', $tanggal)->sum('total_price');
        $pengeluaran = Pengeluaran::whereDate('created_at', $tanggal)->get();
        $pengeluaranL = Pengeluaran::whereDate('created_at', $tanggal)->sum('price');
        $pengeluaranK = Pengeluaran::whereDate('created_at', $kemarinFormatted)->sum('price');
        $dataKategori = Ingredients_category_sale::pluck('category');
        $dataKategoriL = Ingredients_category::pluck('category');

        $hasilK = $pendapatanK - $pengeluaranK;
        $hasilL = $pendapatanL - $pengeluaranL;

        $persentasePerubahan = 0;

        if ($hasilK > 0) {
            $persentasePerubahan = (($hasilL - $hasilK) / $hasilK) * 100;
        }
        return view('pages.view-laba-rugi',compact('pendapatan','persentasePerubahan','kemarinFormatted','pendapatanK','pendapatanL','stok','pengeluaran','pengeluaranL','tanggal','dataKategori','dataKategoriL'),[
            'title' => 'View'
        ]);    
    }
    //----Laba Rugi

    //----Stok Barang
    public function stockB(){
        $menus = Product::all();
        $dataKategori = Ingredients_category_sale::pluck('category');

        return view('pages.stock-barang', compact('menus','dataKategori'),[
        "title" => "Stok Barang",
        ]);
    }

    //Post
    public function simpandatamenu(Request $request){
        //validate form
        $this->validate($request, [
            'category'      => 'required|min:1',
            'name'          => 'required|min:1',
            'base_quantity' => 'required|min:1',
            'price'         => 'required|min:1',
        ]);

        //create post
        $menus = Product::create([
            'category'      => $request->category,
            'name'          => $request->name,
            'base_quantity' => $request->base_quantity,
            'price'         => $request->price,
        ]);

        //redirect to index
        return redirect()->route('stockB')->with('success', 'Operasi berhasil dilakukan.');
    }

    //Edit
    public function edit($id){
        $menus = Product::where('id',$id)->get();
        $dataKategori = Ingredients_category_sale::pluck('category');

        return view('pages.edit-data-menu',compact('menus','dataKategori'),[
        "title" => "Edit Data"
        ]);
    }

    public function update(Request $request, $id) {
        $menus = Product::where('id',$id)->get();
        //validate form
        $this->validate($request, [
            'category'      => 'required|min:1',
            'name'          => 'required|min:1',
            'base_quantity' => 'required|min:1',
            'price'         => 'required|min:1',
        ]);

         

            //update post without image
            Product::where('id',$request->id)->update([
                'category'      => $request->category,
                'name'          => $request->name,
                'base_quantity' => $request->base_quantity,
                'price'         => $request->price,
            ]);
        

        //redirect to index
        return redirect()->route('stockB')->with('success', 'Operasi berhasil dilakukan.');
    }

    //DELETE
    public function delete( $id){
        $menus = Product::where('id',$id)->delete();
        return redirect()->route('stockB')->with('success', 'Operasi berhasil dilakukan.');
    }
    //----Stock Barang

    //----Users
    public function users(){
        $manages = Manage::all();
        return view('pages.users',compact('manages'),[
            "title" => "Users"
        ]);
    }
    //----Users

    //----Setting
    public function settings(){

        //<!--awal::target-->
        // Ambil bulan dan tahun saat ini
        $bulanSekarang1 = now()->format('M');
        $bulanSekarang = now()->format('m');
        $tahunSekarang = now()->format('Y');

        // Ambil data pendapatan untuk bulan ini

        $pendapatanBulanIni = Pendapatan::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get();

        $targetP = Target_pendapatan::select('tujuan_penghasilan')->whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get();

        // Hitung total quantity dan total price untuk data bulan ini
        $penjualanTerjual = $pendapatanBulanIni->sum('total_price');
        $targetPenjualan = $targetP->sum('tujuan_penghasilan');

        // Pastikan $targetPenjualan tidak null dan bukan nol sebelum melakukan pembagian
        if (!is_null($targetPenjualan) && $targetPenjualan != 0) {
            $persentaseTerjual = ($penjualanTerjual / $targetPenjualan) * 100;
        } else {
            $persentaseTerjual = 0; // Atur ke 0 jika $targetPenjualan adalah null atau nol untuk menghindari pembagian oleh nol.
        }
        //<!--akhir::target-->

        return view('pages.manage', compact('bulanSekarang1','tahunSekarang','targetPenjualan','penjualanTerjual'),[
            "title" => "Manage"
        ]);
    }

    public function aturtarget(Request $request)
    {
        $bulanSekarang1 = now()->format('M');
        $tahunSekarang1 = now()->format('y');
        // Validasi data jika diperlukan
        $request->validate([
            'tujuan_penghasilan' => 'required',
        ]);
    
        // Mendapatkan tanggal dari input form
        $data = [
            'Key' => strtoupper($bulanSekarang1 . $tahunSekarang1),
            'tujuan_penghasilan' => $request->tujuan_penghasilan,
        ];
    

        Target_pendapatan::updateOrCreate(
            ['key' => $data['Key']],
            ['tujuan_penghasilan' => $data['tujuan_penghasilan']]
        );
    
        // Redirect atau lakukan tindakan lain sesuai kebutuhan
        return redirect()->route('settingsM')->with('success', 'Data berhasil disimpan.');
    }
    //----Setting
    public function show($name){
        $profile = Manage::where('name',$name)->get();

        return view('pages.show-profile',compact('profile'),[
        "title" => "Profile"
        ]);
    }
}
