<?php

namespace App\Http\Controllers;

use App\Models\EventoFestivo;
use App\Models\Categoria;
use App\Models\Salon;
use App\Models\EventoFoto;
use App\Http\Requests\StoreEventoFestivoRequest;
use App\Http\Requests\UpdateEventoFestivoRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EventoFestivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $eventos = EventoFestivo::with(['categoria', 'salon', 'fotos'])
            ->when($search, function($query) use ($search) {
                return $query->where('titulo', 'LIKE', "%{$search}%")
                             ->orWhereHas('categoria', function($q) use ($search) {
                                 $q->where('nombre', 'LIKE', "%{$search}%");
                             })
                             ->orWhereHas('salon', function($q) use ($search) {
                                 $q->where('nombre', 'LIKE', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();
            
        $categorias = Categoria::where('estado', true)->get();
        $salones = Salon::where('estado', true)->get();
        
        return view('pages.admin.eventos.index', compact('eventos', 'categorias', 'salones'));
    }

    /**
     * Generate PDF report.
     */
    public function reportPdf(Request $request)
    {
        $search = $request->get('search');
        $eventos = EventoFestivo::with(['categoria', 'salon'])
            ->when($search, function($query) use ($search) {
                return $query->where('titulo', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pages.admin.eventos.reporte', compact('eventos'));
        return $pdf->download('reporte-eventos.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoFestivoRequest $request)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['titulo']) . '-' . rand(100, 999);
        }

        if ($request->hasFile('imagen_representativa')) {
            $data['imagen_representativa'] = $request->file('imagen_representativa')->store('eventos', 'public');
        }

        $data['user_id'] = auth()->id();

        $evento = EventoFestivo::create($data);

        // Handle up to 5 photos
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('eventos/fotos', 'public');
                EventoFoto::create([
                    'evento_festivo_id' => $evento->id,
                    'ruta' => $path
                ]);
            }
        }

        return redirect()->route('admin.eventos.index')->with('success', 'Evento festivo creado con éxito.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoFestivoRequest $request, EventoFestivo $evento)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['titulo']) . '-' . $evento->id;
        }

        if ($request->hasFile('imagen_representativa')) {
            if ($evento->imagen_representativa) {
                Storage::disk('public')->delete($evento->imagen_representativa);
            }
            $data['imagen_representativa'] = $request->file('imagen_representativa')->store('eventos', 'public');
        }

        $evento->update($data);

        // Handle up to 5 photos (could be an add-only or replace logic, let's do add up to total 5)
        if ($request->hasFile('fotos')) {
            $currentCount = $evento->fotos()->count();
            foreach ($request->file('fotos') as $foto) {
                if ($currentCount >= 5) break;
                $path = $foto->store('eventos/fotos', 'public');
                EventoFoto::create([
                    'evento_festivo_id' => $evento->id,
                    'ruta' => $path
                ]);
                $currentCount++;
            }
        }

        return redirect()->route('admin.eventos.index')->with('success', 'Evento festivo actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventoFestivo $evento)
    {
        if ($evento->fecha_evento < now()) {
            return redirect()->route('admin.eventos.index')->with('error', 'No se puede eliminar un evento que ya ha sucedido (consolidado).');
        }

        $evento->delete();
        return redirect()->route('admin.eventos.index')->with('success', 'Evento festivo eliminado con éxito.');
    }

    /**
     * Toggle the status of the event.
     */
    public function toggleStatus(EventoFestivo $evento)
    {
        $evento->update([
            'estado' => !$evento->estado
        ]);

        return back()->with('success', 'Estado del evento actualizado.');
    }

    /**
     * Remove a specific photo from the event.
     */
    public function deletePhoto(EventoFoto $foto)
    {
        $eventoId = $foto->evento_festivo_id;
        
        if ($foto->ruta) {
            Storage::disk('public')->delete($foto->ruta);
        }
        
        $foto->delete();

        return back()->with('success', 'Foto eliminada con éxito.');
    }
}
