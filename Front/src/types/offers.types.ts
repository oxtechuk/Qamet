export interface OfferData {
  id: number;
  title: string;
  description: string;
  image: string | null;
  discount_percent: number | null;
  special_price: number | null;
  special_installment: number | null;
  starts_at: string;
  ends_at: string;
  is_active: boolean;
}

export interface OfferHero {
  title: string;
  subtitle: string;
  image: string | null;
  badge?: string;
}

export interface BentoCar {
  id: number;
  name: string;
  image: string;
}

export interface OffersMeta {
  hero: OfferHero;
  bento_cars: BentoCar[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}

export interface OffersApiResponse {
  success: boolean;
  message: string;
  data: OfferData[];
  errors: null;
  meta: OffersMeta;
}
