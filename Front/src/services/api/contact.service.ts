import type { IContactApiResponse, IContactFormData } from "../../interfaces/IContactApiResponse";
import type { IContactPageApiResponse } from "../../types/contact.types";
import api from "./http";

export async function submitContactForm(data: IContactFormData): Promise<IContactApiResponse> {
  const response = await api.post<IContactApiResponse>("store/contact", data);
  return response.data;
}

export async function getContactPageData(): Promise<IContactPageApiResponse> {
  const response = await api.get<IContactPageApiResponse>("store/contact");
  return response.data;
}
