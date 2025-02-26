<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{

    public function index(Request $request)
    {
        // return view('department.index', ['departements' => Departement::all()]);

        $query = Departement::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('dep_name', 'like', '%' . $search . '%');
        }

        $departements = $query->get();

        return view('department.index', compact('departements')); // Memperbaiki nama variabel
    }




    public function create()
    {
        // Tampilkan form untuk membuat departemen baru
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'dep_name' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        Departement::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('departements.index')->with('success', 'Departement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departement $departement)
    {
        // Tampilkan detail dari departemen tertentu
        return view('department.show', compact('departement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement)
    {
        // Tampilkan form untuk mengedit departemen
        return view('department.edit', compact('departement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        // Validasi data
        $request->validate([
            'dep_name' => 'required|string|max:255',
        ]);

        // Update data di database
        $departement->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('departements.index')->with('success', 'Departement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        //Menghapus department
        $departement = Departement::find($id);

        if ($departement) $departement->delete();
        return redirect()->route('departements.index')->with('success_message', 'Berhasil menghapus department');
    }
}
