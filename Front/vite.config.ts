import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import react from "@vitejs/plugin-react";
import fs from "fs";
import path from "path";

// Function to read base URL from parent .env
function getBaseUrl() {
  try {
    const dotenvPath = path.resolve(__dirname, "../.env");
    if (fs.existsSync(dotenvPath)) {
      const dotenvContent = fs.readFileSync(dotenvPath, "utf-8");
      const appUrlMatch = dotenvContent.match(/^APP_URL=(.+)$/m);
      if (appUrlMatch) {
        const appUrl = appUrlMatch[1].trim();
        const url = new URL(appUrl);
        // Ensure it ends with a slash
        let pathname = url.pathname;
        if (!pathname.endsWith("/")) {
          pathname += "/";
        }
        return pathname;
      }
    }
  } catch (e) {
    console.error("Failed to read APP_URL from parent .env", e);
  }
  return "/";
}

const base = getBaseUrl();

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
