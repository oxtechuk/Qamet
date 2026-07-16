import { create } from "zustand";
import type { LanguageFlags, LanguageType, TextDirection } from "../types/language.types";
import i18n from "../i18n";
import { queryClient } from "../lib/query-client";

const FALLBACK_LANGUAGE: LanguageType = "en";

const languageFlags: LanguageFlags = {
  en: "/icons/united-states-flag-icon.svg",
  ar: "/icons/egypt-flag-icon.svg",
};

const getStoredLanguage = (): LanguageType => {
  const lang = localStorage.getItem("language") || "ar";
  return lang in languageFlags ? (lang as LanguageType) : FALLBACK_LANGUAGE;
};

const applyLanguageSettings = (language: LanguageType): void => {
  const direction: TextDirection = language === "en" ? "ltr" : "rtl";
  document.documentElement.setAttribute("lang", language);
  document.documentElement.setAttribute("dir", direction);
  i18n.changeLanguage(language);
};

const storedLanguage = getStoredLanguage();
applyLanguageSettings(storedLanguage);

type LanguageStore = {
  language: LanguageType;
  direction: TextDirection;
  flag: string;
  flags: LanguageFlags;
  loading: boolean;
  setLanguage: (lang: LanguageType) => void;
  setLoading: (state: boolean) => void;
};

export const useLanguageStore = create<LanguageStore>((set) => ({
  language: storedLanguage,
  direction: storedLanguage === "en" ? "ltr" : "rtl",
  flag: languageFlags[storedLanguage],
  flags: languageFlags,
  loading: false,

  setLanguage: (newLanguage) => {
    set({ loading: true });
    const direction = newLanguage === "en" ? "ltr" : "rtl";
    const flag = languageFlags[newLanguage];
    localStorage.setItem("language", newLanguage);
    applyLanguageSettings(newLanguage);
    set({ language: newLanguage, direction, flag, loading: false });
    queryClient.invalidateQueries();
  },

  setLoading: (state: boolean) => set({ loading: state }),
}));
