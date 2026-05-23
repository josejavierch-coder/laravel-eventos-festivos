<?php

namespace App\Http\Controllers;

use App\Models\EventoFestivo;
use App\Models\Categoria;
use App\Models\Salon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Mostrar la galería pública de eventos.
     */
    public function index(Request $request)
    {
        $query = EventoFestivo::with(['categoria', 'salon'])
            ->where('estado', true)
            ->whereHas('categoria', function($q) {
                $q->where('estado', true);
            })
            ->whereHas('salon', function($q) {
                $q->where('estado', true);
            });

        // Sidebar filters
        if ($request->has('categoria')) {
            $query->whereHas('categoria', function($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        if ($request->has('salon')) {
            $query->where('salon_id', $request->salon);
        }

        if ($request->has('search')) {
            $query->where('titulo', 'LIKE', '%' . $request->search . '%');
        }

        $eventos = $query->latest()->paginate(12)->withQueryString();
        $categorias = Categoria::where('estado', true)->get();
        $salones = Salon::where('estado', true)->get();

        if ($request->has('categoria') || $request->has('salon') || $request->has('search')) {
            return view('pages.servicios', compact('eventos', 'categorias', 'salones'));
        }

        // Landing view only shows few items that are about to happen
        $proximos_eventos = EventoFestivo::with('salon')
            ->where('estado', true)
            ->whereHas('categoria', function($q) {
                $q->where('estado', true);
            })
            ->whereHas('salon', function($q) {
                $q->where('estado', true);
            })
            ->where('fecha_evento', '>=', now())
            ->orderBy('fecha_evento', 'asc')
            ->take(9)
            ->get();
        return view('pages.index', compact('proximos_eventos', 'categorias'));
    }

    /**
     * Mostrar el detalle de un evento festivo.
     */
    public function show(string $slug)
    {
        $evento = EventoFestivo::with(['categoria', 'salon', 'fotos'])
            ->where('slug', $slug)
            ->where('estado', true)
            ->firstOrFail();

        $evento->increment('vistas');

        return view('pages.evento', compact('evento'));
    }
}
