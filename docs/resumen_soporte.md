# Resumen de Soporte y Solución de Errores

**Fecha:** 30 de Junio de 2026
**Proyecto:** Web del Instituto de Capacitación Continua (ICC)

Este documento es un registro de todas las configuraciones, mejoras y correcciones realizadas en la plataforma para futuras referencias.

## 1. Rediseño y Experiencia de Usuario (UX)
- **Mejora en Celulares (Responsivo):** Se corrigió la cabecera en dispositivos móviles. El logotipo ya no se ve diminuto y se arregló un problema donde el menú desplegable (hamburguesa) quedaba oculto por debajo de los iconos de redes sociales (problema de `z-index`).
- **Reordenamiento de Inicio (`index.php`):** Siguiendo principios de UX orientados a ventas, se movió la cuadrícula de los Cursos (Ingeniería y Derecho) a la parte superior de la página, inmediatamente debajo del banner principal.
- **Limpieza de Código:** Se eliminó un bloque de código roto y vacío (Video One) que dejaba un hueco blanco gigante a mitad de la página.

## 2. Corrección de Bugs y Estilos
- **Bug del Menú "Fantasma":** El Mega Menú desplegable se abría por accidente al pasar el mouse por debajo de la barra negra. 
  - *Solución:* Se inyectó CSS (`pointer-events: none;`) para que el menú cerrado sea completamente transparente al ratón, y solo responda (`pointer-events: auto;`) al estar estrictamente encima de la palabra "Ingeniería Eléctrica".
- **Bug del Espacio Blanco Superior:** Aparecía una franja blanca gruesa en el tope superior del navegador, bajando toda la página. 
  - *Solución:* Los archivos `index.php` y `index/head.php` tenían un carácter invisible de codificación llamado UTF-8 BOM. Se procesaron los archivos para limpiar ese código fantasma, permitiendo que la web encaje de nuevo en el tope.

## 3. Despliegue en cPanel y Solución de Error 404 (TikTok)
- **Problema:** El enlace del modal de TikTok daba error 404 Not Found porque dirigía a `CARRITO_PRE/index.html`. Al conectar GitHub por primera vez a cPanel, se descargó por accidente toda la página web principal dentro de `CARRITO_PRE`, pisando y ocultando el archivo del carrito de compras original que Joaquín había creado.
- **La Solución Implementada:** 
  1. Se entró a la carpeta `/public_html/CARRITO_PRE/` y se movieron todos los archivos del rediseño (incluyendo la carpeta oculta `.git`) hacia la raíz de la web: `/public_html/`. ¡Esto actualizó la página en vivo!
  2. Se renombró la carpeta de respaldo `CARRITO_PRE_VIEJO` devolviéndole su nombre a `CARRITO_PRE`. Esto restauró los archivos manuales originales (`index.html`, `process_payment.php`), reviviendo inmediatamente el carrito de compras de TikTok.
  3. **A futuro:** Como la carpeta `.git` ahora vive en `/public_html/`, esa carpeta raíz ya es oficialmente un repositorio de GitHub. Si se hacen más cambios a futuro, basta con conectar cPanel Git Version Control directamente a `public_html` para actualizar con un solo clic.

---
*Este documento fue autogenerado por tu Asistente de IA (Antigravity) como bitácora de desarrollo. Puedes consultarlo en GitHub en cualquier momento.*
