import type { IContactApiResponse, IContactFormData } from "../../interfaces/IContactApiResponse";
import api from "./http";

export async function submitContactForm(data: IContactFormData): Promise<IContactApiResponse> {
  const response = await api.post<IContactApiResponse>("store/contact", data);
  return response.data;
}
