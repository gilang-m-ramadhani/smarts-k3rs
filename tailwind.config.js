/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      boxShadow: {
        'sm': '0 1px 2px rgba(0, 77, 38, 0.05)',
        'md': '0 4px 12px rgba(0, 77, 38, 0.08)',
      }
    },
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [
      {
        smartk3: {
          // PRIMARY: Hijau (#00A651)
          "primary": "#00A651",
          "primary-content": "#ffffff",
          
          // SECONDARY: Hijau Gelap (#004D26)
          "secondary": "#004D26",
          "secondary-content": "#ffffff",
          
          // ACCENT: Oranye (#F7931D)
          "accent": "#F7931D",
          "accent-content": "#ffffff", 
          
          // SUCCESS: Hijau (#00A651)
          "success": "#00A651",
          "success-content": "#ffffff",
          
          // WARNING: Oranye (#F7931D)
          "warning": "#F7931D",
          "warning-content": "#ffffff",
          
          // ERROR: Merah standar (tetap dipertahankan untuk standar UI error)
          "error": "#EF4444",
          "error-content": "#ffffff",
          
          // INFO: Hijau Muda/Mint (#E6F7EE)
          "info": "#E6F7EE",
          "info-content": "#004D26", // Menggunakan hijau gelap agar teks kontras dan terbaca di atas background terang
          
          // NEUTRAL & BASE (Tetap dipertahankan struktur awalnya)
          "neutral": "#374151",
          "neutral-content": "#F3F4F6",
          "base-100": "#FFFFFF",
          "base-200": "#F9F9FC", 
          "base-300": "#EDEDF2",
          "base-content": "#1F2937",
        },
      },
      "light",
      "dark",
    ],
    darkTheme: "dark",
  },
};