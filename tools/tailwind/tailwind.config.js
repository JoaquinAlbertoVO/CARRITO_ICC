/** Paleta tomada del boceto de Stitch. Compila solo lo que usa checkout/v2.php. */
module.exports = {
  content: ['../../app/Views/checkout/v2.php'],
  theme: {
    extend: {
      colors: {
        navy: '#0e1c2f',
        ink: '#0b1c30',
        brand: '#0154ca',
        'brand-soft': '#346fe4',
        surface: '#f8f9ff',
        mist: '#eff4ff',
        mist2: '#e5eeff',
        line: '#c5c6cd',
        muted: '#44474c',
        accent: '#facc15',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
