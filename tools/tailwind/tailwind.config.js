/**
 * Paleta tomada de la pieza "Horario de clases" de ICC: azul real, azul marino, verde lima y blanco.
 * Compila solo lo que usa checkout/v2.php.
 */
module.exports = {
  content: ['../../app/Views/checkout/v2.php'],
  theme: {
    extend: {
      colors: {
        brand: '#0050f4',       // azul electrico (botones, encabezados de ficha)
        'brand-dark': '#0049b7', // azul de fondo
        deep: '#061660',        // azul marino (texto fuerte, pie)
        ink: '#0a1640',
        surface: '#f5f7fb',
        mist: '#e8eefb',
        line: '#c9d3ea',
        muted: '#4b5573',
        accent: '#cddd32',      // verde lima
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
