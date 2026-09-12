import type { IBookingApiResponse, IBookingFormData } from "../../interfaces/IBookingApiResponse";
import api from "./http";
import { getAttributionData } from "../../utils/attribution";

export async function submitBooking(data: IBookingFormData): Promise<IBookingApiResponse> {
  const attribution = getAttributionData();
  const payload = { ...attribution, ...data };
  const response = await api.post<IBookingApiResponse>("store/booking", payload);
  return response.data;
}
