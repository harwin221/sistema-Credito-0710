<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartera Vencida Histórica - CrediNica</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free-6.4.0-web/css/all.min.css') }}" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #1a1a2e; background: #f0f2f5; padding: 20px; }
        .report-wrapper { max-width: 1400px; margin: 0 auto; background: #fff; border: 1px solid #d0d5dd; }
        /* ─── ENCABEZADO CORPORATIVO ─── */
        .report-header {
            position: relative;
            text-align: center;
            padding: 18px 150px;
            min-height: 118px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-bottom: 3px solid #1f9cb5;
        }
        .report-header img.logo {
            position: absolute;
            left: 32px;
            top: 50%;
            transform: translateY(-50%);
            height: 96px;
            width: auto;
            display: block;
        }
        .report-header .report-title  { font-size: 19px; font-weight: 700; color: #1a1a2e; margin-top: 2px; text-transform: uppercase; letter-spacing: 1px; }
        .report-header .report-meta   { font-size: 11px; color: #718096; margin-top: 8px; padding-top: 8px; border-top: 1px solid #e2e8f0; width: 100%; }
        .filters-bar { display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 8px 24px; background: #f7f8fa; padding: 11px 40px; border-bottom: 1px solid #e2e8f0; font-size: 11px; color: #4a5568; text-align: center; }
        .action-bar  { padding: 10px 20px; border-bottom: 1px solid #e2e8f0; display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-action  { padding: 6px 16px; font-size: 12px; font-weight: 600; border-radius: 20px; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-back  { background: #e2e8f0; color: #4a5568; }
        .btn-excel { background: #1a7a4a; color: #fff; }
        .btn-print { background: #2b6cb0; color: #fff; }
        /* Seccion por vendedor */
        .vendor-header { background: #1f9cb5; color: #fff; padding: 9px 16px; display: flex; justify-content: space-between; align-items: center; }
        .vendor-header .vendor-name    { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .vendor-header .vendor-resumen { font-size: 11px; opacity: 0.95; }
        /* Tabla */
        .report-table { width: 100%; border-collapse: collapse; }
        .report-table thead tr { background: #f0f2f5; color: #4a5568; }
        .report-table thead th { padding: 8px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; border: none; border-bottom: 1px solid #cbd5e0; text-align: center; white-space: nowrap; }
        .report-table tbody td { padding: 7px 8px; font-size: 11px; border: none; border-bottom: 1px solid #edf2f7; vertical-align: middle; color: #2d3748; }
        .report-table tbody tr:nth-child(even) { background: #fafbfc; }
        .num    { text-align: right; font-family: 'Courier New', monospace; font-weight: 600; }
        .center { text-align: center; }
        .dias-a { color: #1d4ed8; font-weight: 700; }
        .dias-b { color: #15803d; font-weight: 700; }
        .dias-c { color: #b45309; font-weight: 700; }
        .dias-d { color: #c2410c; font-weight: 700; }
        .dias-e { color: #b91c1c; font-weight: 700; }
        .subtotal-row td { background: #f0f2f5; font-weight: 700; font-size: 11px; border-top: 2px solid #1f9cb5; color: #1a1a2e; }
        /* ─── BLOQUE TOTAL GENERAL ─── */
        .grand-total-block { margin: 24px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .grand-total-block .gt-title { text-align: center; font-size: 13px; font-weight: 700; color: #1a1a2e; padding: 12px; border-bottom: 1px solid #e2e8f0; background: #f8fafc; letter-spacing: 0.5px; }
        .grand-total-block .gt-grid { display: flex; justify-content: center; flex-wrap: wrap; padding: 16px 24px; background: #fff; }
        .grand-total-block .gt-item { text-align: center; padding: 8px 28px; border-right: 1px solid #e2e8f0; }
        .grand-total-block .gt-item:last-child { border-right: none; }
        .grand-total-block .gt-label { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .grand-total-block .gt-value { font-size: 15px; font-weight: 700; color: #1f9cb5; font-family: 'Segoe UI', Arial, sans-serif; }
        .grand-total-block .gt-value.dark { color: #1a1a2e; }
        .badge-reasignado { font-size: 9px; background: #fff0f0; color: #b91c1c; border: 1px solid #fca5a5; padding: 1px 6px; border-radius: 2px; font-weight: 700; text-transform: uppercase; }
        .report-footer { text-align: center; padding: 10px; font-size: 10px; color: #a0aec0; border-top: 1px solid #e2e8f0; }
        @media print { body { background: #fff; padding: 0; } .action-bar { display: none !important; } }
    </style>
</head>
<body>
<div class="report-wrapper">

    <div class="report-header">
        <img class="logo" src="{{ asset('assets/img/LogoCrediNica.png') }}" alt="CrediNica">
        <div class="report-title">Reporte de Cartera Vencida Histórica</div>
        <div class="report-meta">
            Generado: {{ now()->format('d/m/Y H:i') }}
            &nbsp;|&nbsp; Período:
            <strong>{{ $desde ? \Carbon\Carbon::parse($desde)->format('d/m/Y') : '—' }}</strong>
            al
            <strong>{{ $hasta ? \Carbon\Carbon::parse($hasta)->format('d/m/Y') : now()->format('d/m/Y') }}</strong>
            &nbsp;|&nbsp; Total créditos: <strong>{{ $totales['cantidad'] }}</strong>
        </div>
    </div>

    <div class="action-bar">
        <a href="{{ route('reportes.carteraVencidaHistorica.index') }}" class="btn-action btn-back">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <a href="{{ request()->fullUrlWithQuery(['excel' => 1]) }}" class="btn-action btn-excel">
            <i class="fas fa-file-excel"></i> Exportar Excel
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            <i class="fas fa-print"></i> Imprimir
        </button>
    </div>

    @forelse($agrupado as $vendedorNombre => $creditos)
        @php
            $subMonto  = $creditos->sum('monto_colocado');
            $subInicio = $creditos->sum('saldo_inicio');
            $subCobro  = $creditos->sum('cobro_periodo');
            $subFinal  = $creditos->sum('saldo_final');
        @endphp

        <div style="border-bottom: 2px solid #1f9cb5;">
            <div class="vendor-header">
                <span class="vendor-name">
                    <i class="fas fa-user-tie"></i> {{ $vendedorNombre ?: 'Sin vendedor' }}
                </span>
                <span class="vendor-resumen">
                    {{ $creditos->count() }} crédito(s) &nbsp;|&nbsp;
                    Saldo inicio: C$ {{ number_format($subInicio,2) }} &nbsp;|&nbsp;
                    Cobrado: C$ {{ number_format($subCobro,2) }} &nbsp;|&nbsp;
                    Saldo final: C$ {{ number_format($subFinal,2) }}
                </span>
            </div>

            <table class="report-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Crédito</th>
                        <th>Cliente</th>
                        <th>Cobrador Actual</th>
                        <th>Monto Colocado</th>
                        <th>F. Desembolso</th>
                        <th>F. Vencimiento</th>
                        <th>Días Vencido</th>
                        <th>Clasif.</th>
                        <th>Saldo Inicio</th>
                        <th>Cobro Período</th>
                        <th>Saldo Final</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($creditos as $i => $p)
                        @php
                            $dc = $p->clasificacion ?? 'E';
                            $cls = 'dias-' . strtolower($dc);
                            $reasignado = trim($p->vendedor_nombre) !== trim($p->cobrador_nombre);
                        @endphp
                        <tr>
                            <td class="center">{{ $i + 1 }}</td>
                            <td class="center">{{ $p->consecutivo }}</td>
                            <td>{{ $p->cliente_nombre }}</td>
                            <td>
                                {{ $p->cobrador_nombre }}
                                @if($reasignado)
                                    <span class="badge-reasignado">reasignado</span>
                                @endif
                            </td>
                            <td class="num">{{ $p->moneda }} {{ number_format($p->monto_colocado,2) }}</td>
                            <td class="center">{{ $p->fecha_desembolso ? \Carbon\Carbon::parse($p->fecha_desembolso)->format('d/m/Y') : 'N/A' }}</td>
                            <td class="center">{{ $p->fecha_vencimiento ? \Carbon\Carbon::parse($p->fecha_vencimiento)->format('d/m/Y') : 'N/A' }}</td>
                            <td class="center {{ $cls }}">{{ $p->dias_vencido }}</td>
                            <td class="center {{ $cls }}">{{ $dc }}</td>
                            <td class="num">{{ $p->moneda }} {{ number_format($p->saldo_inicio,2) }}</td>
                            <td class="num" style="color:#15803d;">{{ $p->moneda }} {{ number_format($p->cobro_periodo,2) }}</td>
                            <td class="num" style="color:#b91c1c;">{{ $p->moneda }} {{ number_format($p->saldo_final,2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="subtotal-row">
                        <td colspan="4" style="text-align:right;">
                            Subtotal {{ $vendedorNombre }} ({{ $creditos->count() }} créditos):
                        </td>
                        <td class="num">C$ {{ number_format($subMonto,2) }}</td>
                        <td colspan="4"></td>
                        <td class="num">C$ {{ number_format($subInicio,2) }}</td>
                        <td class="num" style="color:#15803d;">C$ {{ number_format($subCobro,2) }}</td>
                        <td class="num" style="color:#b91c1c;">C$ {{ number_format($subFinal,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @empty
        <div style="text-align:center; padding: 40px; color: #718096;">
            <i class="fas fa-folder-open" style="font-size:32px; margin-bottom:10px; display:block;"></i>
            No se encontraron créditos vencidos con los filtros aplicados.
        </div>
    @endforelse

    @if($agrupado->isNotEmpty())
    <div class="grand-total-block">
        <div class="gt-title">Totales Generales &mdash; {{ $totales['cantidad'] }} crédito{{ $totales['cantidad'] != 1 ? 's' : '' }}</div>
        <div class="gt-grid">
            <div class="gt-item">
                <div class="gt-label">Monto Colocado</div>
                <div class="gt-value dark">C$ {{ number_format($totales['monto_colocado'],2) }}</div>
            </div>
            <div class="gt-item">
                <div class="gt-label">Saldo Inicio</div>
                <div class="gt-value dark">C$ {{ number_format($totales['saldo_inicio'],2) }}</div>
            </div>
            <div class="gt-item">
                <div class="gt-label">Cobro Período</div>
                <div class="gt-value" style="color:#15803d;">C$ {{ number_format($totales['cobro_periodo'],2) }}</div>
            </div>
            <div class="gt-item">
                <div class="gt-label">Saldo Final</div>
                <div class="gt-value" style="color:#b91c1c;">C$ {{ number_format($totales['saldo_final'],2) }}</div>
            </div>
        </div>
    </div>
    @endif

    <div class="report-footer">
        CrediNica &mdash; Reporte generado el {{ now()->format('d/m/Y \a \l\a\s H:i') }} &mdash; Confidencial
    </div>
</div>
</body>
</html>
