<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Auth;
use DB;
use App\sj;
use Carbon\Carbon;
use Excel;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Auth::user()->name === 'admin') {
            return redirect('/sj/dashboard');
        }           
    }    
    /*SJ Controller PPIC*/
    public function dashboard()
    {
        $data=sj::groupBy('DOAII')->get();
        return view('dashboard',compact('data'));
    }
    public function filter()
    {
        $data=sj::whereBetween('TANGGAL_DELIVERY',[$_GET['from'],$_GET['to']])->groupBy('DOAII')->get();
        return view('dashboard',compact('data'));
    }
    public function sj_dashboard()
    {
        $start_date=Carbon::now()->addDays(-7);        
        $data=sj::where('tanggal_delivery','>=',$start_date)->groupBy('DOAII')->whereNull('BALIK')->get();        
        return view('sj_dashboard',compact('data'));
    }
    public function sj_receive_fin()
    {
        $data = DB::table('sj')
            ->join('sj_fin', 'sj.DOAII', '=', 'sj_fin.sj_number')
            ->get();
        return view('sj_r_f',compact('data'));
    }
    public function sj_out()
    {
        $start_date=Carbon::now()->addDays(-7);        
        $data=sj::where('tanggal_delivery','<=',$start_date)->groupBy('DOAII')->whereNull('BALIK')->get();
        return view('sj_out',compact('data'));
    }    
    public function upload_sj_dashboard()
    {
        return view('upload_sj_dashboard');
    }
    public function store_upload_sj_dashboard()
    {
        /*Upload SJ PPIC*/
        if(Input::hasFile('sj')){
            $path = Input::file('sj')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $insert[] = 
                    [
                    'TANGGAL_DELIVERY' => $value->tanggal_delivery,
                    'CUSTOMER_NAME' => $value->customer_name,
                    'CYCLE' => $value->cycle,
                    'PDSNUMBER' => $value->pdsnumber,
                    'DOAII' => $value->doaii,
                    'DOAIIA' => $value->doaiia                                        
                    ];
                }
                
                if(!empty($insert)){
                    DB::table('sj')->insert($insert);
                    \Session::flash('message', 'Sukses Upload SJ'); 
                }else{
                    \Session::flash('warning', 'Gagal Upload SJ');
                }
            }
        }
        \Session::flash('message', 'Sukses Upload SJ'); 
        return redirect('/sj/dashboard');
    }
    public function balik()
    {
        $data=sj::groupBy('DOAII')->get();
        return view('balik',compact('data'));
    }
    public function balik_store()
    {
        if (DB::table('sj')->where('DOAII', $_POST['rc'])->count('PDSNUMBER')==null) {
            \Session::flash('warning', 'Nomor PDS Salah !!!'); 
            return redirect('/balik');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('BALIK')!=null){
            \Session::flash('warning', 'SJ Sudah BALIK !!!'); 
            return redirect('/balik');
        }else{
        DB::table('sj')
            ->where('DOAII', $_POST['rc'])
             ->update(['BALIK' =>\Carbon\Carbon::now()]);
             \Session::flash('message', 'Sukses Simpan Nomor PDS = '.$_POST['rc']); 
             return redirect('/balik');
             }
    }
    public function rc()
    {
        $data=sj::groupBy('DOAII')->get();
        return view('rc',compact('data'));
    }
    public function rc_store()
    {
        if (DB::table('sj')->where('DOAII', $_POST['rc'])->count('PDSNUMBER')==null) {
            \Session::flash('warning', 'Nomor PDS Salah !!!'); 
            return redirect('/rc');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('BALIK')==null){
            \Session::flash('warning', 'SJ Belum BALIK !!!'); 
            return redirect('/rc');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('RECHEIPT_CHECK')!=null){
            \Session::flash('warning', 'SJ Sudah RECHEIPT_CHECK !!!'); 
            return redirect('/rc');
        }else{
        DB::table('sj')
            ->where('DOAII', $_POST['rc'])
             ->update(['RECHEIPT_CHECK' =>\Carbon\Carbon::now()]);
             \Session::flash('message', 'Sukses Simpan Nomor PDS = '.$_POST['rc']); 
             return redirect('/rc')->with(['success' => 'Berhasil']);
         }
    }    
    public function fin()
    {
        $data=sj::groupBy('DOAII')->get();
        return view('fin',compact('data'));
    }
    public function fin_upload()
    {
        /*Upload SJ Fin*/
        if(Input::hasFile('upload_sj')){
            $path = Input::file('upload_sj')->getRealPath();
            $data = Excel::selectSheets('SCAN AIIA')->load($path, function($reader) {
            
            })->get(array('scan_no_surat_jalan'));
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {                    
                    if($value->filter()->isNotEmpty() && DB::table('sj_fin')->where('sj_number',$value->scan_no_surat_jalan)->count()<0){
                    $insert[] = 
                    [
                    'sj_number' => $value->scan_no_surat_jalan                                                            
                    ];
                    }
                }
                
                if(!empty($insert)){
                    DB::table('sj_fin')->insert($insert);
                    \Session::flash('message', 'Sukses Upload SJ'); 
                }else{
                    \Session::flash('warning', 'Gagal Upload SJ');
                }
            }
        }
        \Session::flash('message', 'Sukses Upload SJ'); 
        return redirect('/sj/dashboard');
    }
    public function fin_store()
    {
        if (DB::table('sj')->where('DOAII', $_POST['rc'])->count('PDSNUMBER')==null) {
            \Session::flash('warning', 'Nomor PDS Salah !!!'); 
            return redirect('/fin');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('BALIK')==null){
            \Session::flash('warning', 'SJ Belum BALIK !!!'); 
            return redirect('/fin');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('RECHEIPT_CHECK')==null){
            \Session::flash('warning', 'SJ Belum RECHEIPT_CHECK !!!'); 
            return redirect('/fin');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('FINANCE')!=null){
            \Session::flash('warning', 'SJ Sudah di FINANCE !!!'); 
            return redirect('/fin');
        }else{
        DB::table('sj')
            ->where('DOAII', $_POST['rc'])
             ->update(['FINANCE' =>\Carbon\Carbon::now()]);
             \Session::flash('message', 'Sukses Simpan Nomor PDS = '.$_POST['rc']); 
             return redirect('/fin')->with(['success' => 'Berhasil']);
         }
    }    
    public function aii()
    {
        $data=sj::groupBy('DOAII')->get();
        return view('kaii',compact('data'));
    }
    public function aii_store()
    {
        if (DB::table('sj')->where('DOAII', $_POST['rc'])->count('PDSNUMBER')==null) {
            \Session::flash('warning', 'Nomor PDS Salah !!!'); 
            return redirect('/aii');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('BALIK')==null){
            \Session::flash('warning', 'SJ Belum BALIK !!!'); 
            return redirect('/aii');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('RECHEIPT_CHECK')==null){
            \Session::flash('warning', 'SJ Belum RECHEIPT_CHECK !!!'); 
            return redirect('/aii');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('FINANCE')==null){
            \Session::flash('warning', 'SJ Belum di FINANCE !!!'); 
            return redirect('/aii');
        }elseif(DB::table('sj')->where('DOAII', $_POST['rc'])->count('KIRIMAII')!=null){
            \Session::flash('warning', 'SJ Sudah kirim AII !!!'); 
            return redirect('/aii');        
        }else{
        DB::table('sj')
            ->where('DOAII', $_POST['rc'])
             ->update(['KIRIMAII' =>\Carbon\Carbon::now()]);
             \Session::flash('message', 'Sukses Simpan Nomor PDS = '.$_POST['rc']); 
             return redirect('/aii')->with(['success' => 'Berhasil']);
         }
    }
    public function del_ppic($id)
    {
        DB::table('sj')->where('DOAII',$id)->delete();
        \Session::flash('warning', 'PDS NUMBER berhasil dihapus');
        return redirect('/dashboard');
    }
}