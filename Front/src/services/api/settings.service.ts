import type { ISettingsData } from "../../interfaces/ISettingsData";
import api from "./http";

export async function getSettings(): Promise<ISettingsData> {
  const response = await api.get<{ success: boolean; data: ISettingsData }>(
    "store/settings/footer",
  );
  return response.data.data;
}
