@extends('layouts.app')

@section('title', 'Generador QR')
@section('pageTitle', 'Generador de Codigo QR')
@section('pageSubtitle', 'Selecciona un lote para generar su codigo QR profesional')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <!-- Selector -->
        <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-aib-border">
                <h3 class="text-base font-bold">Seleccionar Lote</h3>
            </div>
            <div class="p-6">
                <div class="mb-5">
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Elija un lote</label>
                    <select class="input-aib" id="qrLoteSelect" onchange="generarQR()">
                        <option value="">-- Seleccione un lote --</option>
                        @foreach ($lotes as $l)
                            <option value="{{ $l->id }}"
                                {{ isset($lote) && $lote->id === $l->id ? 'selected' : '' }}>{{ $l->codigo }} -
                                {{ $l->producto }} ({{ $l->etapa_actual }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Contenido del QR</label>
                    <pre id="qrContenido" class="input-aib text-[12px] text-aib-fg2 overflow-auto"
                        style="white-space:pre-wrap;max-height:160px;min-height:80px;">Seleccione un lote para ver el contenido del QR</pre>
                </div>

                <div
                    style="background:rgba(74,222,128,0.08);border:1px solid rgba(74,222,128,0.2);border-radius:10px;padding:12px 16px;">
                    <p style="font-size:12px;color:var(--fg2);line-height:1.5;">
                        <i class="fas fa-check-circle" style="color:#4ade80;margin-right:6px;"></i>
                        Al escanear este QR se muestra la informacion del producto. Funciona sin conexion a internet.
                    </p>
                </div>
            </div>
        </div>

        <!-- QR -->
        <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-aib-border flex items-center justify-between">
                <h3 class="text-base font-bold">Codigo QR Profesional</h3>
                <div id="qrActions" style="display:none;" class="flex gap-2">
                    <button onclick="descargarQR('png')" class="btn-outline btn-sm"><i class="fas fa-download"></i>
                        PNG</button>
                    <button onclick="descargarQR('jpg')" class="btn-outline btn-sm"><i class="fas fa-image"></i>
                        JPG</button>
                </div>
            </div>
            <div class="p-6">
                <div id="qrOutput" class="flex flex-col items-center justify-center py-10 text-aib-muted">
                    <i class="fas fa-qrcode text-5xl mb-3 opacity-30"></i>
                    <p class="text-sm">Seleccione un lote para generar el codigo QR</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Seleccion rapida -->
    <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden mt-8">
        <div class="p-5 border-b border-aib-border">
            <h3 class="text-base font-bold">Seleccion Rapida</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                @foreach ($lotes as $l)
                    <a href="javascript:void(0)" onclick="seleccionarLote({{ $l->id }})"
                        class="bg-aib-bg2 border border-aib-border rounded-xl p-4 text-center hover:border-aib-accent transition-all group cursor-pointer">
                        <i
                            class="fas fa-qrcode text-xl text-aib-muted group-hover:text-aib-accent transition-colors mb-2"></i>
                        <div class="text-xs font-bold text-aib-accent">{{ $l->codigo }}</div>
                        <div class="text-[10px] text-aib-muted mt-0.5">{{ $l->producto }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        let qrCodigoLote = '';

        function seleccionarLote(id) {
            document.getElementById('qrLoteSelect').value = id;
            generarQR();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function generarQR() {
            var loteId = document.getElementById('qrLoteSelect').value;
            var outputDiv = document.getElementById('qrOutput');
            var actionsDiv = document.getElementById('qrActions');
            var contenidoDiv = document.getElementById('qrContenido');

            if (!loteId) {
                outputDiv.innerHTML =
                    '<i class="fas fa-qrcode text-5xl mb-3 opacity-30"></i><p class="text-sm">Seleccione un lote para generar el codigo QR</p>';
                actionsDiv.style.display = 'none';
                contenidoDiv.textContent = 'Seleccione un lote para ver el contenido del QR';
                return;
            }

            outputDiv.innerHTML =
                '<i class="fas fa-spinner fa-spin text-3xl" style="color:#d4a017;"></i><p class="text-sm mt-3" style="color:#6b8264;">Generando QR...</p>';
            actionsDiv.style.display = 'none';

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/qr/datos/' + loteId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    qrCodigoLote = data.codigo;
                    contenidoDiv.textContent = data.contenido_qr;
                    dibujarTarjeta(data);
                } else {
                    outputDiv.innerHTML =
                        '<i class="fas fa-exclamation-triangle text-3xl" style="color:#ef4444;"></i><p class="text-sm mt-3" style="color:#ef4444;">Error al generar el QR (estado: ' +
                        xhr.status + ')</p>';
                }
            };
            xhr.onerror = function() {
                outputDiv.innerHTML =
                    '<i class="fas fa-exclamation-triangle text-3xl" style="color:#ef4444;"></i><p class="text-sm mt-3" style="color:#ef4444;">Error de conexion. Verifica que el servidor este corriendo.</p>';
            };
            xhr.send();
        }

        function dibujarTarjeta(data) {
            var outputDiv = document.getElementById('qrOutput');
            var actionsDiv = document.getElementById('qrActions');
            outputDiv.innerHTML = '';

            var canvas = document.createElement('canvas');
            canvas.id = 'canvasQR';
            canvas.width = 500;
            canvas.height = 720;
            canvas.style.maxWidth = '100%';
            canvas.style.height = 'auto';
            canvas.style.borderRadius = '12px';
            canvas.style.boxShadow = '0 8px 30px rgba(0,0,0,0.4)';
            outputDiv.appendChild(canvas);

            var ctx = canvas.getContext('2d');

            // Fondo blanco
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, 500, 720);

            // Borde exterior verde
            ctx.strokeStyle = '#1c2a18';
            ctx.lineWidth = 8;
            ctx.strokeRect(4, 4, 492, 712);

            // Borde dorado interior
            ctx.strokeStyle = '#d4a017';
            ctx.lineWidth = 2;
            ctx.strokeRect(14, 14, 472, 692);

            // Header verde
            var grad = ctx.createLinearGradient(0, 0, 500, 0);
            grad.addColorStop(0, '#1c2a18');
            grad.addColorStop(0.5, '#243521');
            grad.addColorStop(1, '#1c2a18');
            ctx.fillStyle = grad;
            rr(ctx, 20, 20, 460, 85, 8);
            ctx.fill();

            // Logo cuadrado
            ctx.fillStyle = '#d4a017';
            rr(ctx, 40, 32, 50, 50, 12);
            ctx.fill();

            // Texto AIB en logo
            ctx.fillStyle = '#1c2a18';
            ctx.font = 'bold 22px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('AIB', 65, 59);

            // Nombre empresa
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 18px Arial';
            ctx.textAlign = 'left';
            ctx.fillText('Agroindustrias AIB', 102, 48);

            // Subtitulo
            ctx.fillStyle = '#a3b89e';
            ctx.font = '11px Arial';
            ctx.fillText('Trazabilidad de Producto - Sede Ica, Peru', 102, 68);

            // Linea dorada
            ctx.strokeStyle = '#d4a017';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(40, 120);
            ctx.lineTo(460, 120);
            ctx.stroke();

            // Titulo
            ctx.fillStyle = '#1c2a18';
            ctx.font = 'bold 11px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('CODIGO DE TRAZABILIDAD', 250, 142);

            // Codigo del lote
            ctx.fillStyle = '#d4a017';
            ctx.font = 'bold 30px Arial';
            ctx.fillText(data.codigo, 250, 178);

            // Datos del lote
            var items = [
                ['Producto', data.producto],
                ['Cantidad', data.cantidad_kg],
                ['Proveedor', data.proveedor],
                ['Etapa Actual', data.etapa],
                ['Estado', data.estado]
            ];

            var yPos = 210;
            for (var i = 0; i < items.length; i++) {
                if (i % 2 === 0) {
                    ctx.fillStyle = '#f8faf7';
                    ctx.fillRect(40, yPos - 10, 420, 26);
                }
                ctx.fillStyle = '#6b8264';
                ctx.font = '11px Arial';
                ctx.textAlign = 'left';
                ctx.fillText(items[i][0] + ':', 55, yPos + 6);
                ctx.fillStyle = '#1c2a18';
                ctx.font = 'bold 13px Arial';
                ctx.textAlign = 'right';
                ctx.fillText(items[i][1], 445, yPos + 6);
                yPos += 26;
            }

            // Separador
            ctx.strokeStyle = '#e0e8de';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(40, yPos + 10);
            ctx.lineTo(460, yPos + 10);
            ctx.stroke();

            // Barra de progreso de etapas
            var etapas = ['Cultivo', 'Recepcion', 'Procesamiento', 'Empaque', 'Almacenamiento', 'Exportacion'];
            var colores = ['#4ade80', '#38bdf8', '#d4a017', '#a78bfa', '#f472b6', '#fb923c'];
            var idxActual = etapas.indexOf(data.etapa);
            var dotY = yPos + 32;
            var dotStart = 250 - (etapas.length * 16);

            // Linea de fondo
            ctx.strokeStyle = '#e0e8de';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(dotStart + 8, dotY);
            ctx.lineTo(dotStart + etapas.length * 32 - 8, dotY);
            ctx.stroke();

            // Linea de progreso
            if (idxActual > 0) {
                ctx.strokeStyle = '#4ade80';
                ctx.lineWidth = 3;
                ctx.beginPath();
                ctx.moveTo(dotStart + 8, dotY);
                ctx.lineTo(dotStart + idxActual * 32, dotY);
                ctx.stroke();
            }

            // Puntos de cada etapa
            for (var j = 0; j < etapas.length; j++) {
                var dx = dotStart + j * 32;
                ctx.beginPath();
                ctx.arc(dx, dotY, 7, 0, Math.PI * 2);

                if (j < idxActual) {
                    ctx.fillStyle = colores[j];
                    ctx.fill();
                    ctx.fillStyle = '#fff';
                    ctx.font = 'bold 9px Arial';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText('✓', dx, dotY + 1);
                } else if (j === idxActual) {
                    ctx.fillStyle = colores[j];
                    ctx.fill();
                    ctx.fillStyle = '#fff';
                    ctx.font = 'bold 9px Arial';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(String(j + 1), dx, dotY + 1);
                } else {
                    ctx.fillStyle = '#fff';
                    ctx.fill();
                    ctx.strokeStyle = '#c0c8bc';
                    ctx.lineWidth = 1.5;
                    ctx.stroke();
                    ctx.fillStyle = '#a3b89e';
                    ctx.font = '9px Arial';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(String(j + 1), dx, dotY + 1);
                }
            }

            // Etiqueta de etapa actual
            ctx.fillStyle = colores[idxActual] || '#6b8264';
            ctx.font = 'bold 10px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'alphabetic';
            ctx.fillText('Etapa: ' + data.etapa, 250, dotY + 22);

            // Generar QR en div temporal
            var tmp = document.createElement('div');
            tmp.style.position = 'absolute';
            tmp.style.left = '-9999px';
            document.body.appendChild(tmp);

            var qrObj = new QRCode(tmp, {
                text: data.contenido_qr,
                width: 220,
                height: 220,
                colorDark: '#1c2a18',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });

            // Esperar a que se dibuje el QR
            setTimeout(function() {
                var qrCanvas = tmp.querySelector('canvas');
                if (qrCanvas) {
                    var qrY = dotY + 40;
                    // Fondo del QR
                    ctx.fillStyle = '#f5f8f3';
                    rr(ctx, 140, qrY, 220, 220, 10);
                    ctx.fill();
                    // Borde dorado del QR
                    ctx.strokeStyle = '#d4a017';
                    ctx.lineWidth = 2;
                    rr(ctx, 140, qrY, 220, 220, 10);
                    ctx.stroke();
                    // Dibujar QR
                    ctx.drawImage(qrCanvas, 150, qrY + 10, 200, 200);
                }

                // Pie de pagina
                ctx.fillStyle = '#f8faf7';
                ctx.fillRect(20, 648, 460, 50);
                ctx.strokeStyle = '#d4a017';
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(40, 648);
                ctx.lineTo(460, 648);
                ctx.stroke();
                ctx.fillStyle = '#6b8264';
                ctx.font = '10px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'alphabetic';
                ctx.fillText('Escanee para ver la informacion de trazabilidad', 250, 668);
                ctx.fillStyle = '#d4a017';
                ctx.font = 'bold 10px Arial';
                ctx.fillText('Agroindustrias AIB - Sede Ica, Peru', 250, 686);

                // Eliminar temporal
                document.body.removeChild(tmp);
                // Mostrar botones
                actionsDiv.style.display = 'flex';
            }, 400);
        }

        // Rectangulo redondeado
        function rr(ctx, x, y, w, h, r) {
            ctx.beginPath();
            ctx.moveTo(x + r, y);
            ctx.lineTo(x + w - r, y);
            ctx.quadraticCurveTo(x + w, y, x + w, y + r);
            ctx.lineTo(x + w, y + h - r);
            ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
            ctx.lineTo(x + r, y + h);
            ctx.quadraticCurveTo(x, y + h, x, y + h - r);
            ctx.lineTo(x, y + r);
            ctx.quadraticCurveTo(x, y, x + r, y);
            ctx.closePath();
        }

        // Descargar QR
        function descargarQR(formato) {
            var canvas = document.getElementById('canvasQR');
            if (!canvas) return;
            var mime = formato === 'jpg' ? 'image/jpeg' : 'image/png';
            var ext = formato === 'jpg' ? 'jpg' : 'png';
            var link = document.createElement('a');
            link.download = 'QR-' + qrCodigoLote + '.' + ext;
            link.href = canvas.toDataURL(mime, 0.95);
            link.click();
        }

        // Auto-generar si viene por URL
        @if (isset($lote))
            document.addEventListener('DOMContentLoaded', function() {
                generarQR();
            });
        @endif
    </script>
@endpush
