import axios from "axios";
import { API_BASE_URL, API_TIMEOUT } from "../../constants/axios.constants";
import { useLanguageStore } from "../../store/language.store";

const api = axios.create({
  baseURL: API_BASE_URL,
  timeout: API_TIMEOUT,
  headers: {
    "Content-Type": "application/json",
  },
  paramsSerializer: {
    indexes: false,
  },
});

api.interceptors.request.use(
  (config) => {
    const language = useLanguageStore.getState().language;
    if (language) {
      config.headers["Accept-Language"] = language;
    }

    const token = sessionStorage.getItem("access_token");
    if (token && config.headers) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
  },
  (error) => Promise.reject(error)
);

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (!error.response) {
      return Promise.reject(error);
    }
    return Promise.reject(error);
  }
);

export default api;
