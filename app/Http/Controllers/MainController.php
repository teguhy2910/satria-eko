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
        $data = sj::select('id','created_at','tanggal_delivery','customer_name','pdsnumber','doaii','sj_balik','terima_finance')->groupBy('doaii');        
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
            $data=sj::select('created_at','tanggal_delivery','customer_name','pdsnumber','doaii','sj_balik','terima_finance')->where('tanggal_delivery','>=',$start_date)->whereNull('terima_finance')->groupBy('doaii');
        }else{
            $data=sj::select('created_at','tanggal_delivery','customer_name','pdsnumber','doaii','sj_balik','terima_finance')->where('tanggal_delivery','>=',$start_date)->groupBy('doaii')->whereNull('sj_balik');                    
        }                
        return Datatables::of($data)->make();
    }
    public function data_outstanding_sj_7_day()
    {
        $start_date=Carbon::now()->addDays(-7);        
        $data=sj::select('created_at','tanggal_delivery','customer_name','pdsnumber','doaii','sj_balik','terima_finance')->where('tanggal_delivery','<=',$start_date)->groupBy('doaii')->whereNull('sj_balik');
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
                    'pdsnumber' => $value->pdsnumber,
                    'doaii' => $value->doaii,                    
                    ];
                }
                $insert=array_filter($insert, function($value) { return !is_null($value['doaii']) && $value['doaii'] !== ''; });
                if(!empty($insert)){
                    foreach($insert as $row) {
                    if($row['tanggal_delivery']!=null){
                    sj::create($row);                    
                    }
                    }
                    $total_upload="Sukses Scan SJ, Total Upload=".count($insert)." SJ";
                    Session::flash('message', $total_upload); 
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
                    $cek=sj::where('doaii',$value->doaii)->whereNotNull('doaii')->get();
                    if($cek->toArray()!=null){
                    $insert[] = 
                    [
                    'doaii' => $value->doaii,
                    ];
                    }else{
                    $error[] = 
                    [
                    'doaii' => $value->doaii,
                    ];  
                    }                    
                } 
                $insert=array_filter($insert, function($value) { return !is_null($value['doaii']) && $value['doaii'] !== ''; });     
                $no=0;
                $noo=0;
                if(!empty($insert)){                    
                    foreach($insert as $row) {
                    $cek=sj::where('doaii',$row)->first();
                    if($cek['sj_balik']===null){                    
                    $no++;
                    $sukses_upload[] = 
                    [
                    'doaii' => $cek['doaii'],
                    ];
                    sj::where('doaii',$row)->update(['sj_balik' =>\Carbon\Carbon::now()]);  
                    $total_upload="Sukses Scan SJ, Total Upload=".$no." SJ";
                    Session::flash('message', $total_upload);    
                    }else{
                        $sudah_balik[] = 
                            [
                            'doaii' => $cek['doaii'],
                            ];
                        $noo++;
                        Session::flash('danger', 'Gagal Upload ' .$noo. ' SJ Sudah Balik');  
                    }                                                            
                } 
                }else{
                    Session::flash('danger', 'Gagal Upload SJ');
                }
            }
        }else{
        Session::flash('danger', 'Something Wrong Contact Administrator'); 
        }
        if(!empty($error)&&!empty($sudah_balik)&&!empty($sukses_upload)){
        Excel::create('SJ Error', function($excel) use($error,$sudah_balik,$sukses_upload) {
            $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error) {
                $sheet->fromArray($error);
            });
            $excel->sheet('SJ Sudah Balik', function($sheet) use($sudah_balik) {
                $sheet->fromArray($sudah_balik);
            });
            $excel->sheet('SJ Sukses Upload', function($sheet) use($sukses_upload) {
                $sheet->fromArray($sukses_upload);
            });

        })->export('xlsx');
        }elseif(!empty($error)&&!empty($sukses_upload)){
            Excel::create('SJ Error', function($excel) use($error,$sukses_upload) {
                $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error) {
                    $sheet->fromArray($error);
                });
                $excel->sheet('SJ Sukses Upload', function($sheet) use($sukses_upload) {
                    $sheet->fromArray($sukses_upload);
                });
    
            })->export('xlsx');
            }
            elseif(!empty($sudah_balik)&&!empty($sukses_upload)){
                Excel::create('SJ Error', function($excel) use($sudah_balik,$sukses_upload) {
                    $excel->sheet('SJ Sudah Balik', function($sheet) use($sudah_balik,$sukses_upload) {
                        $sheet->fromArray($sudah_balik);
                    });
                    $excel->sheet('SJ Sukses Upload', function($sheet) use($sukses_upload) {
                        $sheet->fromArray($sukses_upload);
                    });
        
                })->export('xlsx');
                }
        elseif(!empty($error)&&!empty($sudah_balik)){
            Excel::create('SJ Error', function($excel) use($error,$sudah_balik) {
                $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error,$sudah_balik) {
                    $sheet->fromArray($error);
                });
                $excel->sheet('SJ Sudah Balik', function($sheet) use($sudah_balik) {
                    $sheet->fromArray($sudah_balik);
                });
    
            })->export('xlsx');
            }
        elseif(!empty($error)){
            Excel::create('SJ Error', function($excel) use($error) {
                $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error) {
                    $sheet->fromArray($error);
                });
    
            })->export('xlsx'); 
        }elseif(!empty($sudah_balik)){
            Excel::create('SJ Error', function($excel) use($sudah_balik) {
                $excel->sheet('SJ Sudah Balik', function($sheet) use($sudah_balik) {
                    $sheet->fromArray($sudah_balik);
                });
    
            })->export('xlsx'); 
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
                    $cek=sj::where('doaii',$value->doaii)->whereNotNull('doaii')->get();
                    if($cek->toArray()!=null){
                    $insert[] = 
                    [
                    'doaii' => $value->doaii,
                    ];
                    }else{
                    $error[] = 
                    [
                    'doaii' => $value->doaii,
                    ];  
                    }                    
                } 
                $insert=array_filter($insert, function($value) { return !is_null($value['doaii']) && $value['doaii'] !== ''; });     
                $no=0;
                $noo=0;
                if(!empty($insert)){                    
                    foreach($insert as $row) {
                    $cek=sj::where('doaii',$row)->first();
                    if($cek['terima_finance']===null){                    
                    $no++;
                    $sukses_upload[] = 
                    [
                    'doaii' => $cek['doaii'],
                    ];
                    sj::where('doaii',$row)->update(['terima_finance' =>\Carbon\Carbon::now()]);  
                    $total_upload="Sukses Scan SJ, Total Upload=".$no." SJ";
                    Session::flash('message', $total_upload);    
                    }else{
                        $terima_finance[] = 
                            [
                            'doaii' => $cek['doaii'],
                            ];
                        $noo++;
                        Session::flash('danger', 'Gagal Upload ' .$noo. ' SJ Sudah Kirim Finance');  
                    }                                                            
                } 
                }else{
                    Session::flash('danger', 'Gagal Upload SJ');
                }
            }
        }else{
        Session::flash('danger', 'Something Wrong Contact Administrator'); 
        }
        if(!empty($error)&&!empty($terima_finance)&&!empty($sukses_upload)){
        Excel::create('SJ Error', function($excel) use($error,$terima_finance,$sukses_upload) {
            $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error) {
                $sheet->fromArray($error);
            });
            $excel->sheet('SJ Sudah Terima Finance', function($sheet) use($terima_finance) {
                $sheet->fromArray($terima_finance);
            });
            $excel->sheet('SJ Sukses Upload', function($sheet) use($sukses_upload) {
                $sheet->fromArray($sukses_upload);
            });

        })->export('xlsx');
        }elseif(!empty($error)&&!empty($sukses_upload)){
            Excel::create('SJ Error', function($excel) use($error,$sukses_upload) {
                $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error) {
                    $sheet->fromArray($error);
                });
                $excel->sheet('SJ Sukses Upload', function($sheet) use($sukses_upload) {
                    $sheet->fromArray($sukses_upload);
                });
    
            })->export('xlsx');
            }
            elseif(!empty($terima_finance)&&!empty($sukses_upload)){
                Excel::create('SJ Error', function($excel) use($terima_finance,$sukses_upload) {
                    $excel->sheet('SJ Sudah Terima Finance', function($sheet) use($terima_finance,$sukses_upload) {
                        $sheet->fromArray($terima_finance);
                    });
                    $excel->sheet('SJ Sukses Upload', function($sheet) use($sukses_upload) {
                        $sheet->fromArray($sukses_upload);
                    });
        
                })->export('xlsx');
                }
        elseif(!empty($error)&&!empty($terima_finance)){
            Excel::create('SJ Error', function($excel) use($error,$terima_finance) {
                $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error,$terima_finance) {
                    $sheet->fromArray($error);
                });
                $excel->sheet('SJ Sudah Terima Finance', function($sheet) use($terima_finance) {
                    $sheet->fromArray($terima_finance);
                });
    
            })->export('xlsx');
            }
        elseif(!empty($error)){
            Excel::create('SJ Error', function($excel) use($error) {
                $excel->sheet('SJ Tidak Ada Di Master', function($sheet) use($error) {
                    $sheet->fromArray($error);
                });
    
            })->export('xlsx'); 
        }elseif(!empty($terima_finance)){
            Excel::create('SJ Error', function($excel) use($terima_finance) {
                $excel->sheet('SJ Sudah Terima Finance', function($sheet) use($terima_finance) {
                    $sheet->fromArray($terima_finance);
                });
    
            })->export('xlsx'); 
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
        Session::flash('warning', 'EDIT data BERHASIL Bro');
        return redirect('dashboard');
    }     
    public function create_sj()
    {
        return view('create_sj');
    }
    public function create_sj_store()
    {
        sj::create(request()->all());
        return redirect('create/sj');
    }
    public function download_sj()
    {
        $sj = sj::all();
        Excel::create('sj', function($excel) use($sj) {
            $excel->sheet('Sheet 1', function($sheet) use($sj) {
                $sheet->fromArray($sj);
            });
        })->export('xlsx');
    }

}
