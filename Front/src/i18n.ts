import i18n from "i18next";
import { initReactI18next } from "react-i18next";
import HttpBackend from "i18next-http-backend";

const savedLang = localStorage.getItem("language") || "ar";

function getBase() {
  const envBase = import.meta.env.BASE_URL ?? "/";
  if (typeof window !== "undefined") {
    const currentPath = window.location.pathname;
    const cleanEnv = envBase.replace(/\/+$/, "");
    if (cleanEnv && cleanEnv !== "/" && currentPath.toLowerCase().startsWith(cleanEnv.toLowerCase())) {
      const matched = currentPath.slice(0, cleanEnv.length);
      return matched.endsWith("/") ? matched : `${matched}/`;
    }
  }
  return envBase.endsWith("/") ? envBase : `${envBase}/`;
}

const cleanBase = getBase();

i18n
  .use(HttpBackend)
  .use(initReactI18next)
  .init({
    lng: savedLang,
    fallbackLng: "en",
    debug: false,
    backend: {
      loadPath: `${cleanBase}locales/{{lng}}.json`,
    },
    interpolation: {
      escapeValue: false,
    },
  });

export default i18n;
