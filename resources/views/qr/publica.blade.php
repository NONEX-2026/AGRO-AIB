<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lote->codigo }} — Trazabilidad AIB</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;900&family=Playfair+Display:wght@700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f4ee;
            color: #1a2e18;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #1c2a18, #243521, #1c2a18);
            padding: 0;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(212, 160, 23, 0.03) 60px, rgba(212, 160, 23, 0.03) 61px);
        }

        .header-inner {
            max-width: 700px;
            margin: 0 auto;
            padding: 30px 24px 24px;
            position: relative;
            z-index: 1;
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .logo-box {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #d4a017, #b8880f);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            color: #1c2a18;
            flex-shrink: 0;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            color: #fff;
            font-weight: 900;
            line-height: 1.2;
        }

        .header .sub {
            font-size: 12px;
            color: #a3b89e;
            margin-top: 2px;
        }

        .lote-code-bar {
            background: rgba(212, 160, 23, 0.15);
            border: 1px solid rgba(212, 160, 23, 0.3);
            border-radius: 12px;
            padding: 14px 20px;
            text-align: center;
        }

        .lote-code-bar .label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #a3b89e;
            font-weight: 600;
        }

        .lote-code-bar .code {
            font-size: 28px;
            font-weight: 900;
            color: #d4a017;
            font-family: 'Playfair Display', serif;
            margin-top: 2px;
        }

        .content {
            max-width: 700px;
            margin: 0 auto;
            padding: 24px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #e0e8de;
        }

        .card-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6b8264;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title i {
            color: #d4a017;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .info-item .lbl {
            font-size: 11px;
            color: #6b8264;
            font-weight: 600;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item .val {
            font-size: 15px;
            font-weight: 700;
            color: #1a2e18;
        }

        .progress-track {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            padding: 0 10px;
            margin: 8px 0;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 30px;
            right: 30px;
            height: 4px;
            background: #e0e8de;
            border-radius: 2px;
            transform: translateY(-50%);
            z-index: 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4ade80, #38bdf8, #d4a017);
            border-radius: 2px;
            transition: width 0.5s;
        }

        .step {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            border: 3px solid #d0d8ce;
            background: #fff;
            color: #a3b89e;
        }

        .step.completed .step-dot {
            border-color: #4ade80;
            background: #4ade80;
            color: #fff;
        }

        .step.current .step-dot {
            border-color: #d4a017;
            background: #d4a017;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(212, 160, 23, 0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 4px rgba(212, 160, 23, 0.2);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(212, 160, 23, 0.1);
            }
        }

        .step-label {
            font-size: 10px;
            color: #6b8264;
            font-weight: 600;
            text-align: center;
            line-height: 1.2;
        }

        .step.completed .step-label {
            color: #2d6a2e;
        }

        .step.current .step-label {
            color: #b8880f;
            font-weight: 700;
        }

        .timeline {
            position: relative;
            padding-left: 28px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 4px;
            bottom: 4px;
            width: 2px;
            background: linear-gradient(to bottom, #4ade80, #38bdf8, #d4a017, #a78bfa, #f472b6, #fb923c);
            border-radius: 1px;
        }

        .tl-item {
            position: relative;
            margin-bottom: 20px;
        }

        .tl-item:last-child {
            margin-bottom: 0;
        }

        .tl-dot {
            position: absolute;
            left: -23px;
            top: 3px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2.5px solid;
            background: #fff;
            z-index: 1;
        }

        .tl-item:nth-child(1) .tl-dot {
            border-color: #4ade80;
        }

        .tl-item:nth-child(2) .tl-dot {
            border-color: #38bdf8;
        }

        .tl-item:nth-child(3) .tl-dot {
            border-color: #d4a017;
        }

        .tl-item:nth-child(4) .tl-dot {
            border-color: #a78bfa;
        }

        .tl-item:nth-child(5) .tl-dot {
            border-color: #f472b6;
        }

        .tl-item:nth-child(6) .tl-dot {
            border-color: #fb923c;
        }

        .tl-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 2px;
        }

        .tl-etapa {
            font-size: 14px;
            font-weight: 700;
            color: #1a2e18;
        }

        .tl-fecha {
            font-size: 11px;
            color: #6b8264;
        }

        .tl-obs {
            font-size: 13px;
            color: #4a5e46;
            line-height: 1.4;
        }

        .tl-resp {
            font-size: 11px;
            color: #8a9e86;
            margin-top: 3px;
        }

        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .estado-badge.completado {
            background: #dcfce7;
            color: #166534;
        }

        .estado-badge.proceso {
            background: #fef9c3;
            color: #854d0e;
        }

        .footer {
            text-align: center;
            padding: 24px;
            font-size: 11px;
            color: #8a9e86;
            border-top: 1px solid #e0e8de;
            margin-top: 8px;
        }

        .footer strong {
            color: #d4a017;
        }

        @media(max-width:500px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .step-label {
                font-size: 8px;
            }

            .step-dot {
                width: 26px;
                height: 26px;
                font-size: 10px;
            }

            .lote-code-bar .code {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-inner">
            <div class="header-top">
                <div class="logo-box">AIB</div>
                <div>
                    <h1>Agroindustrias AIB</h1>
                    <div class="sub">Trazabilidad de Producto — Sede Ica, Peru</div>
                </div>
            </div>
            <div class="lote-code-bar">
                <div class="label">Codigo de Lote</div>
                <div class="code">{{ $lote->codigo }}</div>
            </div>
        </div>
    </div>
    <div class="content">
        <div style="text-align:center;margin-bottom:20px;">
            @if ($lote->estado === 'Completado')
                <span class="estado-badge completado"><i class="fas fa-check-circle"></i> Trazabilidad Completada</span>
            @else
                <span class="estado-badge proceso"><i class="fas fa-clock"></i> En Proceso —
                    {{ $lote->etapa_actual }}</span>
            @endif
        </div>
        <div class="card">
            <div class="card-title"><i class="fas fa-box-open"></i> Informacion del Producto</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="lbl">Producto</div>
                    <div class="val">{{ $lote->producto }}</div>
                </div>
                <div class="info-item">
                    <div class="lbl">Variedad</div>
                    <div class="val">{{ $lote->variedad }}</div>
                </div>
                <div class="info-item">
                    <div class="lbl">Cantidad</div>
                    <div class="val">{{ number_format($lote->cantidad_kg, 0) }} kg</div>
                </div>
                <div class="info-item">
                    <div class="lbl">Proveedor</div>
                    <div class="val">{{ $lote->proveedor }}</div>
                </div>
                <div class="info-item">
                    <div class="lbl">Fecha de Registro</div>
                    <div class="val">{{ $lote->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="lbl">Dias en Proceso</div>
                    <div class="val">{{ $lote->diasEnProceso() }} dias</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-title"><i class="fas fa-shoe-prints"></i> Progreso de Trazabilidad</div>
            <div class="progress-track">
                <div class="progress-line">
                    <div class="progress-fill"
                        style="width:{{ $indiceActual >= 0 ? ($indiceActual / (count($etapas) - 1)) * 100 : 0 }}%;">
                    </div>
                </div>
                @foreach ($etapas as $i => $etapa)
                    <div class="step {{ $i < $indiceActual ? 'completed' : ($i === $indiceActual ? 'current' : '') }}">
                        <div class="step-dot">
                            @if ($i < $indiceActual)
                                <i class="fas fa-check"></i>@else{{ $i + 1 }}
                            @endif
                        </div>
                        <div class="step-label">{{ $etapa }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="card-title"><i class="fas fa-clipboard-list"></i> Historial de Trazabilidad</div>
            <div class="timeline">
                @foreach ($lote->trazabilidad as $t)
                    <div class="tl-item">
                        <div class="tl-dot"></div>
                        <div class="tl-header">
                            <span class="tl-etapa">{{ $t->etapa }}</span>
                            <span class="tl-fecha">{{ $t->fecha->format('d/m/Y') }}</span>
                        </div>
                        <div class="tl-obs">{{ $t->observaciones }}</div>
                        <div class="tl-resp"><i class="fas fa-user"></i> {{ $t->responsable->nombre }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="footer">
        <strong>Agroindustrias AIB</strong> — Sede Ica, Peru<br>
        Sistema de Trazabilidad Digital<br>
        <span style="color:#b0beb0;">Documento verificado electronicamente</span>
    </div>
</body>

</html>
