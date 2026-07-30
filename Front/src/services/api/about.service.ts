import type { IAboutApiResponse } from "../../interfaces/IAboutApiResponse";
import type { IAboutData } from "../../interfaces/IAboutData";
import api from "./http";

export async function getAboutPageData(): Promise<IAboutData> {
  const response = await api.get<IAboutApiResponse>("store/about");
  return response.data.data;
}
