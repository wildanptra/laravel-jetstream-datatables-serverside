<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Siswa;
use DataTables;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function json(Request $request)
    {
        $siswa = Siswa::select([
        'siswa.id',
        'siswa.nama',
        'siswa.alamat',
        'siswa.kelas_id',
        'siswa.status'])->with('kelas');

        $datatables = DataTables::of($siswa)->editColumn('status', function($data_siswa){

            if($data_siswa->status == 1){
                return 'Aktif';
            }elseif($data_siswa->status == 0){
                return 'Tidak Aktif';
            }

        })->addColumn('status_siswa', function($data_siswa){

            if($data_siswa->status == 1){
                return '<span class="badge rounded-pill bg-success">Aktif</span>';
            }elseif($data_siswa->status == 0){
                return '<span class="badge rounded-pill bg-danger">Tidak Aktif</span>';
            }

        })->addColumn('action',function($data){

            $url_edit = url('siswa/edit/'.$data->id);
            $url_hapus = url('siswa/hapus/'.$data->id);

            $button = '<a href="'.$url_edit.'" class="btn btn-primary btn-sm mx-2">Edit</a>';
            $button .= '<a href="'.$url_hapus.'" class="btn btn-danger btn-sm mx-2">Hapus</a>';

            return $button;
        })->rawColumns(['status_siswa', 'action']);


        return $datatables->make(true);
    }

    public function index()
    {
        return view('siswa.index');
    }
}
