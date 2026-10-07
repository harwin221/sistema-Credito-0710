<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Colocación vs Recuperación - CrediNica</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free-6.4.0-web/css/all.min.css') }}" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            background: #f0f2f5;
            padding: 24px;
        }
        .report-wrapper {
            max-width: 1050px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #d0d5dd;
            border-radius: 4px;
            overflow: hidden;
        }
        .report-header {
            position: relative;
            text-align: center;
            padding: 18px 150px;
            min-height: 118px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-bottom: 3px double #1a1a2e;
        }
        .report-header img {
            position: absolute;
            left: 32px;
            top: 50%;
            transform: translateY(-50%);
            height: 96px;
            width: auto;
            display: block;
        }
        .report-header h1 {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .report-header p {
            font-size: 11px;
            color: #555;
            margin-top: 4px;
        }
        .report-body { padding: 24px 32px; }

        /* ─── TABLA ────────────────────────────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-size: 12px;
        }
        .data-table th {
            background: #f0f2f5;
            color: #4a5568;
            padding: 8px 10px;
            font-weight: 700;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1px solid #cbd5e0;
            white-space: nowrap;
        }
        .data-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
            color: #2d3748;
            font-size: 11px;
        }
        .data-table tbody tr:nth-child(even) { background: #fafbfc; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .num { font-family: 'Courier New', monospace; font-size: 11px; }
        .bold { font-weight: 700; }
        .num-green { color: #15803d; }
        .num-red   { color: #b91c1c; }

        /* ─── BLOQUE TOTAL GENERAL ─── */
        .grand-total-block { margin-top: 24px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .grand-total-block .gt-title { text-align: center; font-size: 13px; font-weight: 700; color: #1a1a2e; padding: 12px; border-bottom: 1px solid #e2e8f0; background: #f8fafc; letter-spacing: 0.5px; }
        .grand-total-block .gt-grid { display: flex; justify-content: center; flex-wrap: wrap; padding: 16px 24px; background: #fff; }
        .grand-total-block .gt-item { text-align: center; padding: 8px 28px; border-right: 1px solid #e2e8f0; }
        .grand-total-block .gt-item:last-child { border-right: none; }
        .grand-total-block .gt-label { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .grand-total-block .gt-value { font-size: 15px; font-weight: 700; color: #1f9cb5; font-family: 'Segoe UI', Arial, sans-serif; }
        .grand-total-block .gt-value.dark { color: #1a1a2e; }

        /* ─── CAJA RESUMEN ───────────────────────────────── */
        .summary-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 24px;
        }
        .summary-box-header {
            background: #1f9cb5;
            color: #fff;
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }
        .summary-box-body {
            display: flex;
            gap: 0;
            background: #f8f9fb;
        }
        .summary-item {
            flex: 1;
            text-align: center;
            padding: 18px 12px;
            border-right: 1px solid #e0e0e0;
        }
        .summary-item:last-child { border-right: none; }
        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            margin-bottom: 4px;
        }
        .summary-value {
            font-size: 16px;
            font-weight: 800;
            font-family: 'Courier New', monospace;
        }

        .rpt-footer {
            text-align: center;
            font-size: 10px;
            color: #999;
            padding: 14px;
            margin-top: 24px;
            border-top: 1px solid #eee;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .report-wrapper { border: none; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <!-- Botón imprimir (no se imprime) -->
    <div class="no-print" style="max-width:1050px; margin:0 auto 12px; text-align:right;">
        <button onclick="window.print()" class="btn btn-sm btn-dark">
            <i class="fas fa-print me-1"></i> Imprimir
        </button>
    </div>

    <div class="report-wrapper">
        <div class="report-header">
            <img src="{{ asset('assets/img/LogoCrediNica.png') }}" alt="CrediNica">
            <h1>Reporte Colocación vs Recuperación</h1>
            <p>Desde {{ fecha_d_m_Y($desde) }} hasta {{ fecha_d_m_Y($hasta) }}</p>
        </div>

        <div class="report-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre del Gestor</th>
                        <th class="text-right">Colocación</th>
                        <th class="text-right">Recuperación</th>
                        <th class="text-right">Diferencia</th>
                        <th class="text-center">Rango Fecha</th>
                        <th class="text-center">Desembolsos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resultado as $fila)
                        @php $dif = $fila['diferencia']; @endphp
                        <tr>
                            <td class="bold">{{ $fila['agente_nombre'] }}</td>
                            <td class="text-right num">C$ {{ number_format($fila['colocacion'], 2) }}</td>
                            <td class="text-right num">C$ {{ number_format($fila['recuperacion'], 2) }}</td>
                            <td class="text-right num {{ $dif >= 0 ? 'num-green' : 'num-red' }} bold">
                                C$ {{ number_format($dif, 2) }}
                            </td>
                            <td class="text-center">{{ fecha_d_m_Y($desde) }} – {{ fecha_d_m_Y($hasta) }}</td>
                            <td class="text-center bold">{{ $fila['num_desembolsos'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding:30px; color:#718096;">
                                No se encontraron datos para el rango seleccionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($resultado) > 0)
                <tfoot>
                    <tr class="row-subtotal">
                        <td colspan="6" class="text-right">SUBTOTAL &mdash; {{ $totales['num_desembolsos'] }} desembolso{{ $totales['num_desembolsos'] != 1 ? 's' : '' }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>

            @if(count($resultado) > 0)
            {{-- CAJA RESUMEN --}}
            <div class="summary-box">
                <div class="summary-box-header">
                    <i class="fas fa-chart-bar me-2"></i> Montos Totales
                </div>
                <div class="summary-box-body">
                    <div class="summary-item">
                        <div class="summary-label">Total Colocación</div>
                        <div class="summary-value" style="color:#1a56db;">C$ {{ number_format($totales['colocacion'], 2) }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Total Recuperación</div>
                        <div class="summary-value" style="color:#1e7e34;">C$ {{ number_format($totales['recuperacion'], 2) }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Total Diferencia</div>
                        <div class="summary-value" style="color:{{ $totales['diferencia'] >= 0 ? '#166534' : '#991b1b' }};">
                            C$ {{ number_format($totales['diferencia'], 2) }}
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Total Desembolsos</div>
                        <div class="summary-value" style="color:#1a1a2e;">{{ $totales['num_desembolsos'] }}</div>
                    </div>
                </div>
            </div>
            @endif

            <div class="rpt-footer">
                Documento generado por CrediNica &mdash; {{ date('d/m/Y h:i A') }} &mdash; Uso interno exclusivo
            </div>
        </div>
    </div>
</body>
</html>
