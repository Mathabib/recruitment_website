<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        // return view('jurusan.index', ['jurusan' =>jurusan::all()]);

        $query =Jurusan::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name_jurusan', 'like', '%' . $search . '%');
        }

        $jurusan = $query->get();

        return view('jurusan.index', compact('jurusan')); // Memperbaiki nama variabel
    }

    public function showEducationMajor($id)
    {
        $educationFilter = Education::with('jurusan')->where('id', $id)->first();
        $jurusanFilter = $educationFilter->jurusan;
        // return response()->json($jurusan);
        return view('jurusan.index', compact('jurusanFilter', 'educationFilter'));
       
    }

    public function educationMajorCreate($id)
    {
        $educationFilter = Education::findOrFail($id);

        return view('jurusan.create', compact('educationFilter'));
    }


    public function create()
    {
        $education = Education::all();
        // Tampilkan form untuk membuat jurusan baru
        return view('jurusan.create', compact('education'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name_jurusan' => 'required|string|max:255',
            'education_id' => 'required|exists:education,id', // Pastikan education_id valid
        ]);

        // Simpan data ke database
        // Jurusan::create($request->all());
        Jurusan::create([
            'name_jurusan' => $request->name_jurusan,
            'education_id' => $request->education_id,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        if($request->education_id_page){
            return redirect()->route('showEducationMajor', $request->education_id)->with('success', 'Jurusan created successfully.');    
        }
        return redirect()->route('jurusan.index')->with('success', 'Jurusan created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $education = Education::all();
        return view('jurusan.edit', compact('jurusan', 'education'));
    }

    // Method untuk menyimpan hasil edit
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name_jurusan' => 'required|string|max:255',
            'education_id' => 'required|exists:education,id', // Pastikan education_id valid
        ]);

        // Cari jurusan berdasarkan ID
        $jurusan = Jurusan::findOrFail($id);

        // Update data
        $jurusan->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jurusan.index')->with('success', 'Jurusan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        //Menghapus jurusan
        $jurusan = jurusan::find($id);

        if ($jurusan) $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success_message', 'Berhasil menghapus jurusan');
    }
}
