import type { ApiResponse, BrandInfo, CarItem } from "../../types/home.types";
import type {
  CarDetails,
  CarsListResponse,
  CarsQueryParams,
  CarsMetaData,
  CarType,
} from "../../types/cars.types";
import type { ICompareData } from "../../interfaces/ICompareData";
import api from "./http";

export async function getCars(
  params?: CarsQueryParams,
): Promise<CarsListResponse> {
  const response = await api.get<{
    success: boolean;
    data: CarItem[];
    meta: CarsListResponse["meta"];
  }>("store/cars", { params });
  return {
    data: response.data.data,
    meta: response.data.meta,
  };
}

export async function getCarTypes(): Promise<CarType[]> {
  const response = await api.get<ApiResponse<CarType[]>>("store/car-types");
  return response.data.data;
}

export async function getBrands(): Promise<BrandInfo[]> {
  const response = await api.get<ApiResponse<BrandInfo[]>>("store/brands");
  return response.data.data;
}

export async function getCarBySlug(slug: string): Promise<CarDetails> {
  const response = await api.get<ApiResponse<CarDetails>>(`store/cars/${slug}`);
  return response.data.data;
}

export async function compareCars(slugs: string[]): Promise<ICompareData> {
  const response = await api.get<ApiResponse<{ sections: ICompareData }>>(
    "store/cars/compare",
    { params: { "cars[]": slugs } },
  );
  return response.data.data.sections;
}

export async function searchCars(q: string): Promise<CarItem[]> {
  const response = await api.get<ApiResponse<CarItem[]>>("store/cars/search", {
    params: { q },
  });
  return response.data.data;
}

export async function getCarsMeta(): Promise<CarsMetaData> {
  const response = await api.get<ApiResponse<CarsMetaData>>("store/cars/meta");
  return response.data.data;
}
