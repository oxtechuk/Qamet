import type { ICalculatorLeadRequest, ICalculatorLeadResponse } from "../../interfaces/ICalculatorLeadRequest";
import type { IBankItem, ICalculateRequest, ICalculateData, IApiResponse } from "../../interfaces/ICalculatorTypes";
import api from "./http";

export async function submitCalculatorLead(data: ICalculatorLeadRequest): Promise<ICalculatorLeadResponse> {
  const response = await api.post<ICalculatorLeadResponse>("store/calculator/lead", data);
  return response.data;
}

export async function getBanks(): Promise<IBankItem[]> {
  const response = await api.get<IApiResponse<IBankItem[]>>("store/calculator/banks");
  return response.data.data;
}

export async function calculateFinance(data: ICalculateRequest): Promise<ICalculateData> {
  const response = await api.post<IApiResponse<ICalculateData>>("store/calculator/calculate", data);
  return response.data.data;
}
