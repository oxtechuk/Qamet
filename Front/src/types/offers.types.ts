export interface OfferCar {
  id: number;
  name: string;
  slug: string;
  main_image: string | null;
  thumbnail: string | null;
  cash_price: number;
  current_price: number;
  savings: number;
  min_installment: number;
  min_down_payment: number;
  type: string;
  year: string;
  specs: { label: string; value: string }[];
  colors: { hex: string; name: string }[];
  is_featured: boolean;
  availability_status: string;
  highlight: string | null;
  is_current_year: boolean;
  brand: { id: number; name: string };
}

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
  time_remaining: string;
  is_expired: boolean;
  car: OfferCar;
}

export interface OfferHeroSlide {
  id: number;
  image: string;
  link: string;
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
  slug: string;
  main_image: string | null;
  thumbnail: string | null;
  cash_price: number;
  current_price: number;
  savings: number;
  min_installment: number;
  min_down_payment: number;
  type: string;
  year: string;
  specs: { label: string; value: string }[];
  colors: { hex: string; name: string }[];
  is_featured: boolean;
  availability_status: string;
  highlight: string | null;
  is_current_year: boolean;
  brand: { id: number; name: string };
}

export interface OffersMeta {
  current_page: number;
  per_page: number;
  total: number;
  last_page: number;
  from: number;
  to: number;
  hero: OfferHero;
  hero_slides: OfferHeroSlide[];
  bento_cars: BentoCar[];
  main_gallery: string[];
}

export interface OffersApiResponse {
  success: boolean;
  message: string;
  data: OfferData[];
  errors: null;
  meta: OffersMeta;
}
