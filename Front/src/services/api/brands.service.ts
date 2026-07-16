import type { ApiResponse, BrandInfo } from "../../types/home.types";
import api from "./http";

export async function getBrands(search?: string): Promise<BrandInfo[]> {
  const params: Record<string, string> = {};
  if (search) params.search = search;
  const response = await api.get<ApiResponse<BrandInfo[]>>("store/brands", { params });
  return response.data.data;
}
