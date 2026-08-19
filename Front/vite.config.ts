import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import react from "@vitejs/plugin-react";
import fs from "fs";
import path from "path";

// Default base URL for production is root "/"
// Can be overridden with VITE_BASE_URL if needed
const base = process.env.VITE_BASE_URL || "/";

export default defineConfig({
  base: base,
 plugins: [react(), tailwindcss()],
  server: {
    port: 5156,
  },
  build: {
    outDir: "../public",
    assetsDir: "assets/store",
    emptyOutDir: false,
  },
});
