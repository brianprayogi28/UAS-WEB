<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index()
    {
        $data = Guru::all();
        return response([
            'success' => true,
            'message' => 'List Semua data guru',
            'data' => $data
        ], 200);
    }

    // menambahkan data guru

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'nama_guru' => 'required',
            'jk_guru' => 'required',
            'bidang_mengajar' => 'required',
            'alamat_guru' => 'required',
        ],
            [
                'nip.required' => 'Masukkan nip !',
                'nama_guru.required' => 'Masukkan nama guru !',
                'jk_guru.required' => 'Masukkan jenis kelamin !',
                'bidang_mengajar.required' => 'Masukkan bidang mengajar !',
                'alamat_guru.required' => 'Masukkan alamat !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $data = Guru::create([
                'nip'     => $request->input('nip'),
                'nama_guru'   => $request->input('nama_guru'),
                'jk_guru'   => $request->input('jk_guru'),
                'bidang_mengajar'   => $request->input('bidang_mengajar'),
                'alamat_guru'  => $request->input('alamat_guru'),
            ]);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => ' Gagal Disimpan!',
                ], 401);
            }
        }
    }

    // MENAMPILKAN DATA BERDASARKAN ID
    public function show($id)
    {
        $data = Guru::findOrFail($id);

        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Guru!',
                'data'    => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Guru Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    //Cara Update data
    public function update(Request $request, $id)
    {
        $data = Guru::findOrFail($id);

        // cek data dengan id yg dikirimkan
        if (empty($data)) {
            return response()->json([
                'pesan' => 'Data tidak ditemukan',
                'data' => $data
            ], 404);
        }

        // proses validasi
        $validate = Validator::make($request->all(), [
            'nip' => 'required',
            'nama_guru' => 'required',
            'jk_guru' => 'required',
            'bidang_mengajar' => 'required',
            'alamat_guru' => 'required',
        ]);

        if ($validate->fails()) {
            return $validate->errors();
        }

        // proses simpan perubahan data
        $data->update($request->all());

        return response()->json([
            'pesan' => 'Data berhasil di update',
            'data' => $data
        ], 201);
    }

    //CARA MENGAPUS DATA
    public function delete($id)
    {
        $data = Guru::FindOrFail($id);
        // cek data dengan id yg dikirimkan
        if (empty($data)) {
            return response()->json([
                'pesan' => 'Data tidak ditemukan',
                'data' => $data
            ], 404);
        }

        $data->delete();

        return response()->json([
            'pesan' => 'Data berhasil di hapus',
            'data' => $data
        ], 200);
    }
}
