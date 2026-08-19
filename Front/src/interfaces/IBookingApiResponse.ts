export interface IBookingFormData {
  car_id: number | null;
  payment_method: "cash" | "bank" | null;
  client_name: string;
  client_phone: string;
  client_email?: string | null;
  car_type?: string | null;
  age?: number | null;
  work_sector?: string | null;
  salary?: number | null;
  service_duration?: string | null;
  has_downpayment?: boolean;
  down_payment?: number | null;
  has_obligations?: boolean;
  monthly_obligations?: number | null;
  purchase_urgency?: string | null;
  company_name?: string | null;
  preferred_contact_date?: string | null;
  preferred_contact_time?: string | null;
  car_count?: number | null;
  booking_type?: string | null;
  notes?: string | null;
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
