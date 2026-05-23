<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Eventos</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; color: #333; }
    </style>
</head>
<body>
    <h2>Reporte de Eventos Festivos - Sistema de Eventos</h2>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Salón</th>
                <th>Fecha Evento</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventos as $evento)
                <tr>
                    <td>{{ $evento->titulo }}</td>
                    <td>{{ $evento->categoria->nombre ?? 'N/A' }}</td>
                    <td>{{ $evento->salon->nombre ?? 'N/A' }}</td>
                    <td>{{ $evento->fecha_evento ? $evento->fecha_evento->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $evento->estado ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>