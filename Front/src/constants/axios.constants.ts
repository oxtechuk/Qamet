export const API_PROTOCOL = import.meta.env.VITE_API_PROTOCOL ?? "http";
export const API_HOST = import.meta.env.VITE_API_HOST ?? "";
export const API_PORT = import.meta.env.VITE_API_PORT ?? "";
export const API_BASE_PATH = import.meta.env.VITE_API_BASE_PATH ?? "api";

const isLocalDev = Boolean(API_HOST && API_HOST.trim() !== "");
const portPart = API_PORT ? `:${API_PORT}` : "";

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

export const API_BASE_URL = isLocalDev
  ? `${API_PROTOCOL}://${API_HOST}${portPart}/${API_BASE_PATH}/`
  : `${cleanBase}${API_BASE_PATH}/`;

export const API_ORIGIN = isLocalDev
  ? `${API_PROTOCOL}://${API_HOST}${portPart}`
  : "";

export const API_TIMEOUT = 30000;
