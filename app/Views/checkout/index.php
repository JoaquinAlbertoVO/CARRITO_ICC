<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $nombreCursoGA = isset($_GET['curso']) ? htmlspecialchars($_GET['curso']) : 'Express'; ?>
    <title>Pasarela de Pago - <?= $nombreCursoGA ?></title>
    <!-- Fuentes de ICC.com.pe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;500;600;700&family=League+Spartan:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendors/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/checkout.css?v=2.0">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- PayPal SDK (client-id=sb es para pruebas/sandbox, cÃ¡mbialo por tu Client ID de producciÃ³n) -->
    <script src="https://www.paypal.com/sdk/js?client-id=BAAqiauJCgNIFSWMjIrbxzcIlAn6mEzi0uhKYnoN48a_57G7zfy8kInsweY2544eHBiTuc8YQRZKsckGUw&currency=USD"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JPZGM0RZHW"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-JPZGM0RZHW');
    </script>

    <!-- Crisp Chat -->
    <script type="text/javascript">
      window.$crisp=[];
      window.CRISP_WEBSITE_ID="009b5415-0cf9-4522-9ba1-5d84c98c9006";
      (function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();
      
      // Ocultar el chat al inicio para que solo aparezca despuÃ©s de pagar
      $crisp.push(["do", "chat:hide"]);
    </script>
</head>

<body>
    <div class="checkout-container" x-data="checkoutApp()" x-init="init()">
        <div class="checkout-layout">

            <!-- Columna Izquierda: InformaciÃ³n de Compra del Curso -->
            <div class="course-column">
                <div>
                    <div class="brand" style="margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                        <img src="<?= BASE_URL ?>assets/images/logo_icc.png" alt="ICC Logo" style="max-height: 60px;">
                    </div>
                    
                    <!-- Video Promocional -->
                    <div class="video-container" style="margin-bottom: 25px; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
                        <!-- Video Placeholder (YouTube) -->
                        <iframe width="100%" height="315" :src="courseName.toLowerCase().includes('condensadores') ? 'https://www.youtube.com/embed/8TLJJCuo8Yg?rel=0' : (courseName.toLowerCase().includes('terminaciones') ? 'https://www.youtube.com/embed/EFj6mLwhkjg?rel=0' : (courseName.toLowerCase().includes('industrial') ? 'https://www.youtube.com/embed/lvb5RYvgjL0?rel=0' : (courseName.toLowerCase().includes('analizador') ? 'https://www.youtube.com/embed/h9UIxWA7_Lw?rel=0' : (courseName.toLowerCase().includes('canalizaciones') ? 'https://www.youtube.com/embed/HhwUmtNPrto?rel=0' : (courseName.toLowerCase().includes('empalmes') ? 'https://www.youtube.com/embed/EFwgRMFiN-A?rel=0' : (courseName.toLowerCase().includes('variadores') ? 'https://www.youtube.com/embed/r6lolq0LJhE?rel=0' : 'https://www.youtube.com/embed/7SMbMxs27K0?rel=0'))))))" title="Video Promocional" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display: block;"></iframe>
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
                            .accordion-content ul li::before { content: '\f00c'; font-family: 'Font Awesome 5 Free'; font-weight: 900; position: absolute; left: 0; font-size: 0.9rem; top: 2px; color: #10b981;}
                            .schedule-box { background: #f8fafc; border: 1px dashed #cbd5e1; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
                            .schedule-box h5 { margin-top: 0; margin-bottom: 10px; color: #0f172a; font-weight: 700; font-size: 1rem; }
                            .schedule-box ul li::before { content: 'ðŸ“…'; }
                        </style>

                        <!-- Dynamic Accordion based on DB data -->
                        <?php if (isset($data['cursoDB']) && $data['cursoDB']): 
                            $curso = $data['cursoDB'];
                        ?>
                        <div class="course-accordion" x-data="{ activeAccordion: 1 }" style="margin-top: 20px;">
                            <?php if (!empty($curso['resumen'])): ?>
                            <!-- Item 1: Resumen -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 1 }" @click="activeAccordion = activeAccordion === 1 ? null : 1">
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-bolt" style="color: #eab308; font-size: 1.1rem;"></i> Resumen del Curso</span>
                                    <span x-text="activeAccordion === 1 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 1" x-transition>
                                    <div style="line-height: 1.5;"><?= $curso['resumen'] ?></div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($curso['temas'])): ?>
                            <!-- Item 2: Temas Principales -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 2 }" @click="activeAccordion = activeAccordion === 2 ? null : 2">
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-network-wired" style="color: #3b82f6; font-size: 1.1rem;"></i> Temas Principales</span>
                                    <span x-text="activeAccordion === 2 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 2" x-transition style="display: none;">
                                    <?= $curso['temas'] ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($curso['beneficios'])): ?>
                            <!-- Item 3: Beneficios -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 3 }" @click="activeAccordion = activeAccordion === 3 ? null : 3">
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-award" style="color: #f59e0b; font-size: 1.1rem;"></i> Beneficios</span>
                                    <span x-text="activeAccordion === 3 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 3" x-transition style="display: none;">
                                    <?= $curso['beneficios'] ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($curso['programacion'])): ?>
                            <!-- Item 4: Programación -->
                            <div>
                                <button class="accordion-btn" :class="{ 'active': activeAccordion === 4 }" @click="activeAccordion = activeAccordion === 4 ? null : 4">
                                    <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-calendar-alt" style="color: #10b981; font-size: 1.1rem;"></i> Programación y Horarios</span>
                                    <span x-text="activeAccordion === 4 ? '−' : '+'" style="font-weight: bold; font-size: 1.2rem;"></span>
                                </button>
                                <div class="accordion-content" x-show="activeAccordion === 4" x-transition style="display: none;">
                                    <?= $curso['programacion'] ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px; color: #856404;">
                            No se encontraron detalles adicionales para este curso en la base de datos. Asegúrate de pasar el parámetro ?curso=NombreDelCurso
                        </div>
                        <?php endif; ?>
                <div class="promo-price-container" style="position: relative; margin-top: 30px; margin-bottom: 20px; background: #0f172a; border: 2px solid #3730a3; border-radius: 12px; padding: 35px 20px 25px; color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.4); transform: skew(-3deg);">
                    <!-- Etiqueta amarilla flotante -->
                    <div style="position: absolute; top: -15px; right: -10px; background: #facc15; color: #0f172a; padding: 6px 16px; border-radius: 6px; font-weight: 800; font-size: 0.95rem; transform: skew(3deg) rotate(5deg); box-shadow: 0 4px 10px rgba(0,0,0,0.2); border: 2px solid #0f172a; z-index: 10;">
                        <span style="display: block; font-size: 0.7rem; line-height: 1.2; text-transform: uppercase;">Precio Regular</span>
                        <?php if (isset(`$data['cursoDB']) && `$data['cursoDB']): ?>
                            <span style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6366f1; font-size: 1.1rem;" x-text="currency === 'PEN' ? 'S/ ' + (coursePrice * 1.5).toFixed(2) : 'US$ ' + (coursePrice * 1.5).toFixed(2)"></span>
                        <?php else: ?>
                            <span style="text-decoration: line-through; text-decoration-thickness: 2px; text-decoration-color: #6366f1; font-size: 1.1rem;" x-text="currency === 'PEN' ? 'S/ 135.00' : 'US$ 45.00'"></span>
                        <?php endif; ?>
                    </div>

                    <div style="transform: skew(3deg); text-align: center; width: 100%;">
                        <div style="text-transform: uppercase; font-size: 0.9rem; font-weight: 800; letter-spacing: 2px; color: #818cf8; margin-bottom: 5px;">Monto total a pagar</div>
                        <div style="font-size: 3.5rem; font-weight: 900; line-height: 1; text-shadow: 2px 2px 0px rgba(0,0,0,0.2);">
                            <span x-text="currencySymbol" style="font-size: 2rem; vertical-align: super; color: #818cf8;"></span>
                            <span x-text="coursePrice.toFixed(2)"></span>
                            <span class="price-currency" x-text="currency" style="font-size: 1.2rem; opacity: 0.8; vertical-align: baseline; color: #818cf8;">PEN</span>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Confianza / Contacto -->
                <div class="trust-signals" style="margin-top: 20px; background: #0f172a; border-radius: 12px; padding: 25px 20px; text-align: center; color: white; box-shadow: 0 10px 25px rgba(15,23,42,0.4);">
                    <h4 style="margin-top: 0; margin-bottom: 20px; font-size: 0.95rem; color: #cbd5e1; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">ComunÃ­cate con nuestros asesores</h4>
                    
                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-bottom: 25px;">
                        <a href="https://wa.me/51941208020" target="_blank" aria-label="WhatsApp" style="background-color: #25D366; color: white; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.4rem;"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=61570845450403" target="_blank" aria-label="Facebook" style="background-color: #1877F2; color: white; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.3rem;"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.tiktok.com/@icc_capacitaciones_int" target="_blank" aria-label="TikTok" style="background-color: #000000; color: white; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.3rem;"><i class="fab fa-tiktok"></i></a>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px; border-top: 1px solid #334155; padding-top: 25px;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px;">
                            <div style="width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #3b82f6;">
                                <i class="fas fa-phone-alt" style="color: #3b82f6; font-size: 1.2rem;"></i>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Agente de mensajes</div>
                                <div style="font-size: 1.15rem; font-weight: 700; color: white;">+51 941 208 020</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 15px;">
                            <div style="width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #3b82f6;">
                                <i class="fas fa-envelope" style="color: #3b82f6; font-size: 1.2rem;"></i>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Agente de mensajes</div>
                                <div style="font-size: 1.15rem; font-weight: 700; color: white;">informes@icc.com.pe</div>
                            </div>
                        </div>
                        
                        <!-- Sitio web -->
                        <div style="margin-top: 5px;">
                            <a href="https://icc.com.pe/" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); transition: all 0.3s ease;">
                                <i class="fas fa-globe" style="font-size: 1.2rem; margin-right: 10px;"></i>
                                icc.com.pe
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Opciones de Pago -->
            <div class="payment-column">
                <div x-show="!paymentSuccess" x-transition>
                    <div class="payment-header">
                    <h2>MÃ©todo de Pago</h2>
                </div>

                <!-- Tabs para alternar entre mÃ©todos de pago -->
                <div class="payment-tabs">
                    <button class="tab-btn" x-show="currency === 'PEN'" :class="{ 'active': activeTab === 'manual' }" @click="setTab('manual')">
                        ðŸ“± Yape / Plin
                    </button>
                    <button class="tab-btn" :class="{ 'active': activeTab === 'paypal' }" @click="setTab('paypal')">
                        ðŸ’³ PayPal / Tarjeta
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
                                <img :src="manualDetails[manualMethod]?.qrUrl" alt="CÃ³digo QR" class="qr-image" style="max-width: 220px; max-height: 280px; width: auto; height: auto; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); object-fit: contain;">
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
                                <input type="text" x-model="celular" placeholder="NÃºmero de celular / WhatsApp" class="form-control" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid var(--surface-border); border-radius: 8px;" required>
                            </div>

                            <div class="voucher-section">
                                <div class="file-upload-box" @click="document.getElementById('voucher_upload').click()">
                                    <span class="file-upload-label" id="file_label"
                                        x-text="voucherFile ? 'âœ“ ' + voucherFile.name : 'Subir captura o foto del voucher' "></span>
                                    <input type="file" id="voucher_upload" style="display: none;"
                                        @change="voucherFile = $event.target.files[0]" accept="image/*,application/pdf">
                                </div>
                            </div>

                            <button @click="submitManualPayment()" id="btn_submit_manual" class="btn-submit" :disabled="!voucherFile">
                                Confirmar mi inscripciÃ³n
                            </button>
                        </div>
                    </div>

                    <!-- Vista PayPal -->
                    <div class="paypal-view" x-show="activeTab === 'paypal'" x-transition>
                        <p class="paypal-instructions">
                            Inicia sesiÃ³n en tu cuenta de PayPal o procesa el pago de forma segura con tarjeta de
                            crÃ©dito/dÃ©bito en dÃ³lares.
                        </p>

                        <template x-if="currency === 'PEN'">
                            <p
                                style="font-size: 0.85rem; color: var(--text-secondary); text-align: center; margin-bottom: 15px;">
                                (Equivalente para PayPal: <strong style="color: var(--text-primary);"
                                    x-text="'$' + amountInUSD.toFixed(2) + ' USD'"></strong> al cambio de <span
                                    x-text="tipoCambio"></span>)
                            </p>
                        </template>

                        <!-- Contenedor del BotÃ³n Inteligente de PayPal -->
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
                        EncriptaciÃ³n SSL 256-bit
                    </div>
                </div>
                </div> <!-- End of !paymentSuccess -->

                <!-- Vista de Ã‰xito y Rastreador de Progreso -->
                <div class="success-view" x-show="paymentSuccess" x-transition style="display: none; text-align: center; padding: 40px 20px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                    <div style="font-size: 3.5rem; color: #10b981; margin-bottom: 10px; line-height: 1;">âœ…</div>
                    <h3 style="color: #0f172a; margin-bottom: 15px; font-size: 1.5rem; font-weight: 700;">Â¡Voucher recibido con Ã©xito!</h3>
                    <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 35px;">Estamos procesando tu inscripciÃ³n. Sigue el estado de tu trÃ¡mite:</p>

                    <!-- Progress Tracker -->
                    <div class="progress-tracker" style="display: flex; justify-content: space-between; position: relative; margin-bottom: 40px; max-width: 400px; margin-left: auto; margin-right: auto;">
                        <!-- Line -->
                        <div style="position: absolute; top: 15px; left: 16%; right: 16%; height: 4px; background: #e2e8f0; z-index: 1;">
                            <div style="width: 50%; height: 100%; background: #10b981; transition: width 1s ease-in-out;"></div>
                        </div>

                        <!-- Step 1 -->
                        <div style="position: relative; z-index: 2; text-align: center; width: 33%;">
                            <div style="width: 34px; height: 34px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold; border: 4px solid white; box-shadow: 0 0 0 2px #10b981;">âœ“</div>
                            <div style="font-size: 0.75rem; font-weight: 700; color: #10b981; line-height: 1.2;">Pago<br>Enviado</div>
                        </div>

                        <!-- Step 2 -->
                        <div style="position: relative; z-index: 2; text-align: center; width: 33%;">
                            <div style="width: 34px; height: 34px; background: white; color: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold; border: 4px solid #f59e0b; font-size: 1rem;">â³</div>
                            <div style="font-size: 0.75rem; font-weight: 700; color: #f59e0b; line-height: 1.2;">Validando<br>InscripciÃ³n</div>
                        </div>

                        <!-- Step 3 -->
                        <div style="position: relative; z-index: 2; text-align: center; width: 33%;">
                            <div style="width: 34px; height: 34px; background: white; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold; border: 4px solid #cbd5e1;">3</div>
                            <div style="font-size: 0.75rem; font-weight: 600; color: #94a3b8; line-height: 1.2;">Accesos<br>Enviados</div>
                        </div>
                    </div>

                    <template x-if="paymentMethodUsed === 'manual'">
                        <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 20px;">
                            <h4 style="margin-top: 0; color: #0f172a; margin-bottom: 10px; font-size: 1.1rem; font-weight: 700;">âš ï¸ Siguiente paso obligatorio</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin-bottom: 20px;">Para agilizar la validaciÃ³n y enviarte tus accesos de inmediato, haz clic en el botÃ³n de abajo y envÃ­anos un mensaje por WhatsApp confirmando tus datos.</p>
                            <a href="https://wa.me/51941208020?text=Hola,%20acabo%20de%20subir%20mi%20voucher%20para%20el%20curso.%20Mis%20nombres%20son:" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; background: #25D366; color: white; padding: 14px 28px; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 1.05rem; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3); transition: transform 0.2s ease;">
                                <span style="font-size: 1.2rem; margin-right: 8px;">ðŸ’¬</span> Escribir a WhatsApp
                            </a>
                        </div>
                    </template>
                    
                    <template x-if="paymentMethodUsed === 'paypal'">
                        <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 20px;">
                            <h4 style="margin-top: 0; color: #0f172a; margin-bottom: 10px; font-size: 1.1rem; font-weight: 700;">âœ… Â¡Todo listo!</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin-bottom: 20px;">Tu pago por PayPal ha sido recibido exitosamente. En un momento, recibirÃ¡s tus credenciales. (Puedes comunicarte con nosotros desde el chat de soporte abajo a la derecha).</p>
                            <button @click="$crisp.push(['do', 'chat:show']); $crisp.push(['do', 'chat:open']);" type="button" style="display: inline-flex; align-items: center; justify-content: center; background: #3730a3; color: white; padding: 14px 28px; border-radius: 30px; border: none; font-weight: 700; font-size: 1.05rem; box-shadow: 0 4px 12px rgba(55, 48, 163, 0.3); transition: transform 0.2s ease; cursor: pointer;">
                                <span style="font-size: 1.2rem; margin-right: 8px;">ðŸ’¬</span> Abrir Chat de Soporte
                            </button>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

    <!-- Generador de Enlaces de Pago para AdministraciÃ³n (TikTok y Ofertas Especiales) -->
    <!-- Solo se muestra si aÃ±ades ?admin=true a la URL -->
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
                    <option value="USD">DÃ³lares (USD)</option>
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


    <!-- Script de ConfiguraciÃ³n de la Pasarela -->
    <script>
        function checkoutApp() {
            return {
                paymentSuccess: false,
                paymentMethodUsed: null,
                // Estado dinÃ¡mico cargado desde la URL
                courseName: '',
                coursePrice: 30.00,
                currency: 'USD',

                // Tipo de cambio para conversiones USD <-> PEN
                tipoCambio: 3.80,

                // PestaÃ±a activa ('manual' o 'paypal')
                activeTab: 'manual',

                // SubmÃ©todo manual activo ('yape' o 'plin')
                manualMethod: 'yape',
                voucherFile: null,

                // Datos del estudiante
                dni: '',
                nombre: '',
                apellido: '',
                celular: '',

                // Datos de Yape y Plin (Ajusta tus datos reales aquÃ­)
                manualDetails: {
                    yape: {
                        title: 'Pago con Yape',
                        qrUrl: '<?= BASE_URL ?>assets/images/Yape.jpg',
                        color: '#7400b8',
                        name: 'Mariela Ma.'
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
                    // 1. Cargar parÃ¡metros desde la URL
                    const urlParams = new URLSearchParams(window.location.search);
                    this.courseName = urlParams.get('curso') || 'Curso Completo de Marketing y Ventas';
                    this.currency = (urlParams.get('moneda') || 'USD').toUpperCase();
                    
                    <?php if (isset($data['cursoDB']) && $data['cursoDB']): ?>
                        if (this.currency === 'PEN') {
                            this.coursePrice = <?= $data['cursoDB']['precio'] ?: 'parseFloat(urlParams.get("precio")) || 89.90' ?>;
                        } else {
                            this.coursePrice = <?= $data['cursoDB']['precio_usd'] ?: 'parseFloat(urlParams.get("precio")) || 30.00' ?>;
                        }
                    <?php else: ?>
                        this.coursePrice = parseFloat(urlParams.get('precio')) || 30.00;
                    <?php endif; ?>
                    this.currency = (urlParams.get('moneda') || 'USD').toUpperCase();

                    // Si la moneda es USD, abrimos PayPal por defecto, si es PEN abrimos Yape/Plin por defecto
                    this.activeTab = this.currency === 'USD' ? 'paypal' : 'manual';

                    // Renderizamos los botones si la pestaÃ±a inicial es PayPal
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
                            this.paymentSuccess = true;
                            this.paymentMethodUsed = 'manual';
                            this.voucherFile = null;
                            
                            // META PIXEL: Rastrear Compra
                            if (typeof fbq === 'function') {
                                fbq('track', 'Purchase', {
                                    value: this.coursePrice,
                                    currency: this.currency,
                                    content_name: this.courseName
                                });
                            }
                            
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            alert('OcurriÃ³ un error: ' + (data.error || 'Error desconocido'));
                            btn.disabled = false;
                            btn.innerText = 'Confirmar mi inscripciÃ³n';
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        alert('Error de conexiÃ³n al subir el voucher. Intenta nuevamente.');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerText = 'Confirmar mi inscripciÃ³n';
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
                                self.paymentSuccess = true;
                                self.paymentMethodUsed = 'paypal';
                                
                                // META PIXEL: Rastrear Compra
                                if (typeof fbq === 'function') {
                                    fbq('track', 'Purchase', {
                                        value: self.coursePrice,
                                        currency: self.currency,
                                        content_name: self.courseName
                                    });
                                }
                                
                                if (typeof $crisp !== 'undefined') {
                                    $crisp.push(["do", "chat:show"]);
                                    setTimeout(() => $crisp.push(["do", "chat:open"]), 500);
                                }
                                window.scrollTo({ top: 0, behavior: 'smooth' });
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
                    // El panel solo es visible si aÃ±adimos ?admin=true en la URL
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
                    copyText.setSelectionRange(0, 99999); // Para mÃ³viles

                    navigator.clipboard.writeText(copyText.value)
                        .then(() => {
                            alert("Â¡Enlace de pago copiado al portapapeles! Ya puedes enviarlo por WhatsApp o redes sociales.");
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
