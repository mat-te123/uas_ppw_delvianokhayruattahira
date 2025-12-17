<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Pekerjaan;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pagination = 10;
        $keyword = $request->get('keyword');
        $data = Pegawai::with('pekerjaan')->when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhereHas('pekerjaan', function ($q) use ($keyword) {
                      $q->where('nama', 'like', "%{$keyword}%");
                  });
        })->paginate($pagination);
        return view('pegawai.index', compact('data'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add() 
    {
        $pekerjaan = Pekerjaan::all();
        return view('pegawai.add', compact('pekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'email' => 'required|email|unique:pegawai,email',
            'gender' => 'required|in:male,female',
        ]);


        $data = new Pegawai();
        $data->nama = $request->nama;
        $data->pekerjaan_id = $request->pekerjaan_id;
        $data->email = $request->email;
        $data->gender = $request->gender;

        if ($data->save()) {
            return redirect()->route('pegawai.index')->with('berhasil', 'Data tersimpan');
        } else {
            return redirect()->route('pegawai.index')->with('gagal', 'Data tidak tersimpan');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Pegawai::findOrFail($id);
        $pekerjaan = Pekerjaan::all();

        return view('pegawai.edit', compact('data', 'pekerjaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'email' => 'required|email|unique:pegawai,email,' . $request->id,
            'gender' => 'required|in:male,female',
        ]);


        $data = Pegawai::findOrFail($request->id);
        $data->nama = $request->nama;
        $data->pekerjaan_id = $request->pekerjaan_id;
        $data->email = $request->email;
        $data->gender = $request->gender;

        if ($data->save()) {
            return redirect()->route('pegawai.index')->with('berhasil', 'Data tersimpan');
        } else {
            return redirect()->route('pegawai.index')->with('gagal', 'Data tidak tersimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Pegawai::findOrFail($request->id)->delete();
        return redirect()->route('pegawai.index')->with('delete', 'Data terhapus');
    }
}
