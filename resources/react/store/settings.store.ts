import { create } from "zustand";
import type { ISettingsData } from "../interfaces/ISettingsData";

interface ISettingsStore {
  settings: ISettingsData | null;
  loaded: boolean;
  loading: boolean;
  setSettings: (data: ISettingsData) => void;
  setLoading: (loading: boolean) => void;
}

export const useSettingsStore = create<ISettingsStore>((set) => ({
  settings: null,
  loaded: false,
  loading: false,
  setSettings: (data) => set({ settings: data, loaded: true, loading: false }),
  setLoading: (loading) => set({ loading }),
}));
