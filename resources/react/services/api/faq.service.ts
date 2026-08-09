import type { ApiResponse } from "../../types/home.types";
import type { IFaqItem } from "../../interfaces/IFaqItem";
import api from "./http";

export async function getFaqs(): Promise<IFaqItem[]> {
  const response = await api.get<ApiResponse<IFaqItem[]>>("store/faqs");
  return response.data.data;
}
