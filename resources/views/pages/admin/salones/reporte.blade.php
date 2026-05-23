<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Salones</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; color: #333; }
    </style>
</head>
<body>
    <h2>Reporte de Salones / Locales - Sistema de Eventos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salones as $salon)
                <tr>
                    <td>{{ $salon->nombre }}</td>
                    <td>{{ $salon->direccion }}</td>
                    <td>{{ $salon->trashed() ? 'Eliminado' : ($salon->estado ? 'Activo' : 'Inactivo') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>