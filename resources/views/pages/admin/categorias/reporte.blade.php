<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Categorías</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; color: #333; }
    </style>
</head>
<body>
    <h2>Reporte de Categorías - Sistema de Eventos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Eventos</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->nombre }}</td>
                    <td>{{ $categoria->descripcion }}</td>
                    <td>{{ $categoria->eventos_festivos_count }}</td>
                    <td>{{ $categoria->trashed() ? 'Eliminado' : ($categoria->estado ? 'Activo' : 'Inactivo') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>