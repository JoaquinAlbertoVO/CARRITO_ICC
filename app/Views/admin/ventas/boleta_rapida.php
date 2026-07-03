<div class="mdk-drawer-layout__content page">
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center justify-content-between">
            <h1 class="m-0">Generador de Boleta Rápida</h1>
        </div>
    </div>
    
    <div class="container-fluid page__container">
        <div class="row">
            <!-- Columna del Formulario -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <form id="formBoleta">
                            <div class="form-group">
                                <label for="cliente_nombre">Nombre del Cliente</label>
                                <input type="text" class="form-control" id="cliente_nombre" placeholder="Ej. Juan Pérez" oninput="actualizarBoleta()">
                            </div>
                            <div class="form-group">
                                <label for="producto_nombre">Producto / Descripción</label>
                                <input type="text" class="form-control" id="producto_nombre" placeholder="Ej. Curso de Electricidad Básica" oninput="actualizarBoleta()">
                            </div>
                            <div class="form-group">
                                <label for="monto">Monto Total (S/)</label>
                                <input type="number" step="0.10" class="form-control" id="monto" placeholder="Ej. 150.00" oninput="actualizarBoleta()">
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha de Emisión</label>
                                <input type="date" class="form-control" id="fecha" oninput="actualizarBoleta()">
                            </div>
                            <div class="form-group mt-4">
                                <button type="button" class="btn btn-primary btn-block mb-2" onclick="descargarPNG()">
                                    <i class="material-icons mr-1">image</i> Descargar como PNG
                                </button>
                                <button type="button" class="btn btn-danger btn-block" onclick="descargarPDF()">
                                    <i class="material-icons mr-1">picture_as_pdf</i> Descargar como PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Columna de la Vista Previa -->
            <div class="col-md-7 d-flex justify-content-center">
                <div class="boleta-container" id="boletaPreview" style="background-color: white; padding: 40px; width: 100%; max-width: 500px; border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0,0,0,0.1); font-family: 'Helvetica', Arial, sans-serif;">
                    <div class="text-center mb-4">
                        <h2 style="margin: 0; color: #333; font-weight: bold; font-size: 24px;">COMPROBANTE DE PAGO</h2>
                        <p style="margin: 5px 0 0; color: #777;">Boleta Electrónica</p>
                    </div>
                    
                    <hr style="border-top: 2px dashed #eee;">
                    
                    <div style="margin: 20px 0;">
                        <p style="margin: 5px 0;"><strong>Fecha:</strong> <span id="preview_fecha">--/--/----</span></p>
                        <p style="margin: 5px 0;"><strong>Cliente:</strong> <span id="preview_cliente">------------------</span></p>
                    </div>
                    
                    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #333;">
                                <th style="text-align: left; padding: 10px 0;">Descripción</th>
                                <th style="text-align: right; padding: 10px 0;">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 15px 0; border-bottom: 1px solid #eee;" id="preview_producto">------------------</td>
                                <td style="text-align: right; padding: 15px 0; border-bottom: 1px solid #eee;">S/ <span id="preview_monto">0.00</span></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right; padding: 15px 0; font-weight: bold; font-size: 18px;">TOTAL:</td>
                                <td style="text-align: right; padding: 15px 0; font-weight: bold; font-size: 18px; color: #0056b3;">S/ <span id="preview_total">0.00</span></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="text-center" style="margin-top: 40px;">
                        <p style="color: #888; font-size: 12px; margin: 0;">¡Gracias por su preferencia!</p>
                        <p style="color: #888; font-size: 12px; margin: 0;">Este documento es una representación impresa de una boleta de pago.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir librerias para exportar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    // Inicializar fecha al dia de hoy
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha').value = today;
        actualizarBoleta();
    });

    function actualizarBoleta() {
        // Obtener valores
        let cliente = document.getElementById('cliente_nombre').value || '------------------';
        let producto = document.getElementById('producto_nombre').value || '------------------';
        let monto = document.getElementById('monto').value || '0.00';
        let fecha = document.getElementById('fecha').value;
        
        // Formatear monto
        let montoFormateado = parseFloat(monto).toFixed(2);
        if (isNaN(montoFormateado)) montoFormateado = "0.00";

        // Formatear fecha
        let fechaFormat = "--/--/----";
        if(fecha) {
            let partes = fecha.split('-');
            fechaFormat = partes[2] + '/' + partes[1] + '/' + partes[0];
        }

        // Asignar a la vista previa
        document.getElementById('preview_cliente').innerText = cliente;
        document.getElementById('preview_producto').innerText = producto;
        document.getElementById('preview_monto').innerText = montoFormateado;
        document.getElementById('preview_total').innerText = montoFormateado;
        document.getElementById('preview_fecha').innerText = fechaFormat;
    }

    function descargarPNG() {
        const element = document.getElementById('boletaPreview');
        html2canvas(element, { scale: 2 }).then(canvas => {
            let link = document.createElement('a');
            link.download = 'boleta_' + Date.now() + '.png';
            link.href = canvas.toDataURL("image/png");
            link.click();
        });
    }

    function descargarPDF() {
        const element = document.getElementById('boletaPreview');
        html2canvas(element, { scale: 2 }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            // Crear PDF tamaño A5 aproximadamente para un recibo
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: [148, 210] // A5
            });
            
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
            
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('boleta_' + Date.now() + '.pdf');
        });
    }
</script>
