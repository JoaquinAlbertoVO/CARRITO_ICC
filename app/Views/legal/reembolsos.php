<?php
/** Políticas de Reembolso (estilo checkout v2, layouts/sitio.php). El texto legal no se cambio en el rediseño. */
$cab = [
    'titulo' => 'Políticas de Reembolso',
    'etiqueta' => 'Legal',
    'migas' => [['Inicio', ''], ['Reembolsos', null]],
];
require __DIR__ . '/../partials/cabecera_pagina.php';
?>
<section class="bg-surface pb-16 pt-4">
    <div class="texto-legal mx-auto max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5 sm:p-10">
        <p><strong>Última actualización:</strong> <?= date('d/m/Y') ?></p>

        <h2>1. Condiciones Generales</h2>
        <p>En el Instituto de Capacitación Continua (ICC) nos comprometemos a brindar educación de alta calidad. Si no estás satisfecho con tu compra, tienes derecho a solicitar un reembolso dentro de los plazos establecidos, siempre y cuando se cumplan las siguientes condiciones:</p>
        <ul>
            <li>La solicitud debe realizarse dentro de los primeros <strong>7 días calendario</strong> posteriores a la fecha de compra o acceso al curso.</li>
            <li>No debes haber completado más del <strong>20%</strong> del contenido del curso (videos visualizados, materiales descargados).</li>
            <li>No debes haber generado ni descargado el certificado de finalización del curso.</li>
        </ul>

        <h2>2. Cursos en Vivo o Seminarios</h2>
        <p>Para capacitaciones que se dicten en modalidad "En Vivo" (Zoom, Google Meet, presencial), el reembolso sólo podrá ser solicitado hasta <strong>48 horas antes</strong> del inicio de la primera sesión. Una vez iniciado el curso, no habrá lugar a devoluciones de dinero.</p>

        <h2>3. Proceso de Solicitud</h2>
        <p>Para solicitar un reembolso, debes enviar un correo electrónico a <a href="mailto:informes@icc.com.pe">informes@icc.com.pe</a> o contactar a nuestro número de WhatsApp de soporte técnico adjuntando lo siguiente:</p>
        <ul>
            <li>Nombre completo y número de documento.</li>
            <li>Correo electrónico registrado en la plataforma.</li>
            <li>Comprobante de pago o número de transacción.</li>
            <li>Motivo detallado de la solicitud.</li>
        </ul>

        <h2>4. Tiempo de Procesamiento</h2>
        <p>Una vez evaluada tu solicitud, te enviaremos una respuesta en un plazo no mayor a <strong>3 días hábiles</strong>. De ser aprobada, el reembolso se procesará a través del mismo método de pago utilizado (Tarjeta de Crédito/Débito, MercadoPago o transferencia bancaria). Dependiendo de tu entidad bancaria, el saldo podría verse reflejado en tu cuenta en un plazo adicional de 5 a 15 días hábiles.</p>
    
    </div>
</section>
