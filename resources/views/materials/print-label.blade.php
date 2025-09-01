<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta - Material Ejemplo</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.js"></script>
    <style>
        @page {
            size: 4in 3in;
            margin: 0.1in;
        }

        body {
            margin: 0;
            padding: 10px;
            font-family: Arial, sans-serif;
            width: 4in;
            height: 3in;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .label-container {
            width: 100%;
            height: 100%;
            border: 2px solid black;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
            box-sizing: border-box;
        }

        .part-number {
            text-align: center;
            font-size: 28px;
            font-weight: normal;
            padding-bottom: 8px;
            color: black;
            text-transform: uppercase;
            border-bottom: 1px solid black;
        }

        .qr-container {
            text-align: center;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        #qrcode {
            margin: 0 auto;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #qrcode img {
            width: 180px;
            height: 180px;
        }

        .validation-text {
            text-align: center;
            font-size: 32px;
            font-weight: normal;
            color: black;
            padding-top: 8px;
            border-top: 1px solid black;
        }

        .loading-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 18px;
            z-index: 1000;
        }

        @media print {
            .loading-message {
                display: none !important;
            }
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div id="loadingMessage" class="loading-message">
        Preparando etiqueta para imprimir...
    </div>

    <div class="label-container">
        <div class="part-number">
            {{ $material->part_number }}
        </div>

        <div class="qr-container">
            <div id="qrcode"></div>
        </div>

        <div class="validation-text">
            VALIDADO
        </div>
    </div>

    <script>
        function generateQR() {
            const qrContainer = document.getElementById("qrcode");
            const text = "{{ $material->ulid }}";

            try {
                const qr = qrcode(0, 'M');
                qr.addData(text);
                qr.make();
                const qrImage = qr.createImgTag(5, 0);
                qrContainer.innerHTML = qrImage;

                const img = qrContainer.querySelector('img');
                if (img) {
                    img.style.width = '180px';
                    img.style.height = '180px';
                }

                setTimeout(autoPrint, 100);
            } catch (error) {
                console.error('Error generando QR:', error);
                generateQRFallback();
            }
        }

        function generateQRFallback() {
            const qrContainer = document.getElementById("qrcode");
            const text = "{{ $material->ulid }}";

            const qrImage = document.createElement('img');
            qrImage.src = `https://chart.googleapis.com/chart?chs=180x180&chld=L|0&cht=qr&chl=${encodeURIComponent(text)}`;
            qrImage.style.width = '180px';
            qrImage.style.height = '180px';
            qrImage.alt = 'Código QR';

            qrContainer.innerHTML = '';
            qrContainer.appendChild(qrImage);

            qrImage.onload = function() {
                setTimeout(autoPrint, 100);
            };
        }

        function autoPrint() {
            const loadingMessage = document.getElementById('loadingMessage');
            if (loadingMessage) {
                loadingMessage.style.display = 'none';
            }

            setTimeout(() => {
                window.print();
            }, 100);
        }

        // Auto-retorno después de imprimir
        window.addEventListener('afterprint', function() {
            setTimeout(() => {
                window.location.href = "{{ route('materials.scan') }}";
            }, 500);
        });

        // Cargar todo al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Generar QR inmediatamente
            generateQR();

            // Respaldo: si no se imprime en 15 segundos, regresar automáticamente
            setTimeout(() => {
                window.location.href = "{{ route('materials.scan') }}";
            }, 5000);
        });

        // Manejar tecla Escape para cancelar y regresar
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.location.href = "{{ route('materials.scan') }}";
            }
        });
    </script>
</body>
</html>
