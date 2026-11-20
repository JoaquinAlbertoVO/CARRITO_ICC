/**
 * CSS del aula virtual y de la tienda de packs (assets/css/aula.css). Misma paleta que el checkout v2
 * (tailwind.config.js): azul ICC, azul marino y verde lima. Uso: npm run build:aula
 */
const base = require('./tailwind.config.js');
module.exports = {
  ...base,
  content: [
    '../../app/Views/aula/**/*.php',
    '../../app/Views/tienda/**/*.php',
    '../../app/Views/layouts/aula.php',
    '../../app/Views/layouts/tienda.php',
  ],
};
