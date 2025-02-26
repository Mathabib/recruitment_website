<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
   
    public function index(Request $request)
    {
        // return view('education.index', ['education' =>Education::all()]);

        $query =Education::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name_education', 'like', '%' . $search . '%');
        }

        $education = $query->get();

        return view('education.index', compact('education')); // Memperbaiki nama variabel
    }




    public function create()
    {
        
        // Tampilkan form untuk membuat departemen baru
        return view('education.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name_education' => 'required|string|max:255',
        ]);

        // Simpan data ke database
       Education::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('education.index')->with('success', 'education created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(education $education)
    {
        // Tampilkan form untuk mengedit departemen
        return view('education.edit', compact('education'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Education $education)
    {
        // Validasi data
        $request->validate([
            'name_education' => 'required|string|max:255',
        ]);

        // Update data di database
        $education->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('education.index')->with('success', 'education updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        //Menghapus education
        $education = Education::find($id);

        if ($education) $education->delete();
        return redirect()->route('education.index')->with('success_message', 'Berhasil menghapus education');
    }
}


