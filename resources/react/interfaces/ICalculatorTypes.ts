export interface IBankItem {
  id: number;
  name: string;
  image: string;
  annual_rate: number;
}

export interface ICalculateRequest {
  car_price: number;
  down_payment_percentage: number;
  period_months: number;
}

export interface ICalculateData {
  car_price: number;
  down_payment_amount: number;
  down_payment_percentage: number;
  loan_amount: number;
  monthly_payment: number;
  period_months: number;
  total_payment: number;
  total_interest: number;
  annual_rate: number;
  bank: {
    id: number;
    name: string;
  };
}

export interface IApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  errors: unknown;
  meta: unknown;
}
