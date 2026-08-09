import type { IBookingApiResponse, IBookingFormData } from "../../interfaces/IBookingApiResponse";
import api from "./http";

export async function submitBooking(data: IBookingFormData): Promise<IBookingApiResponse> {
  const response = await api.post<IBookingApiResponse>("store/booking", data);
  return response.data;
}
