<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $data = Kelas::all();
        return response([
            'success' => true,
            'message' => 'List Semua data kelas',
            'data' => $data
        ], 200);
    }

    // menambahkan data kelas

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required',
            'jurusan' => 'required',
        ],
            [
                'nama_kelas.required' => 'Masukkan nama kelas !',
                'jurusan.required' => 'Masukkan jurusan !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $data = kelas ::create([
                'nama_kelas'     => $request->input('nama_kelas'),
                'jurusan'   => $request->input('jurusan'),

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
        $data = Kelas ::findOrFail($id);


        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 401);
        }
    }

    //Cara Update data
    public function update(Request $request, $id)
    {
        $data = Kelas::findOrFail($id);

        // cek data dengan id yg dikirimkan
        if (empty($data)) {
            return response()->json([
                'pesan' => 'Data tidak ditemukan',
                'data' => $data
            ], 404);
        }

        // proses validasi
        $validate = Validator::make($request->all(), [
            'nama_kelas' => 'required',
            'jurusan' => 'required',

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
        $data = Kelas::findOrFail($id);
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
