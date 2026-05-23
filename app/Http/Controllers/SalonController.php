<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SalonController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $salones = Salon::withTrashed()
            ->when($search, function($query) use ($search) {
                return $query->where('nombre', 'LIKE', "%{$search}%")
                             ->orWhere('direccion', 'LIKE', "%{$search}%");
            })
            ->orderByRaw('deleted_at IS NOT NULL ASC')
            ->orderBy('nombre')
            ->paginate(5)
            ->withQueryString();
        return view('pages.admin.salones.index', compact('salones'));
    }

    public function reportPdf(Request $request)
    {
        $search = $request->get('search');
        $salones = Salon::withTrashed()
            ->when($search, function($query) use ($search) {
                return $query->where('nombre', 'LIKE', "%{$search}%");
            })
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('pages.admin.salones.reporte', compact('salones'));
        return $pdf->download('reporte-salones.pdf');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
            'estado' => 'boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('salones', 'public');
        }

        Salon::create($data);

        return redirect()->route('salones.index')->with('success', 'Salón creado con éxito.');
    }

    public function update(Request $request, Salon $salone)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
            'estado' => 'boolean',
        ]);

        if ($request->hasFile('imagen')) {
            if ($salone->imagen) {
                Storage::disk('public')->delete($salone->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('salones', 'public');
        }

        $salone->update($data);

        return redirect()->route('salones.index')->with('success', 'Salón actualizado con éxito.');
    }

    public function destroy(Salon $salone)
    {
        $salone->delete();
        return redirect()->route('salones.index')->with('success', 'Salón eliminado con éxito.');
    }

    public function toggleStatus(Salon $salon)
    {
        $salon->update([
            'estado' => !$salon->estado
        ]);

        return back()->with('success', 'Estado del salón actualizado.');
    }
}
