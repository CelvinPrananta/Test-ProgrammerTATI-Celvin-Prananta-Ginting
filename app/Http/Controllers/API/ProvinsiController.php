<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiProvinsi;
use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Exception;
use Illuminate\Http\Request;
use Mockery\Expectation;

class ProvinsiController extends Controller
{
    /** Lihat Semua Data Provinsi */
    public function lihatProvinsi()
    {
        $data = Provinsi::all();

        if($data){
            return ApiProvinsi::createApi(200, 'Berhasil Melihat Semua Data Provinsi',$data);
        }else{
            return ApiProvinsi::createApi(400, 'Gagal Melihat Semua Data Provinsi');
        }
    }
    /** /Lihat Semua Data Provinsi */

    /** Tambah Data Provinsi */
    public function tambahProvinsi(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $provinsi = Provinsi::create([
                'name' => $request->name
            ]);

            $data = Provinsi::where('id','=',$provinsi->id)->get();

            if($data){
                return ApiProvinsi::createApi(200, 'Berhasil Tambah Data Provinsi',$data);
            }else{
                return ApiProvinsi::createApi(400, 'Gagal Tambah Data Provinsi');
            }
        } catch (Exception $error) {
            return ApiProvinsi::createApi(400, 'Gagal Tambah Data Provinsi');
        }
    }
    /** /Tambah Data Provinsi */

    /** Lihat Detail Data Provinsi */
    public function detailProvinsi(string $id)
    {
        $data = Provinsi::where('id','=',$id)->get();

        if($data){
            return ApiProvinsi::createApi(200, 'Berhasil Melihat Detail Data Provinsi',$data);
        }else{
            return ApiProvinsi::createApi(400, 'Gagal Melihat Detail Data Provinsi');
        }
    }
    /** /Lihat Detail Data Provinsi */

    /** Perbaharui Data Provinsi */
    public function perbaharuiProvinsi(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $provinsi = Provinsi::findOrFail($id);

            $provinsi->update([
                'name' => $request->name
            ]);

            $data = Provinsi::where('id','=',$provinsi->id)->get();

            if($data){
                return ApiProvinsi::createApi(200, 'Berhasil Perbaharui Data Provinsi',$data);
            }else{
                return ApiProvinsi::createApi(400, 'Gagal Perbaharui Data Provinsi');
            }
        } catch (Exception $error) {
            return ApiProvinsi::createApi(400, 'Gagal Perbaharui Data Provinsi');
        }
    }
    /** /Perbaharui Data Provinsi */

    /** Hapus Data Provinsi */
    public function hapusProvinsi(string $id)
    {
        try {
            $provinsi = Provinsi::findOrFail($id);

            $data = $provinsi->delete();

            if($data){
                return ApiProvinsi::createApi(200, 'Berhasil Hapus Data Provinsi');
            }else{
                return ApiProvinsi::createApi(400, 'Gagal Hapus Data Provinsi');
            }
        } catch (Exception $error) {
            return ApiProvinsi::createApi(400, 'Gagal Hapus Data Provinsi');
        }
    }
    /** /Hapus Data Provinsi */
}