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
    },
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [
      {
        smartk3: {
          // PRIMARY: Ungu (#662D91) – BUKAN HIJAU
          "primary": "#662D91",
          "primary-content": "#ffffff",
          // SECONDARY: Pink (#EC008C)
          "secondary": "#EC008C",
          "secondary-content": "#ffffff",
          // ACCENT: Oranye (#F7931D)
          "accent": "#F7931D",
          "accent-content": "#000000", // kontras biar terbaca
          // SUCCESS: Hijau (#00A651)
          "success": "#00A651",
          "success-content": "#ffffff",
          // WARNING: Oranye (sama dengan accent)
          "warning": "#F7931D",
          "warning-content": "#000000",
          // ERROR: Merah standar (tetap kontras)
          "error": "#EF4444",
          "error-content": "#ffffff",
          // INFO: Ungu muda
          "info": "#8A5EB8",
          "info-content": "#ffffff",
          // NEUTRAL & BASE
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