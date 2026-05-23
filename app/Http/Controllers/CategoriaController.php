<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $categorias = Categoria::withTrashed()
            ->withCount('eventosFestivos')
            ->when($search, function($query) use ($search) {
                return $query->where('nombre', 'LIKE', "%{$search}%")
                             ->orWhere('descripcion', 'LIKE', "%{$search}%");
            })
            ->orderByRaw('deleted_at IS NOT NULL ASC')
            ->orderBy('nombre')
            ->paginate(5)
            ->withQueryString();
            
        return view('pages.admin.categorias.index', compact('categorias'));
    }

    /**
     * Generate PDF report.
     */
    public function reportPdf(Request $request)
    {
        $search = $request->get('search');
        $categorias = Categoria::withTrashed()
            ->withCount('eventosFestivos')
            ->when($search, function($query) use ($search) {
                return $query->where('nombre', 'LIKE', "%{$search}%");
            })
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('pages.admin.categorias.reporte', compact('categorias'));
        return $pdf->download('reporte-categorias.pdf');
    }

    /**
     * Toggle the status of the category.
     */
    public function toggleStatus(Categoria $categoria)
    {
        $categoria->update([
            'estado' => !$categoria->estado
        ]);

        return back()->with('success', 'Estado de la categoría actualizado.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nombre']);
        }

        Categoria::create($data);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('pages.admin.categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('pages.admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nombre']);
        }

        $categoria->update($data);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada con éxito.');
    }
}
