export const API_PROTOCOL = import.meta.env.VITE_API_PROTOCOL ?? "http";
export const API_HOST = import.meta.env.VITE_API_HOST ?? "";
export const API_PORT = import.meta.env.VITE_API_PORT ?? "";
export const API_BASE_PATH = import.meta.env.VITE_API_BASE_PATH ?? "api";

const isLocalDev = Boolean(API_HOST && API_HOST.trim() !== "");
const portPart = API_PORT ? `:${API_PORT}` : "";
export const API_BASE_URL = isLocalDev
  ? `${API_PROTOCOL}://${API_HOST}${portPart}/${API_BASE_PATH}/`
  : `/${API_BASE_PATH}/`;

export const API_ORIGIN = isLocalDev
  ? `${API_PROTOCOL}://${API_HOST}${portPart}`
  : "";

export const API_TIMEOUT = 30000;
