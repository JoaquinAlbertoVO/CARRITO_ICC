/** Paleta de la marca ICC (azul de la portada y del logo, amarillo del multimetro de la mascota). */
module.exports = {
  content: ['../../app/Views/checkout/v2.php'],
  theme: {
    extend: {
      colors: {
        brand: '#2559a2',
        'brand-dark': '#153f89',
        deep: '#0f2f68',
        ink: '#0b1c30',
        surface: '#f5f8fd',
        mist: '#eaf1fb',
        line: '#c5d0e2',
        muted: '#4a5568',
        accent: '#ffc21a',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
      },
      keyframes: {
        float: { '0%,100%': { transform: 'translateY(0) rotate(0deg)' }, '50%': { transform: 'translateY(-14px) rotate(6deg)' } },
        ping2: { '0%': { transform: 'scale(1)', opacity: '.55' }, '100%': { transform: 'scale(1.12)', opacity: '0' } },
      },
      animation: {
        float: 'float 6s ease-in-out infinite',
        ping2: 'ping2 1.8s ease-out infinite',
      },
    },
  },
  plugins: [],
};
