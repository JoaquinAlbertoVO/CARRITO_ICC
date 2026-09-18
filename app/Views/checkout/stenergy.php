<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago - ST Energy</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;500;600;700&family=League+Spartan:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- PayPal SDK: misma cuenta/Client ID que usa ICC -->
    <script src="https://www.paypal.com/sdk/js?client-id=BAAqiauJCgNIFSWMjIrbxzcIlAn6mEzi0uhKYnoN48a_57G7zfy8kInsweY2544eHBiTuc8YQRZKsckGUw&currency=USD"></script>

    <style>
        :root {
            --st-black: #0a0a0a;
            --st-surface: #161616;
            --st-yellow: #F5C500;
            --st-red: #E63946;
            --st-blue: #2E9EF7;
            --st-text: #f2f2f2;
            --st-text-muted: #a3a3a3;
            --st-border: #2c2c2c;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Kumbh Sans', Arial, sans-serif;
            background: var(--st-black);
            color: var(--st-text);
        }
        .checkout-container { max-width: 1100px; margin: 0 auto; padding: 24px 16px; }
        .checkout-layout { display: grid; grid-template-columns: 1.1fr 1fr; gap: 28px; align-items: start; }
        @media (max-width: 860px) { .checkout-layout { grid-template-columns: 1fr; } }

        .brand { text-align: center; margin-bottom: 20px; }
        .brand img { max-height: 90px; }

        .card {
            background: var(--st-surface);
            border: 1px solid var(--st-border);
            border-radius: 14px;
            padding: 24px;
        }

        h1 { font-family: 'League Spartan', sans-serif; font-weight: 800; font-size: 1.7rem; margin: 0 0 8px; color: var(--st-yellow); }
        .subtitle { color: var(--st-text-muted); font-size: 0.95rem; margin-bottom: 20px; line-height: 1.5; }

        .price-box { display: flex; align-items: baseline; gap: 6px; margin: 18px 0; }
        .price-box .amount { font-family: 'League Spartan', sans-serif; font-size: 2.4rem; font-weight: 800; color: var(--st-yellow); }
        .price-box .currency { color: var(--st-text-muted); font-size: 1rem; }

        .accent-line { height: 3px; width: 70px; background: linear-gradient(90deg, var(--st-red), var(--st-blue)); border-radius: 3px; margin: 16px 0 20px; }

        .form-control {
            width: 100%; padding: 12px 14px; margin-bottom: 12px;
            border: 1px solid var(--st-border); border-radius: 8px;
            background: #0f0f0f; color: var(--st-text); font-size: 0.95rem;
        }
        .form-control::placeholder { color: #6b6b6b; }
        .form-control:focus { outline: none; border-color: var(--st-yellow); }

        label.section-label { display: block; font-weight: 700; font-size: 0.9rem; color: var(--st-text); margin-bottom: 10px; }

        #paypal-button-container { margin-top: 16px; }

        .trust-row { display: flex; gap: 16px; margin-top: 20px; font-size: 0.8rem; color: var(--st-text-muted); flex-wrap: wrap; }
        .trust-row span { display: flex; align-items: center; gap: 6px; }
        .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--st-yellow); display: inline-block; }

        .meta-row { display: flex; gap: 18px; flex-wrap: wrap; font-size: 0.85rem; color: var(--st-text-muted); margin-bottom: 14px; }
        .meta-row strong { color: var(--st-text); }

        .tab-row { display: flex; gap: 8px; margin-bottom: 16px; }
        .tab-btn {
            flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--st-border);
            background: #0f0f0f; color: var(--st-text-muted); font-weight: 700; font-size: 0.9rem; cursor: pointer;
        }
        .tab-btn.active { background: var(--st-yellow); color: #0a0a0a; border-color: var(--st-yellow); }

        .wallet-row { display: flex; gap: 8px; }
        .wallet-btn {
            flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--st-border);
            background: #0f0f0f; color: var(--st-text-muted); font-weight: 700; cursor: pointer;
        }
        .wallet-btn.active { border-color: var(--st-yellow); color: var(--st-yellow); }

        .btn-wa[disabled] { opacity: 0.5; cursor: not-allowed; }

        .section-title { font-family: 'League Spartan', sans-serif; font-weight: 700; font-size: 1rem; color: var(--st-yellow); margin: 20px 0 10px; }
        .item-list { list-style: none; padding: 0; margin: 0; }
        .item-list li { padding: 6px 0; font-size: 0.9rem; color: var(--st-text); line-height: 1.4; }

        .success-view { text-align: center; padding: 40px 20px; }
        .success-view .check { font-size: 3.2rem; margin-bottom: 10px; }
        .success-view h2 { color: var(--st-yellow); font-family: 'League Spartan', sans-serif; }
        .btn-wa {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--st-yellow); color: #0a0a0a; font-weight: 700;
            padding: 13px 26px; border-radius: 30px; text-decoration: none; margin-top: 18px;
        }
    </style>
