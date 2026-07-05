<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Trazabilidad — Agroindustrias AIB</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #222;
            padding: 20px;
            background: #fff;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #b8880f;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .header p {
            color: #666;
            margin-top: 2px;
        }

        .stats {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 16px;
            text-align: center;
            flex: 1;
            background: #fafafa;
        }

        .stat-box .val {
            font-size: 20px;
            font-weight: bold;
            color: #b8880f;
        }

        .stat-box .lbl {
            font-size: 9px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #1c2a18;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 7px 10px;
            border-bottom: 1px solid #eee;
            font-size: 10px;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-ok {
            background: #dcfce7;
            color: #166534;
        }

        .badge-proc {
            background: #fef9c3;
            color: #854d0e;
        }

        .etapas-tl {
            margin-top: 4px;
        }

        .etapas-tl span {
            display: inline-block;
            font-size: 9px;
            color: #666;
            margin-right: 4px;
        }

        .etapas-tl span::after {
            content: ' ›';
            color: #ccc;
        }

        .etapas-tl span:last-child::after {
            content: '';
        }

        .footer {
            text-align: center;
            color: #999;
            font-size: 9px;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .no-print {
            margin-bottom: 20px;
            text-align: center;
        }

        .no-print button {
            background: #b8880f;
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin: 0 8px;
        }

        .no-print button:hover {
            background: #9a720d;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                padding: 10px;
            }

            @page {
                margin: 10mm;
                size: A4 landscape;
            }
        }
    </style>
</head>

<body>

    <!-- Botones (no se imprimen) -->
    <div class="no-print">
        <button onclick="window.print()"><i class="fas fa-print"></i> Imprimir / Guardar como PDF</button>
    </div>

    <!-- Encabezado -->
    <div class="header">
        <h1>Agroindustrias AIB — Sede Ica</h1>
        <p>Reporte de Trazabilidad de Productos Agroindustriales</p>
        <p>Generado el: {{ $stats['fecha_reporte'] }}</p>
    </div>

    <!-- Estadisticas -->
    <div class="stats">
        <div class="stat-box">
            <div class="val">{{ $stats['total_lotes'] }}</div>
            <div class="lbl">Total Lotes</div>
        </div>
        <div class="stat-box">
            <div class="val">{{ number_format($stats['total_kg'], 0) }} kg</div>
            <div class="lbl">Volumen Total</div>
        </div>
        <div class="stat-box">
            <div class="val">{{ $stats['completados'] }}</div>
            <div class="lbl">Completados</div>
        </div>
        <div class="stat-box">
            <div class="val">{{ $stats['en_proceso'] }}</div>
            <div class="lbl">En Proceso</div>
        </div>
    </div>

    <!-- Tabla principal -->
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Variedad</th>
                <th>Cantidad</th>
                <th>Etapa</th>
                <th>Estado</th>
                <th>Proveedor</th>
                <th>Registro</th>
                <th>Etapas Completadas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lotes as $l)
                <tr>
                    <td><strong>{{ $l->codigo }}</strong></td>
                    <td>{{ $l->producto }}</td>
                    <td>{{ $l->variedad }}</td>
                    <td>{{ number_format($l->cantidad_kg, 0) }} kg</td>
                    <td>{{ $l->etapa_actual }}</td>
                    <td>
                        @if ($l->estado === 'Completado')
                            <span class="badge badge-ok">Completado</span>
                        @else
                            <span class="badge badge-proc">En Proceso</span>
                        @endif
                    </td>
                    <td>{{ $l->proveedor }}</td>
                    <td>{{ $l->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="etapas-tl">
                            @foreach ($l->trazabilidad as $t)
                                <span>{{ $t->etapa }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Detalle por lote -->
    @foreach ($lotes as $l)
        <div style="margin-top:20px;page-break-inside:avoid;">
            <table>
                <thead>
                    <tr>
                        <th colspan="4" style="background:#243521;font-size:11px;">
                            {{ $l->codigo }} — {{ $l->producto }} {{ $l->variedad }} —
                            {{ number_format($l->cantidad_kg, 0) }} kg — {{ $l->proveedor }}
                        </th>
                    </tr>
                    <tr>
                        <th style="width:20%;">Etapa</th>
                        <th style="width:15%;">Fecha</th>
                        <th>Observaciones</th>
                        <th style="width:18%;">Responsable</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($l->trazabilidad as $t)
                        <tr>
                            <td><strong>{{ $t->etapa }}</strong></td>
                            <td>{{ $t->fecha->format('d/m/Y') }}</td>
                            <td>{{ $t->observaciones }}</td>
                            <td>{{ $t->responsable->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <!-- Pie -->
    <div class="footer">
        <p><strong>Agroindustrias AIB</strong> — Sede Ica, Peru</p>
        <p>Sistema de Trazabilidad Digital — Universidad Privada San Juan Bautista</p>
        <p>Documento generado automaticamente. No requiere firma.</p>
    </div>

    <script>
        // Auto-imprimir al cargar (comenta esta linea si no quieres que se imprima automaticamente)
        // window.onload = function() { window.print(); };
    </script>

</body>

</html>
