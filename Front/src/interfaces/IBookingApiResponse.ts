export interface IBookingFormData {
  car_id: number | null;
  payment_method: "cash" | "bank" | null;
  client_name: string;
  client_phone: string;
  car_type: string | null;
  notes: string | null;
}

export interface IBookingApiResponse {
  success: boolean;
  message: string;
  data: {
    booking_id: number;
    client_name: string;
    client_phone: string;
    car_id: number;
    car_type: string | null;
    payment_method: string | null;
    booking_type: string;
    monthly_installment: number;
    total_price: number;
    down_payment: number;
    duration_years: number;
    status: string;
  } | null;
  errors: unknown;
  meta: unknown;
}