</head>

<body>
    <div class="checkout-container" x-data="stEnergyCheckout()" x-init="init()">
        <div class="brand">
            <img src="<?= BASE_URL ?>assets/images/stenergy/logo.jpeg" alt="ST Energy">
        </div>

        <div class="checkout-layout">
            <!-- Columna izquierda: info del curso -->
            <div class="card">
                <h1 x-text="courseName">Cargando curso...</h1>
                <div class="meta-row">
                    <span>⏳ <strong x-text="duracion"></strong></span>
                    <span>🎓 <strong x-text="incluye"></strong></span>
                </div>
                <p class="subtitle" x-text="descripcion"></p>
                <div class="accent-line"></div>
                <div class="price-box">
                    <span class="currency" x-text="currencySymbol"></span>
                    <span class="amount" x-text="coursePrice.toFixed(2)"></span>
                    <span class="currency" x-text="currency"></span>
                </div>
                <template x-if="currency === 'PEN'">
                    <p style="font-size: 0.82rem; color: var(--st-text-muted);">
                        (Se cobra en dólares vía PayPal: <strong style="color: var(--st-text);" x-text="'$' + amountInUSD.toFixed(2) + ' USD'"></strong> al cambio de <span x-text="tipoCambio"></span>)
                    </p>
                </template>

                <template x-if="temas.length > 0">
                    <div>
                        <div class="section-title">Temas principales</div>
                        <ul class="item-list">
                            <template x-for="t in temas" :key="t"><li x-text="'✅ ' + t"></li></template>
                        </ul>
                    </div>
                </template>

                <template x-if="equipos.length > 0">
                    <div>
                        <div class="section-title">Equipos y herramientas</div>
                        <ul class="item-list">
                            <template x-for="e in equipos" :key="e"><li x-text="'✅ ' + e"></li></template>
                        </ul>
                    </div>
                </template>

                <div class="trust-row">
                    <span><span class="dot"></span> Pago 100% seguro</span>
                    <span><span class="dot"></span> Encriptación SSL</span>
                </div>
            </div>

            <!-- Columna derecha: pago -->
            <div class="card">
                <div x-show="!paymentSuccess">
                    <div class="tab-row">
                        <button type="button" class="tab-btn" :class="{ active: activeTab === 'manual' }" @click="activeTab = 'manual'">📱 Yape / Plin</button>
                        <button type="button" class="tab-btn" :class="{ active: activeTab === 'paypal' }" @click="activeTab = 'paypal'">💳 PayPal / Tarjeta</button>
                    </div>

                    <!-- Vista Yape / Plin (manual) -->
                    <div x-show="activeTab === 'manual'">
                        <div class="wallet-row">
                            <button type="button" class="wallet-btn" :class="{ active: manualMethod === 'yape' }" @click="manualMethod = 'yape'">Yape</button>
                            <button type="button" class="wallet-btn" :class="{ active: manualMethod === 'plin' }" @click="manualMethod = 'plin'">Plin</button>
                        </div>

                        <div style="text-align:center; margin: 14px 0;">
                            <img :src="manualMethod === 'yape' ? '<?= BASE_URL ?>assets/images/Yape.jpg' : '<?= BASE_URL ?>assets/images/plin.jpg'"
                                 alt="QR de pago" style="max-width: 200px; border-radius: 10px;">
                        </div>
                        <div class="meta-row" style="justify-content: center;">
                            <span>Titular: <strong x-text="manualMethod === 'yape' ? 'Mariela Ma.' : 'Ricardo Cardenas'"></strong></span>
                        </div>
                        <div class="meta-row" style="justify-content: center; margin-bottom: 16px;">
                            <span>Monto a transferir: <strong x-text="currencySymbol + ' ' + coursePrice.toFixed(2)"></strong></span>
                        </div>

                        <label class="section-label">Tus datos (para tu matrícula)</label>
                        <input type="email" x-model="email" placeholder="Correo electrónico" class="form-control" required>
                        <input type="text" x-model="dni" placeholder="DNI o Documento de Identidad" class="form-control" required>
                        <input type="text" x-model="nombre" placeholder="Nombres completos" class="form-control" required>
                        <input type="text" x-model="apellido" placeholder="Apellidos completos" class="form-control" required>
                        <input type="text" x-model="celular" placeholder="Número de celular / WhatsApp" class="form-control" required>

                        <input type="file" id="voucher_input" accept="image/*,application/pdf" @change="voucherFile = $event.target.files[0]" class="form-control">

                        <button type="button" id="btn_manual_submit" class="btn-wa" style="width:100%; justify-content:center; border:0; cursor:pointer;" :disabled="!voucherFile" @click="submitManualPayment()">
                            Confirmar mi inscripción
                        </button>
                    </div>

                    <!-- Vista PayPal -->
                    <div x-show="activeTab === 'paypal'">
                        <label class="section-label">Tus datos (para tu matrícula)</label>
                        <input type="email" x-model="email" placeholder="Correo electrónico" class="form-control" required>
                        <input type="text" x-model="dni" placeholder="DNI o Documento de Identidad" class="form-control" required>
                        <input type="text" x-model="nombre" placeholder="Nombres completos" class="form-control" required>
                        <input type="text" x-model="apellido" placeholder="Apellidos completos" class="form-control" required>
                        <input type="text" x-model="celular" placeholder="Número de celular / WhatsApp" class="form-control" required>

                        <div id="paypal-button-container"></div>
                    </div>
                </div>

                <div class="success-view" x-show="paymentSuccess" x-transition style="display:none;">
                    <div class="check">✅</div>
                    <template x-if="paymentMethodUsed === 'paypal'">
                        <div>
                            <h2>¡Pago confirmado!</h2>
                            <p style="color: var(--st-text-muted); line-height: 1.6;">
                                Estamos matriculando tu acceso en la plataforma de ST Energy.
                                En unos minutos recibirás un correo con tus credenciales — revisa también tu carpeta de Spam.
                            </p>
                        </div>
                    </template>
                    <template x-if="paymentMethodUsed === 'manual'">
                        <div>
                            <h2>¡Comprobante recibido!</h2>
                            <p style="color: var(--st-text-muted); line-height: 1.6;">
                                Nuestro equipo va a revisar tu pago y activar tu acceso a la brevedad.
                                Para agilizarlo, escríbenos por WhatsApp confirmando tus datos.
                            </p>
                        </div>
                    </template>
                    <a class="btn-wa" href="https://wa.me/51986884219?text=Hola%2C%20acabo%20de%20pagar%20mi%20curso%20en%20ST%20Energy." target="_blank">
                        💬 Escribir por WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Perfiles de curso. ?tipo=solo o ?tipo=duo elige cual mostrar (default: duo).
        // Ambos matriculan hoy en el mismo curso de WordPress (Terminaciones, course_id 4043)
        // del lado del backend -- "Empalmes" todavia no existe como curso aparte en WP.
        const CURSOS_STENERGY = {
            solo: {
                nombre: 'Terminaciones Termocontraíbles en Media Tensión',
                duracion: '15 horas académicas',
                incluye: 'Certificado de participación con QR',
                descripcion: 'Curso orientado a aprender la correcta instalación de terminaciones en cables de media tensión, aplicando procedimientos técnicos, criterios de seguridad y buenas prácticas del sector.',
                temas: [
                    'Tipos de cables y niveles de tensión',
                    'Conductor, aislamiento, semiconductoras y pantalla metálica',
                    'Aislamientos XLPE, HEPR y EPR',
                    'Terminaciones rectas, interiores, exteriores y tripolares hasta 36 kV',
                    'Componentes de una terminación',
                    'Medición de aislamiento con megómetro',
                    'Herramientas aisladas y equipos de protección personal',
                    'Práctica de terminaciones interior y exterior hasta 25 kV'
                ],
                equipos: [
                    'Cilindro de gas GLP y boquilla de 2”',
                    'Kit de terminación termocontraíble de uso exterior',
                    'Cable de media tensión de 10 kV y/o 25 kV',
                    'Herramientas manuales'
                ],
                precioDefault: 600
            },
            duo: {
                nombre: 'Terminaciones y Empalmes Termocontraíbles en Media Tensión',
                duracion: '20 horas académicas',
                incluye: 'Doble Certificado de participación con QR, materiales, manuales y clases grabadas',
                descripcion: 'Curso doble: instalación de terminaciones y de empalmes termocontraíbles en cables de media tensión, con certificación independiente para cada especialidad.',
                temas: [],
                equipos: [],
                precioDefault: 900
            }
        };

        function stEnergyCheckout() {
            return {
                paymentSuccess: false,
                paymentMethodUsed: null,
                activeTab: 'manual',
                manualMethod: 'yape',
                voucherFile: null,
                courseName: 'Cargando curso...',
                coursePrice: 900.00,
                currency: 'PEN',
                tipoCambio: 3.80,
                duracion: '',
                incluye: '',
                descripcion: '',
                temas: [],
                equipos: [],

                email: '', dni: '', nombre: '', apellido: '', celular: '',

                get currencySymbol() {
                    return this.currency === 'USD' ? '$' : 'S/';
                },
                get amountInUSD() {
                    if (this.currency === 'USD') return this.coursePrice;
                    return parseFloat((this.coursePrice / this.tipoCambio).toFixed(2));
                },

                init() {
                    const urlParams = new URLSearchParams(window.location.search);

                    const tipo = (urlParams.get('tipo') || 'duo').toLowerCase();
                    const perfil = CURSOS_STENERGY[tipo] || CURSOS_STENERGY.duo;

                    this.courseName = perfil.nombre;
                    this.duracion = perfil.duracion;
                    this.incluye = perfil.incluye;
                    this.descripcion = perfil.descripcion;
                    this.temas = perfil.temas;
                    this.equipos = perfil.equipos;
                    this.coursePrice = perfil.precioDefault;

                    // Overrides manuales (para links promocionales con precio especial)
                    if (urlParams.get('curso')) this.courseName = urlParams.get('curso');
                    if (urlParams.get('precio')) this.coursePrice = parseFloat(urlParams.get('precio'));
                    if (urlParams.get('moneda')) this.currency = urlParams.get('moneda').toUpperCase();

                    this.renderPayPalButtons();
                },

                renderPayPalButtons() {
                    const container = document.getElementById('paypal-button-container');
                    if (!container || typeof paypal === 'undefined') return;
                    // No duplicar botones (el mismo guard que ya usa el checkout de ICC)
                    if (container.children.length > 0) return;
                    const self = this;

                    paypal.Buttons({
                        onClick: function (data, actions) {
                            if (!self.email || !self.dni || !self.nombre || !self.apellido || !self.celular) {
                                alert('Por favor, completa tu correo, DNI, Nombres, Apellidos y Celular antes de pagar.');
                                return actions.reject();
                            }
                            return actions.resolve();
                        },
                        createOrder: function (data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        currency_code: 'USD',
                                        value: self.amountInUSD.toString()
                                    },
                                    description: `ST Energy - ${self.courseName}`
                                }]
                            });
                        },
                        onApprove: function (data, actions) {
                            return actions.order.capture().then(function (details) {
                                // El pago ya se completo de verdad en PayPal: mostramos exito de inmediato.
                                self.paymentSuccess = true;
                                self.paymentMethodUsed = 'paypal';
                                window.scrollTo({ top: 0, behavior: 'smooth' });

                                // Matricula en WordPress (best-effort, no bloquea la pantalla de exito).
                                fetch('<?= BASE_URL ?>checkout/stenergy_confirm', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        orderID: data.orderID,
                                        email: self.email,
                                        dni: self.dni,
                                        nombre: self.nombre,
                                        apellido: self.apellido,
                                        celular: self.celular
                                    })
                                })
                                .then(res => res.json())
                                .then(resp => {
                                    if (!resp.success) {
                                        console.error('No se pudo matricular automaticamente:', resp.error, '- Orden:', data.orderID);
                                    }
                                })
                                .catch(err => console.error('Error de conexión confirmando ST Energy (orden ' + data.orderID + '):', err));
                            });
                        },
                        onError: function (err) {
                            console.error('PayPal Error:', err);
                            alert('Hubo un inconveniente con el pago. Por favor, intenta de nuevo.');
                        }
                    }).render('#paypal-button-container');
                },

                submitManualPayment() {
                    if (!this.email || !this.dni || !this.nombre || !this.apellido || !this.celular) {
                        alert('Por favor, completa tu correo, DNI, Nombres, Apellidos y Celular.');
                        return;
                    }
                    if (!this.voucherFile) {
                        alert('Por favor, adjunta tu ticket o voucher de pago para continuar.');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('voucher', this.voucherFile);
                    formData.append('curso', this.courseName);
                    formData.append('precio', this.coursePrice);
                    formData.append('moneda', this.currency);
                    formData.append('email', this.email);
                    formData.append('dni', this.dni);
                    formData.append('nombre', this.nombre);
                    formData.append('apellido', this.apellido);
                    formData.append('celular', this.celular);
                    formData.append('metodo', this.manualMethod);

                    const btn = document.getElementById('btn_manual_submit');
                    btn.disabled = true;
                    btn.innerText = 'Subiendo voucher...';

                    fetch('<?= BASE_URL ?>checkout/stenergy_voucher', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.success) {
                            this.paymentSuccess = true;
                            this.paymentMethodUsed = 'manual';
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            alert('Ocurrió un error: ' + (resp.error || 'Error desconocido'));
                            btn.disabled = false;
                            btn.innerText = 'Confirmar mi inscripción';
                        }
                    })
                    .catch(err => {
                        console.error('Error subiendo voucher ST Energy:', err);
                        alert('Error de conexión al subir el voucher. Intenta nuevamente.');
                        btn.disabled = false;
                        btn.innerText = 'Confirmar mi inscripción';
                    });
                }
            }
        }
    </script>
</body>
</html>
