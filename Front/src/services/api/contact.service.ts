import type { IContactApiResponse, IContactFormData } from "../../interfaces/IContactApiResponse";
import type { IContactPageApiResponse } from "../../types/contact.types";
import api from "./http";
import { getAttributionData } from "../../utils/attribution";

export async function submitContactForm(data: IContactFormData): Promise<IContactApiResponse> {
  const attribution = getAttributionData();
  const payload = { ...attribution, ...data };
  const response = await api.post<IContactApiResponse>("store/contact", payload);
  return response.data;
}

export async function getContactPageData(): Promise<IContactPageApiResponse> {
  const response = await api.get<IContactPageApiResponse>("store/contact");
  return response.data;
}
