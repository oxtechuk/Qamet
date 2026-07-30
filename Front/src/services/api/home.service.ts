import type { ApiResponse, HomePageData, FinanceSettingsData } from "../../types/home.types";
import api from "./http";

export async function getHomePageData(): Promise<HomePageData> {
  const response = await api.get<ApiResponse<HomePageData>>("store/home");
  return response.data.data;
}

export async function getFinanceSettings(): Promise<FinanceSettingsData> {
  const response = await api.get<ApiResponse<FinanceSettingsData>>("store/settings/finance-solution");
  return response.data.data;
}
