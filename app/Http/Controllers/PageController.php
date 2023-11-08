<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\Product;
use App\Models\Produksi;
use App\Models\Target_pendapatan;
use App\Models\Manage;
use App\Models\Ingredients_category;
use App\Models\Ingredients_category_sale;
use App\Models\Stock_Storage;
use App\Models\User;
use App\Notifications\PengeluaranNotif;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    //----Pembelian bahan
    public function pengeluaran(){

        $transaksi = Pengeluaran::select('invoice',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(price) as total_price'))
            ->groupBy('invoice')
            ->orderBy('created_at', 'DESC')
            ->get();

        $dataKategori = Ingredients_category::pluck('category');
        return view('pages.pembelian-bahan',compact('transaksi','dataKategori'),[
            "title" => "Pengeluaran"
        ]);
    }

    public function no_transaksi($invoice){
        $transaksi = Pengeluaran::where('invoice',$invoice)
            ->select('invoice',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(price) as total_price'))
            ->groupBy('invoice')
            ->get();

        $transaksiB = pengeluaran::Where('invoice',$invoice)
            ->get();

        return view('pages.transaksi-pengeluaran',compact('transaksi','transaksiB','invoice'),[
            "title" => "Transaksi"
        ]);
    }

    public function no_transaksi_penjualan($invoice){
        $transaksi = Pendapatan::where('invoice',$invoice)
            ->select('invoice',
            DB::raw('SUM(total_quantity) as total_quantity'),
            DB::raw('SUM(total_price) as total_price'))
            ->groupBy('invoice')
            ->get();

        $transaksiB = Pendapatan::Where('invoice',$invoice)
            ->get();

        return view('pages.transaksi-penjualan',compact('transaksi','transaksiB','invoice'),[
            "title" => "Transaksi"
        ]);
    }

    //POST

    public function pengeluaranT(Request $request) {
        // Validasi data jika diperlukan
        $request->validate([
            'form_pembelian.*.category' => 'required',
            'form_pembelian.*.requirement' => 'required',
            'form_pembelian.*.price' => 'required',
            'form_pembelian.*.quantity' => 'required',
        ]);

        // Mengambil data dari form repeater
        $formPembelian = $request->input('form_pembelian');

        // Mengambil tanggal saat ini
        $tanggal = now();

        // Membuat nomor invoice berdasarkan tanggal
        $invoice = 'INV-' . $tanggal->format('YmdHis') . '-' . rand(1000, 9999);

        // Menginisialisasi array untuk menyimpan data pengeluaran
        $dataPengeluaran = [];

        // Memproses data dari form repeater
        foreach ($formPembelian as $item) {
            $data = [
                'category' => $item['category'],
                'requirement' => $item['requirement'],
                'price' => $item['price'] * $item['quantity'],
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'invoice' => $invoice, 
                'updated_at' => $tanggal,
                'created_at' => $tanggal,
            ];

            // Menambahkan data ke array dataPengeluaran
            $dataPengeluaran[] = $data;

            // Cari data berdasarkan nama (requirement) dalam $item
            $name = $item['requirement'];
            $category = $item['category'];
            $base_quantity = $item['quantity'];
            $price = $item['price'];

            // Cari data stok
            $stok = Stock_Storage::where('name', $name)->first();

            if ($stok) {
                // Jika data dengan nama yang sama sudah ada, tambahkan data baru ke data yang ada
                $stok->category = $category;
                $stok->base_quantity += $base_quantity;
                $stok->price = $price;
                $stok->save();
            } else {
                // Jika tidak ada data dengan nama yang sama, buat data baru
                Stock_Storage::updateOrCreate(
                    ['name' => $name],
                    [
                        'category'      => $category,
                        'base_quantity' => $base_quantity,
                        'price'         => $price,
                    ]
                );
            }
        }

        // Simpan data pengeluaran ke database dengan timestamps diisi otomatis
        Pengeluaran::insert($dataPengeluaran);

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
                $invoice = 'INV-' . $currentDate->format('YmdHis') . '-' . rand(1000, 9999);

                foreach ($changes as $change) {
                    $itemName = $change["itemName"];
                    $adjustedQuantity = $change["adjustedQuantity"];

                    $product = Product::where('name', $itemName)->first();
                    $product->base_quantity -= $adjustedQuantity;
                    $product->save();

                    $categoryData = [
                        'invoice' => $invoice,
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
        $stok = Pendapatan::whereDate('created_at', $tanggal)->sum('total_quantity');
        $pendapatanL = Pendapatan::whereDate('created_at', $tanggal)->sum('total_price');
       
        $pengeluaranL = Pengeluaran::whereDate('created_at', $tanggal)->sum('price');
        $pengeluaranK = Pengeluaran::whereDate('created_at', $kemarinFormatted)->sum('price');
        $dataKategori = Ingredients_category_sale::pluck('category');
        $dataKategoriL = Ingredients_category::pluck('category');


        $pendapatan = Pendapatan::select('invoice',
                        DB::raw('SUM(total_quantity) as total_quantity'),
                        DB::raw('SUM(total_price) as total_price'))
                        ->groupBy('invoice')
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', $tanggal)
                        ->get();

        $pengeluaran = Pengeluaran::select('invoice',
                        DB::raw('SUM(quantity) as total_quantity'),
                        DB::raw('SUM(price) as total_price'))
                        ->groupBy('invoice')
                        ->orderBy('created_at', 'DESC')
                        ->whereDate('created_at', $tanggal)
                        ->get();


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
        $menus = Stock_Storage::all();
        $dataKategori = Ingredients_category::pluck('category');

        return view('pages.stock-bahan', compact('menus','dataKategori'),[
        "title" => "Stok Bahan",
        ]);
    }

    //Edit
    public function edit($id){
        $menus = Stock_Storage::where('id',$id)->get();
        $dataKategori = Ingredients_category::pluck('category');

        return view('pages.edit-data-menu',compact('menus','dataKategori'),[
        "title" => "Edit Data"
        ]);
    }

    public function update(Request $request, $id) {
        $menus = Stock_Storage::where('id',$id)->get();
        //validate form
        $this->validate($request, [
            'category'      => 'required',
            'name'          => 'required',
            'base_quantity' => 'required',
            'price'         => 'required',
        ]);

        //update
        Stock_Storage::where('id',$request->id)->update([
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
        $menus = Stock_Storage::where('id',$id)->delete();
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

        $KategoriP = Ingredients_category::all();
        $KategoriJ = Ingredients_category_sale::all();

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

        return view('pages.manage', compact( 'KategoriP','KategoriJ','bulanSekarang1','tahunSekarang','targetPenjualan','penjualanTerjual'),[
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

    //---produksi
    public function produksi(){
        $bahan = Stock_Storage::pluck('name');
        $dataKategori = Ingredients_category_sale::pluck('category');
        $data = produksi::all();
        $dataproduk = Product::all();

        $formattedData = [];

        foreach ($data as $produksi) {
            $ingredients = json_decode($produksi->Ingredients, true);
    
            $formattedString = '';
    
            foreach ($ingredients as $ingredient) {
                $formattedString .= $ingredient['value'] . ', ';
            }
    
            // Hilangkan koma terakhir
            $formattedString = rtrim($formattedString, ', ');
    
            $formattedData[] = $formattedString;
        }
  
        return view('pages.produksi', compact('bahan','dataproduk','dataKategori','data'),[
        "title" => "Produksi",
        'formattedData' => $formattedData,
        ]);
    }

    public function produksilogic(Request $request) {
        $request->validate([
            'name_product' => 'required',
            'base_quantity' => 'required',
            'Ingredients' => 'required',
        ]);
    
        $data = $request->Ingredients;
    
        // Dekode data JSON
        $items = json_decode($data, true);
    
        // Cari produk berdasarkan nama
        $product = Product::where('name', $request->name_product)->first();
    
        if (!$product) {
            // Produk tidak ditemukan
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }
    
        // Ambil nilai sebelumnya
        $previousQuantity = $product->base_quantity;
    
        // Tambahkan nilai baru ke nilai sebelumnya
        $newQuantity = $previousQuantity + $request->base_quantity;
    
        // Simpan nilai baru ke dalam database
        $product->base_quantity = $newQuantity;
        $product->save();
    
        // Iterasi melalui item di Ingredients dan kurangi stok sesuai dengan jumlahnya
        foreach ($items as $item) {
            $itemValue = $item['value'];
    
            // Split itemValue menjadi nama produk dan jumlah
            list($productName, $quantity) = explode(':', $itemValue);
    
            // Cari produk dalam tabel StockStorage
            $stockStorage = Stock_Storage::where('name', $productName)->first();
    
            if ($stockStorage) {
                // Kurangkan stok sesuai dengan jumlah yang ada pada item
                $stockStorage->base_quantity -= $quantity * $request->base_quantity;
                $stockStorage->save();
            }
        }
    
        return redirect()->back()->with('success', 'Nilai dan stok berhasil diperbarui.');
    }

    public function inputdataproduksi(Request $request){
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'Ingredients' => 'required',
        ]);

        Produksi::Create (
            ['name' => $request->name,
            'category' => $request->category,
            'Ingredients' => $request->Ingredients,]
        );

        $data = $request->Ingredients;

        // Dekode data JSON
        $items = json_decode($data, true);

        // Inisialisasi total harga
        $totalHarga = 0;
        $persentaseLaba = 0.3; 

        // Loop setiap item dan hitung total harganya
        foreach ($items as $item) {
            // Pisahkan nama_barang dan jumlah
            $splitItem = explode(':', $item['value']);
            $namaBarang = $splitItem[0];
            $jumlah = (int) $splitItem[1];

            // Ambil harga satuan dari database berdasarkan nama_barang
            $hargaSatuan = Stock_Storage::where('name', $namaBarang)->first()->price;

            // Hitung total harga untuk item saat ini
            $totalHarga += $hargaSatuan * $jumlah;
            $keuntungan = $totalHarga * $persentaseLaba;
            $totalHargaLaba = $totalHarga + $keuntungan;
        }

        Product::Create (
            ['name' => $request->name,
            'category' => $request->category,
            'base_quantity' => '0', 
            'price' => $totalHargaLaba]
        );

        return redirect()->route('produksi')->with('success', 'Data berhasil disimpan.');
    }

    //manage
    public function saveP(Request $request){
        $this->validate($request, [
            'category'      => 'required',
        ]);

        Ingredients_category::create(
            ['category' => $request->category,]
        );

        return redirect()->route('settingsM')->with('success', 'Data berhasil disimpan.');
    }

    public function saveJ(Request $request){
        $this->validate($request, [
            'category'      => 'required',
        ]);

        Ingredients_category_sale::create(
            ['category' => $request->category,]
        );

        return redirect()->route('settingsM')->with('success', 'Data berhasil disimpan.');
    }

    //DeleteP
    public function deleteP( $id){
        $menus = Ingredients_category::where('id',$id)->delete();
        return redirect()->route('settingsM')->with('success', 'Operasi berhasil dilakukan.');
    }

    //DeleteJ
    public function deleteJ( $id){
        $menus = Ingredients_category_sale::where('id',$id)->delete();
        return redirect()->route('settingsM')->with('success', 'Operasi berhasil dilakukan.');
    }

    public function updateP(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);
        $category = Ingredients_category::find($id);
        $category->category = $request->input('category');
        $category->save();

        return redirect()->route('settingsM')->with('success', 'Operasi berhasil dilakukan.');
    }

    public function updateJ(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);
        $category = Ingredients_category_sale::find($id);
        $category->category = $request->input('category');
        $category->save();

        return redirect()->route('settingsM')->with('success', 'Operasi berhasil dilakukan.');
    }
}