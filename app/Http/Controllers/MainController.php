<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use App\sj;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\Session;
use Datatables;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function data_sj()
    {
        $data = sj::select('id','created_at','tanggal_delivery','customer_name','cycle','pdsnumber','doaii','doaiia','sj_balik','terima_finance');        
        return Datatables::of($data)
        ->addColumn('action', function ($data) {
                return '<a class="btn btn-warning btn-xs" href="edit_sj/'.$data->id.'">Edit</a>
                <a class="btn btn-danger btn-xs" href="delete_sj/'.$data->id.'">Del</a>
                ';
            })
        ->make();
    }
    public function data_outstanding_sj()
    {
        $start_date=Carbon::now()->addDays(-7);        
        if(Auth::user()->name === 'finance'){
            $data=sj::select('created_at','tanggal_delivery','customer_name','cycle','pdsnumber','doaii','doaiia','sj_balik','terima_finance')->where('tanggal_delivery','>=',$start_date)->whereNull('terima_finance')->groupBy('doaii');
        }else{
            $data=sj::select('created_at','tanggal_delivery','customer_name','cycle','pdsnumber','doaii','doaiia','sj_balik','terima_finance')->where('tanggal_delivery','>=',$start_date)->groupBy('doaii')->whereNull('sj_balik');                    
        }                
        return Datatables::of($data)->make();
    }
    public function data_outstanding_sj_7_day()
    {
        $start_date=Carbon::now()->addDays(-7);        
        $data=sj::select('created_at','tanggal_delivery','customer_name','cycle','pdsnumber','doaii','doaiia','sj_balik','terima_finance')->where('tanggal_delivery','<=',$start_date)->groupBy('doaii')->whereNull('sj_balik');
        return Datatables::of($data)->make();
    }    
    public function index()
    {
        return redirect('/sj/dashboard');
    }       
    public function dashboard()
    {
        return view('dashboard');
    }
    public function filter_view()
    {
        $data=sj::whereBetween('tanggal_delivery',[$_POST['from'],$_POST['to']])->groupBy('doaii')->get();
        return view('dashboard_filter',compact('data'));
    }
    public function sj_dashboard()
    {        
        return view('sj_dashboard');
    }
    public function sj_outstanding()
    {
        return view('sj_outstanding');
    }  
    public function upload_sj_dashboard()
    {
        return view('upload_sj_dashboard');
    }
    public function upload_sj_dashboard_store()
    {        
        if(Input::hasFile('sj')){
            $path = Input::file('sj')->getRealPath();
            $data = Excel::load($path)->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $insert[] = 
                    [
                    'tanggal_delivery' => $value->tanggal_delivery,
                    'customer_name' => $value->customer_name,
                    'cycle' => $value->cycle,
                    'pdsnumber' => $value->pdsnumber,
                    'doaii' => $value->doaii,
                    'doaiia' => $value->doaiia,
                    ];
                }
                #dd($insert[0]);
                if(!empty($insert)){
                    foreach($insert as $row) {
                    if($row['tanggal_delivery']!=null){
                    sj::create($row);
                    }
                    }
                    Session::flash('message', 'Sukses Upload SJ'); 
                }else{
                    Session::flash('danger', 'Gagal Upload SJ');
                }
            }
        }
        Session::flash('danger', 'Something Wrong Contact Administrator'); 
        return redirect('/sj/dashboard');
    }
    public function update_sj_balik_ppic_upload()
    {
        if(Input::hasFile('update_sj_balik_ppic')){
            $path = Input::file('update_sj_balik_ppic')->getRealPath();
            $data = Excel::load($path)->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $insert[] = 
                    [
                    'doaii' => $value->doaii,
                    ];
                }
                #dd($data);               
                if(!empty($insert)){
                    $cek=sj::where('doaii',$insert)->whereNotNull('sj_balik')->get();
                    if($cek->toArray()==null){
                    foreach($insert as $row) {
                        sj::where('doaii',$row)->update(['sj_balik' =>\Carbon\Carbon::now()]);
                    }
                    Session::flash('message', 'Sukses Upload SJ');
                }else{
                    Session::flash('danger', 'Gagal Upload SJ Sudah Balik'); 
                } 
                }else{
                    Session::flash('danger', 'Gagal Upload SJ');
                }
            }
        }else{
        Session::flash('danger', 'Something Wrong Contact Administrator'); 
        }
        return redirect('/sj/dashboard');
    }    
    public function sj_balik()
    {
        return view('sj_balik');
    }
    public function sj_balik_store()
    {
        if (sj::where('doaii', $_POST['doaii'])->count('doaii')==null) {
            Session::flash('danger', 'Nomor PDS Salah !!!'); 
            return redirect('/sj_balik');
        }elseif(sj::where('doaii', $_POST['doaii'])->count('sj_balik')!=null){
            Session::flash('danger', 'SJ Sudah BALIK !!!'); 
            return redirect('/sj_balik');
        }else{
        sj::where('doaii', $_POST['doaii'])
             ->update(['sj_balik' =>\Carbon\Carbon::now()]);
             Session::flash('message', 'Sukses Simpan Nomor PDS = '.$_POST['doaii']); 
             return redirect('/sj_balik');
             }
        
    }    
    public function terima_finance()
    {
        $data=sj::groupBy('doaii')->get();
        return view('terima_finance',compact('data'));
    }    
    public function update_fin_upload()
    {
        if(Input::hasFile('update_fin_upload')){
            $path = Input::file('update_fin_upload')->getRealPath();
            $data = Excel::load($path)->get();
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $insert[] = 
                    [
                    'doaii' => $value->doaii,
                    ];
                }
                #dd($data);               
                if(!empty($insert)){
                    foreach($insert as $row) {
                        sj::where('doaii',$row)->update(['terima_finance' =>\Carbon\Carbon::now()]);                     
                }}else{
                    Session::flash('danger', 'Gagal Upload SJ');
                }
            }
        }else{
        Session::flash('danger', 'Something Wrong Contact Administrator'); 
        }
        return redirect('/sj/dashboard');
    }
    public function terima_finance_store()
    {
        sj::where('doaii', $_POST['doaii'])
             ->update(['terima_finance' =>\Carbon\Carbon::now()]);
             Session::flash('message', 'Sukses Simpan Nomor PDS = '.$_POST['doaii']); 
             return redirect('/terima_finance')->with(['success' => 'Berhasil']);         
    }    
    
    public function del_ppic($id)
    {
        sj::where('id',$id)->delete();
        Session::flash('warning', 'PDS NUMBER berhasil dihapus');
        return redirect('/dashboard');
    }
    public function sj_update($id)
    {
        $data=sj::where('id',$id)->first();
        return view('sj_update',compact('data'));
    }
    public function sj_update_store($id)
    {
        sj::where('id',$id)->update(request()->except(['_token']));
        Session::flash('warning', 'Data berhasil dirubah');
        return redirect('dashboard');
    }     
    public function create_sj()
    {
        return view('create_sj');
    }
    public function create_sj_store()
    {
        sj::create(request()->all());
        return redirect('sj/dashboard');
    }
}