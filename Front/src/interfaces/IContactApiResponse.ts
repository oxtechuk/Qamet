export interface IContactApiResponse {
  success: boolean;
  message: string;
  data: { lead_id: number } | null;
  errors: unknown;
  meta: unknown;
}

export interface IContactFormData {
  name: string;
  phone: string;
  email: string;
  subject: string;
  country: string;
  message: string;
  event_id?: string | null;
}
