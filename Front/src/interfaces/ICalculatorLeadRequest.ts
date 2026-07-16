export interface ICalculatorLeadRequest {
  name: string;
  phone: string;
  email: string;
  city: string;
  purpose: string;
  salary: number;
  monthly_obligations: number;
  car_ids: number[];
  notes: string;
  preferred_bank_id: number;
}

export interface ICalculatorLeadResponse {
  success: boolean;
  message: string;
  data: { lead_id: number } | null;
  errors: unknown;
  meta: unknown;
}
