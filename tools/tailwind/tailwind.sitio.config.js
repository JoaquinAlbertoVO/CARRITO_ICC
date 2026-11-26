/**
 * CSS de la web publica (assets/css/sitio.css): misma paleta y tipografias que el checkout v2
 * (tailwind.config.js). Cada pagina que se pasa a layouts/sitio.php se agrega a "content".
 * Uso: npm run build:sitio
 */
const base = require('./tailwind.config.js');
module.exports = {
  ...base,
  content: [
    '../../app/Views/layouts/sitio.php',
    '../../app/Views/home/**/*.php',
    '../../app/Views/partials/**/*.php',
    '../../app/Views/cursos/*.php',
    '../../app/Views/nosotros/**/*.php',
    '../../app/Views/contacto/**/*.php',
    '../../app/Views/verificar/index.php',
    '../../app/Views/legal/**/*.php',
    '../../app/Views/tienda/**/*.php',
    '../../app/Views/checkout/index.php',
  ],
  theme: {
    extend: {
      ...base.theme.extend,
      keyframes: {
        flotar: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-14px)' } },
      },
      animation: {
        flotar: 'flotar 4s ease-in-out infinite',
      },
    },
  },
};
