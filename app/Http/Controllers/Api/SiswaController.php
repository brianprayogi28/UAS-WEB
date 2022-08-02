<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        $data = Siswa::with('guru','kelas')->get();
        return response()->json($data, 200);
    }

    // menambahkan data siswa

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'id_guru' => 'required',
            'id_kelas' => 'required',
            'nis' => 'required',
            'nama_siswa' => 'required',
            'jk_siswa' => 'required',
            'email' => 'required',
            'alamat_siswa' => 'required',
        ],
            [
                'id_guru.required' => 'Masukkan ID Guru !',
                'id_kelas.required' => 'Masukkan ID Kelas !',
                'nis.required' => 'Masukkan nis !',
                'nama_siswa.required' => 'Masukkan nama siswa !',
                'jk_siswa.required' => 'Masukkan jenis kelamin !',
                'email.required' => 'Masukkan email !',
                'alamat_siswa.required' => 'Masukkan alamat !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);

        } else {

            $data = Siswa::create([
                'id_guru'     => $request->input('id_guru'),
                'id_kelas'     => $request->input('id_kelas'),
                'nis'     => $request->input('nis'),
                'nama_siswa'   => $request->input('nama_siswa'),
                'jk_siswa'   => $request->input('jk_siswa'),
                'email'   => $request->input('email'),
                'alamat_siswa'  => $request->input('alamat_siswa'),
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
        $data = Siswa::findOrFail($id);


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
        $data = Siswa::findOrFail($id);

        // cek data dengan id yg dikirimkan
        if (empty($data)) {
            return response()->json([
                'pesan' => 'Data tidak ditemukan',
                'data' => $data
            ], 404);
        }

        // proses validasi
        $validate = Validator::make($request->all(), [
            'id_guru' => 'required',
            'id_kelas' => 'required',
            'nis' => 'required',
            'nama_siswa' => 'required',
            'jk_siswa' => 'required',
            'email' => 'required',
            'alamat_siswa' => 'required',
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
        $data = Siswa::findOrFail($id);
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
