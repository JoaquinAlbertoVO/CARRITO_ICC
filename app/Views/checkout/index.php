<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago Express</title>
    <!-- Fuentes de ICC.com.pe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;500;600;700&family=League+Spartan:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/checkout.css?v=2.0">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- PayPal SDK (client-id=sb es para pruebas/sandbox, cámbialo por tu Client ID de producción) -->
    <script src="https://www.paypal.com/sdk/js?client-id=BAAqiauJCgNIFSWMjIrbxzcIlAn6mEzi0uhKYnoN48a_57G7zfy8kInsweY2544eHBiTuc8YQRZKsckGUw&currency=USD"></script>
</head>

<body>
    <div class="checkout-container" x-data="checkoutApp()" x-init="init()">
        <div class="checkout-layout">

            <!-- Columna Izquierda: Información de Compra del Curso -->
            <div class="course-column">
                <div>
                    <div class="brand" style="margin-bottom: 20px;">E-Learning Academy</div>
                    
                    <!-- Video Promocional -->
                    <div class="video-container" style="margin-bottom: 25px; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
                        <!-- Video Placeholder (YouTube) -->
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/7SMbMxs27K0?rel=0" title="Video Promocional" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display: block;"></iframe>
                    </div>

                    <div class="course-info">
                        <h1 x-text="courseName" style="font-size: 1.8rem; margin-bottom: 15px; font-weight: 700; color: var(--text-color);">Cargando curso...</h1>
                        
                        <style>
                            .accordion-btn {
                                width: 100%; padding: 14px 18px; text-align: left; background: var(--surface-color, #f8f9fa); border: 1px solid var(--surface-border, #e9ecef); border-radius: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 600; color: var(--text-color, #333); margin-bottom: 8px; transition: all 0.2s ease;
                            }
                            .accordion-btn:hover { background: #e9ecef; }
                            .accordion-btn.active { background: #e0f2fe; border-color: #bae6fd; color: #0369a1; border-bottom-left-radius: 0; border-bottom-right-radius: 0; margin-bottom: 0;}
                            .accordion-content {
                                padding: 18px; border: 1px solid #bae6fd; border-top: none; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; font-size: 0.9rem; color: var(--text-muted, #555); background: #fff; margin-bottom: 8px;
                            }
                            .accordion-content ul { padding-left: 0; margin-bottom: 10px; list-style-type: none; }
                            .accordion-content ul li { margin-bottom: 8px; position: relative; padding-left: 24px; line-height: 1.4; }
                            .accordion-content ul li::before { content: '✅'; position: absolute; left: 0; font-size: 0.85rem; top: 1px;}
                            .schedule-box { background: #f8fafc; border: 1px dashed #cbd5e1; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
                            .schedule-box h5 { margin-top: 0; margin-bottom: 10px; color: #0f172a; font-weight: 700; font-size: 1rem; }
                            .schedule-box ul li::before { content: '📅'; }
                        </style>

                        <div class="course-accordion" x-data="{ activeAccordion: 1 }" style="margin-top: 20px;">
                            
                            <!-- Item 1: Resumen -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 1 }" @click="activeAccordion = activeAccordion === 1 ? null : 1">
                                    <span>ℹ️ Resumen del Curso</span>
                                    <span x-text="activeAccordion === 1 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 1" x-transition>
                                    <p style="margin-bottom: 8px;"><strong>⏳ Duración:</strong> 25 horas académicas</p>
                                    <p style="margin-bottom: 12px;"><strong>🎓 Incluye:</strong> Certificado de participación con QR</p>
                                    <p style="line-height: 1.5;">Curso orientado a planificar, ejecutar y documentar mantenimientos de subestaciones eléctricas, combinando contenido teórico y práctica en campo.</p>
                                </div>
                            </div>

                            <!-- Item 2: Temas Principales -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 2 }" @click="activeAccordion = activeAccordion === 2 ? null : 2">
                                    <span>📚 Temas Principales</span>
                                    <span x-text="activeAccordion === 2 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 2" x-transition style="display: none;">
                                    <ul>
                                        <li>Mantenimiento correctivo, preventivo y predictivo</li>
                                        <li>Tipos y partes de subestaciones eléctricas</li>
                                        <li>Transformadores, seccionadores y fusibles</li>
                                        <li>Equipos de protección personal y trajes ignífugos</li>
                                        <li>Equipos de maniobra y reglas de seguridad</li>
                                        <li>Medición de aislamiento y relación de transformación</li>
                                        <li>Análisis de aceite dieléctrico</li>
                                        <li>Visitas técnicas, informes y protocolos</li>
                                        <li>Certificado de operatividad</li>
                                        <li>Procedimientos de corte y puesta en marcha</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 3: Beneficios -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 3 }" @click="activeAccordion = activeAccordion === 3 ? null : 3">
                                    <span>⭐ Beneficios</span>
                                    <span x-text="activeAccordion === 3 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 3" x-transition style="display: none;">
                                    <ul>
                                        <li>Certificado de participacion con QR</li>
                                        <li>Material digital</li>
                                        <li>Grupo de WhatsApp del curso</li>
                                        <li>Entregables técnicos de mantenimiento y protocolos</li>
                                        <li>Clases teóricas mediante Zoom</li>
                                        <li>Acceso al aula virtual por un mes</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 4: Herramientas y Materiales -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 4 }" @click="activeAccordion = activeAccordion === 4 ? null : 4">
                                    <span>🛠️ Herramientas y Materiales</span>
                                    <span x-text="activeAccordion === 4 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 4" x-transition style="display: none;">
                                    <ul>
                                        <li>Megómetro digital de 5000V</li>
                                        <li>Kit extractor de aceite dieléctrico</li>
                                        <li>Pértigas de maniobra</li>
                                        <li>Revelador de tensión</li>
                                        <li>Pinza amperimétrica</li>
                                        <li>Traje ignífugo</li>
                                        <li>Careta contra arco eléctrico</li>
                                        <li>Guantes dieléctricos</li>
                                        <li>Equipos de seguridad y señalización</li>
                                        <li>Herramientas manuales</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Item 5: Programación -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 5 }" @click="activeAccordion = activeAccordion === 5 ? null : 5">
                                    <span>📅 Programación y Horarios (Julio)</span>
                                    <span x-text="activeAccordion === 5 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 5" x-transition style="display: none;">
                                    <div class="schedule-box" x-show="currency === 'PEN'">
                                        <h5>🇵🇪 Virtual Perú</h5>
                                        <ul style="margin-bottom: 5px;">
                                            <li><strong>20/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>21/07:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>23/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>24/07:</strong> Sesión virtual asíncrona</li>
                                        </ul>
                                    </div>

                                    <div class="schedule-box" x-show="currency !== 'PEN'" style="margin-bottom: 0;">
                                        <h5>🇪🇨 Virtual Ecuador y otros países</h5>
                                        <ul style="margin-bottom: 0;">
                                            <li><strong>20/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>21/07:</strong> Sesión virtual asíncrona</li>
                                            <li><strong>23/07:</strong> Zoom de 6:00 p. m. a 9:00 p. m.</li>
                                            <li><strong>24/07:</strong> Sesión virtual asíncrona</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="price-box">
                    <div class="price-label" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span>Monto total a pagar</span>
                        <span style="text-decoration: line-through; color: #94a3b8; font-size: 0.9rem; font-weight: normal;" x-text="currency === 'PEN' ? 'Precio Regular: S/ 250.00' : 'Precio Regular: US$ 45.00'"></span>
                    </div>
                    <div class="price-amount">
                        <span x-text="currencySymbol">S/</span>
                        <span x-text="coursePrice.toFixed(2)">0.00</span>
                        <span class="price-currency" x-text="currency">PEN</span>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Opciones de Pago -->
            <div class="payment-column">
                <div class="payment-header">
                    <h2>Método de Pago</h2>
                </div>

                <!-- Tabs para alternar entre métodos de pago -->
                <div class="payment-tabs">
                    <button class="tab-btn" x-show="currency === 'PEN'" :class="{ 'active': activeTab === 'manual' }" @click="setTab('manual')">
                        📱 Yape / Plin
                    </button>
                    <button class="tab-btn" :class="{ 'active': activeTab === 'paypal' }" @click="setTab('paypal')">
                        💳 PayPal / Tarjeta
                    </button>
                </div>

                <div class="tab-content">
                    <!-- Vista Yape / Plin -->
                    <div class="wallet-view" x-show="activeTab === 'manual'" x-transition>
                        <div class="digital-wallets">
                            <div class="wallet-card" :class="{ 'active': manualMethod === 'yape' }"
                                @click="setManualMethod('yape')">
                                <div class="wallet-logo" style="background: #7400b8; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(116,0,184,0.3);">Y</div>
                                <span>Yape</span>
                            </div>
                            <div class="wallet-card" :class="{ 'active': manualMethod === 'plin' }"
                                @click="setManualMethod('plin')">
                                <div class="wallet-logo" style="background: #00c8b0; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(0,200,176,0.3);">P</div>
                                <span>Plin</span>
                            </div>
                        </div>

                        <div class="wallet-details" x-show="manualMethod">
                            <div class="qr-container" style="text-align: center; padding: 15px;">
                                <img :src="manualDetails[manualMethod]?.qrUrl" alt="Código QR" class="qr-image" style="max-width: 220px; max-height: 280px; width: auto; height: auto; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); object-fit: contain;">
                            </div>

                            <div class="payment-info-box">
                                <div class="info-row">
                                    <span>Titular:</span>
                                    <span x-text="manualDetails[manualMethod]?.name">Cargando...</span>
                                </div>
                                <div class="info-row"
                                    style="border-top: 1px dashed var(--surface-border); margin-top: 8px; padding-top: 8px;">
                                    <span>Monto a transferir:</span>
                                    <span style="color: var(--primary); font-weight: 700;"
                                        x-text="'S/ ' + amountInSoles.toFixed(2) + ' PEN'"></span>
                                </div>
                                <template x-if="currency === 'USD'">
                                    <div class="info-row" style="font-size: 0.8rem; color: var(--text-secondary);">
                                        <span>(Convertido de:</span>
                                        <span
                                            x-text="'$' + coursePrice.toFixed(2) + ' USD al cambio ' + tipoCambio.toFixed(2) + ')'"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="user-info-section" style="margin-top: 15px; text-align: left;">
                                <h4 style="font-size: 0.95rem; margin-bottom: 10px; color: var(--text-color);">Tus datos (Para el certificado):</h4>
                                <input type="text" x-model="dni" placeholder="DNI o Documento de Identidad" class="form-control" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid var(--surface-border); border-radius: 8px;" required>
                                <input type="text" x-model="nombre" placeholder="Nombres completos" class="form-control" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid var(--surface-border); border-radius: 8px;" required>
                                <input type="text" x-model="apellido" placeholder="Apellidos completos" class="form-control" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid var(--surface-border); border-radius: 8px;" required>
                                <input type="text" x-model="celular" placeholder="Número de celular / WhatsApp" class="form-control" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid var(--surface-border); border-radius: 8px;" required>
                            </div>

                            <div class="voucher-section">
                                <div class="file-upload-box" @click="document.getElementById('voucher_upload').click()">
                                    <span class="file-upload-label" id="file_label"
                                        x-text="voucherFile ? '✓ ' + voucherFile.name : 'Subir captura o foto del voucher' "></span>
                                    <input type="file" id="voucher_upload" style="display: none;"
                                        @change="voucherFile = $event.target.files[0]" accept="image/*,application/pdf">
                                </div>
                            </div>

                            <button @click="submitManualPayment()" id="btn_submit_manual" class="btn-submit" :disabled="!voucherFile">
                                Confirmar mi inscripción
                            </button>
                        </div>
                    </div>

                    <!-- Vista PayPal -->
                    <div class="paypal-view" x-show="activeTab === 'paypal'" x-transition>
                        <p class="paypal-instructions">
                            Inicia sesión en tu cuenta de PayPal o procesa el pago de forma segura con tarjeta de
                            crédito/débito en dólares.
                        </p>

                        <template x-if="currency === 'PEN'">
                            <p
                                style="font-size: 0.85rem; color: var(--text-secondary); text-align: center; margin-bottom: 15px;">
                                (Equivalente para PayPal: <strong style="color: var(--text-primary);"
                                    x-text="'$' + amountInUSD.toFixed(2) + ' USD'"></strong> al cambio de <span
                                    x-text="tipoCambio"></span>)
                            </p>
                        </template>

                        <!-- Contenedor del Botón Inteligente de PayPal -->
                        <div id="paypal-button-container"></div>
                    </div>
                </div>

                <div class="trust-badges">
                    <div class="trust-badge-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944a11.954 11.954 0 007.834 3.055A8.536 8.536 0 0018 7c0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Pago 100% Seguro
                    </div>
                    <div class="trust-badge-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                        Encriptación SSL 256-bit
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Generador de Enlaces de Pago para Administración (TikTok y Ofertas Especiales) -->
    <!-- Solo se muestra si añades ?admin=true a la URL -->
    <div class="admin-card" x-data="adminPanel()" x-show="visible" x-transition>
        <div class="admin-header">
            <h3>Generador de Enlaces de Pago</h3>
            <span class="admin-badge">Admin Panel</span>
        </div>

        <div class="admin-grid">
            <div class="form-group">
                <label for="admin_curso">Nombre del Curso</label>
                <input type="text" id="admin_curso" class="form-control" x-model="courseName"
                    placeholder="Ej: Curso TikTok Premium">
            </div>
            <div class="form-group">
                <label for="admin_precio">Precio Especial</label>
                <input type="number" id="admin_precio" class="form-control" x-model.number="price" placeholder="Ej: 20">
            </div>
            <div class="form-group">
                <label for="admin_moneda">Moneda</label>
                <select id="admin_moneda" class="form-control" x-model="currency">
                    <option value="USD">Dólares (USD)</option>
                    <option value="PEN">Soles (PEN)</option>
                </select>
            </div>
        </div>

        <div class="admin-actions">
            <button @click="generateLink()" class="btn-submit" style="margin-top: 0; padding: 12px 20px;">
                Generar Enlace
            </button>

            <div class="link-result-box" x-show="generatedLink">
                <input type="text" readonly :value="generatedLink" id="generated_link_input" class="link-input">
                <button @click="copyLink()" class="btn-copy">Copiar Link</button>
            </div>
        </div>
    </div>


    <!-- Script de Configuración de la Pasarela -->
    <script>
        function checkoutApp() {
            return {
                // Estado dinámico cargado desde la URL
                courseName: '',
                coursePrice: 30.00,
                currency: 'USD',

                // Tipo de cambio para conversiones USD <-> PEN
                tipoCambio: 3.80,

                // Pestaña activa ('manual' o 'paypal')
                activeTab: 'manual',

                // Submétodo manual activo ('yape' o 'plin')
                manualMethod: 'yape',
                voucherFile: null,

                // Datos del estudiante
                dni: '',
                nombre: '',
                apellido: '',
                celular: '',

                // Datos de Yape y Plin (Ajusta tus datos reales aquí)
                manualDetails: {
                    yape: {
                        title: 'Pago con Yape',
                        qrUrl: '<?= BASE_URL ?>assets/images/Yape.jpg',
                        color: '#7400b8',
                        name: 'Mariela Guadalupe Martinez Vargas'
                    },
                    plin: {
                        title: 'Pago con Plin',
                        qrUrl: '<?= BASE_URL ?>assets/images/plin.jpg',
                        color: '#00c8b0',
                        name: 'Ricardo Cardenas'
                    }
                },

                get currencySymbol() {
                    return this.currency === 'USD' ? '$' : 'S/ ';
                },

                get amountInUSD() {
                    if (this.currency === 'USD') return this.coursePrice;
                    return parseFloat((this.coursePrice / this.tipoCambio).toFixed(2));
                },

                get amountInSoles() {
                    if (this.currency === 'PEN') return this.coursePrice;
                    return parseFloat((this.coursePrice * this.tipoCambio).toFixed(2));
                },

                init() {
                    // 1. Cargar parámetros desde la URL
                    const urlParams = new URLSearchParams(window.location.search);
                    this.courseName = urlParams.get('curso') || 'Curso Completo de Marketing y Ventas';
                    this.coursePrice = parseFloat(urlParams.get('precio')) || 30.00;
                    this.currency = (urlParams.get('moneda') || 'USD').toUpperCase();

                    // Si la moneda es USD, abrimos PayPal por defecto, si es PEN abrimos Yape/Plin por defecto
                    this.activeTab = this.currency === 'USD' ? 'paypal' : 'manual';

                    // Renderizamos los botones si la pestaña inicial es PayPal
                    if (this.activeTab === 'paypal') {
                        setTimeout(() => this.renderPayPalButtons(), 100);
                    }
                },

                setTab(tab) {
                    this.activeTab = tab;
                    if (tab === 'paypal') {
                        setTimeout(() => this.renderPayPalButtons(), 50);
                    }
                },

                setManualMethod(method) {
                    this.manualMethod = method;
                },

                submitManualPayment() {
                    if (!this.dni || !this.nombre || !this.apellido || !this.celular) {
                        alert('Por favor, ingresa tu DNI, Nombres, Apellidos y Celular.');
                        return;
                    }

                    if (!this.voucherFile) {
                        alert('Por favor, adjunta tu ticket o voucher de pago para continuar.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('voucher', this.voucherFile);
                    formData.append('curso', this.courseName);
                    formData.append('dni', this.dni);
                    formData.append('nombre', this.nombre);
                    formData.append('apellido', this.apellido);
                    formData.append('celular', this.celular);

                    const btn = document.getElementById('btn_submit_manual');
                    btn.disabled = true;
                    btn.innerText = 'Subiendo voucher...';

                    fetch('<?= BASE_URL ?>checkout/voucher', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            alert('¡Comprobante subido con éxito! Por favor envíanos un mensaje para enviarte tus accesos.');
                            this.voucherFile = null;
                        } else {
                            alert('Ocurrió un error: ' + (data.error || 'Error desconocido'));
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        alert('Error de conexión al subir el voucher. Intenta nuevamente.');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerText = 'Confirmar mi inscripción';
                    });
                },

                renderPayPalButtons() {
                    const container = document.getElementById('paypal-button-container');
                    if (!container) return;

                    // No duplicar botones
                    if (container.children.length > 0) return;

                    if (typeof paypal === 'undefined') {
                        console.error('PayPal SDK no disponible.');
                        return;
                    }

                    const self = this;
                    paypal.Buttons({
                        createOrder: function (data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        currency_code: 'USD',
                                        value: self.amountInUSD.toString()
                                    },
                                    description: `Acceso al curso: ${self.courseName}`
                                }]
                            });
                        },
                        onApprove: function (data, actions) {
                            return actions.order.capture().then(function (details) {
                                alert(`¡Inscripción confirmada! Pago recibido exitosamente por PayPal. Bienvenido/a al curso, ${details.payer.name.given_name}. Por favor escríbenos para reclamar tus accesos.`);
                                console.log('PayPal details:', details);
                            });
                        },
                        onError: function (err) {
                            console.error('PayPal Error:', err);
                            alert('Hubo un inconveniente con el pago en PayPal. Por favor, intente de nuevo.');
                        }
                    }).render('#paypal-button-container');
                }
            }
        }

        function adminPanel() {
            return {
                visible: false,
                courseName: '',
                price: 30,
                currency: 'USD',
                generatedLink: '',

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    // El panel solo es visible si añadimos ?admin=true en la URL
                    this.visible = urlParams.get('admin') === 'true';

                    // Rellenar valores iniciales
                    this.courseName = urlParams.get('curso') || 'Curso Completo de Marketing y Ventas';
                    this.price = parseFloat(urlParams.get('precio')) || 30.00;
                    this.currency = (urlParams.get('moneda') || 'USD').toUpperCase();
                },

                generateLink() {
                    const baseUrl = window.location.origin + window.location.pathname;
                    const params = new URLSearchParams();
                    params.set('curso', this.courseName);
                    params.set('precio', this.price.toFixed(2));
                    params.set('moneda', this.currency);

                    this.generatedLink = `${baseUrl}?${params.toString()}`;
                },

                copyLink() {
                    const copyText = document.getElementById("generated_link_input");
                    copyText.select();
                    copyText.setSelectionRange(0, 99999); // Para móviles

                    navigator.clipboard.writeText(copyText.value)
                        .then(() => {
                            alert("¡Enlace de pago copiado al portapapeles! Ya puedes enviarlo por WhatsApp o redes sociales.");
                        })
                        .catch(err => {
                            console.error("Error al copiar enlace:", err);
                        });
                }
            }
        }
    </script>
</body>

</html>
