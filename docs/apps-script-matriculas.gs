/**
 * Registro de matriculas de ICC en Google Sheets (Apps Script, web app).
 *
 * El sitio (app/Helpers/Mailer.php -> registrarEnSheets) hace un POST con los datos de cada
 * matricula / pago y este script agrega una fila a la hoja "Matrículas".
 *
 * Instalacion: ver el final de este archivo.
 */

// Debe ser IGUAL a SHEETS_WEBHOOK_TOKEN del .env del servidor. Cambialo por una clave larga y propia.
const TOKEN = 'CAMBIA_ESTE_TOKEN';
const HOJA  = 'Matrículas';
const COLUMNAS = ['Fecha', 'Estado', 'Medio de pago', 'Alumno', 'Documento', 'Correo', 'Celular/WhatsApp',
                  'Curso', 'Monto', 'Moneda', 'Referencia/orden', 'Verificado', 'Notas'];

function doPost(e) {
  const lock = LockService.getScriptLock();
  try {
    const d = JSON.parse(e.postData.contents);
    if (d.token !== TOKEN) return salida({ ok: false, error: 'token' });

    lock.waitLock(15000);
    const ss = SpreadsheetApp.getActiveSpreadsheet();
    let sh = ss.getSheetByName(HOJA);
    if (!sh) {
      sh = ss.insertSheet(HOJA);
      sh.appendRow(COLUMNAS);
      sh.setFrozenRows(1);
      sh.getRange(1, 1, 1, COLUMNAS.length).setFontWeight('bold').setBackground('#e0e7ff');
    }

    // Si Hotmart/PayPal reintentan el aviso, no se duplica la fila (misma referencia y estado)
    const ref = String(d.referencia || '');
    if (ref && sh.getLastRow() > 1) {
      const refs = sh.getRange(2, 11, sh.getLastRow() - 1, 1).getValues();
      const estados = sh.getRange(2, 2, sh.getLastRow() - 1, 1).getValues();
      for (let i = 0; i < refs.length; i++) {
        if (String(refs[i][0]) === ref && String(estados[i][0]) === String(d.estado || '')) {
          return salida({ ok: true, duplicado: true });
        }
      }
    }

    const fila = [
      d.fecha || '', d.estado || '', d.metodo || '', d.nombre || '',
      d.documento || 'No indicó (extranjero)', d.correo || '', d.celular || '',
      d.curso || '', d.monto || '', d.moneda || '', ref,
      '', ''   // Verificado / Notas: los llenan los asesores a mano
    ];
    const n = sh.getLastRow() + 1;
    // Todo como texto: conserva ceros a la izquierda y el "+" de los celulares, y evita formulas
    sh.getRange(n, 1, 1, fila.length).setNumberFormat('@').setValues([fila]);
    return salida({ ok: true });
  } catch (err) {
    return salida({ ok: false, error: String(err) });
  } finally {
    try { lock.releaseLock(); } catch (x) {}
  }
}

function salida(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj)).setMimeType(ContentService.MimeType.JSON);
}

/*
 * INSTALACION (una sola vez, con la cuenta de Google de los asesores o de ICC):
 * 1. Crear un Google Sheets nuevo (ej. "Matrículas ICC") y compartirlo con los asesores.
 * 2. Menu Extensiones > Apps Script. Borrar lo que haya y pegar este archivo completo.
 * 3. Cambiar TOKEN por una clave larga inventada (la misma ira en el .env del servidor).
 * 4. Implementar > Nueva implementacion > tipo "Aplicacion web".
 *      Ejecutar como: Yo   |   Quien tiene acceso: Cualquier persona
 *    Autorizar los permisos que pida Google y copiar la URL que termina en /exec.
 * 5. En el .env del servidor (cPanel > Administrador de archivos > public_html/.env) agregar:
 *      SHEETS_WEBHOOK_URL=<la URL /exec>
 *      SHEETS_WEBHOOK_TOKEN=<el mismo TOKEN>
 * Si luego se edita el script hay que Implementar > Administrar implementaciones > Editar > Nueva version
 * (la URL /exec se mantiene).
 */
