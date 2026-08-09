import type { OffersApiResponse } from "../../types/offers.types";
import api from "./http";

export async function getOffers(
  page = 1,
  perPage = 12
): Promise<OffersApiResponse> {
  const response = await api.get<OffersApiResponse>("store/offers", {
    params: { page, per_page: perPage },
  });
  return response.data;
}
