import type { CarItem, BrandInfo, FilterPrice, HomepageStat, FilterCategory, CarSpec, CarColor } from "./home.types";

export interface CarType {
  id: number;
  name: string;
  slug: string;
}

export interface CarsQueryParams {
  page?: number;
  per_page?: number;
  brands?: number[];
  type?: number;
  category_id?: number;
  year?: string;
  min_price?: number;
  max_price?: number;
  search?: string;
  q?: string;
  fuel?: string;
  transmission?: string;
  offer_id?: number;
  sort?: "price_asc" | "price_desc" | "year_desc" | "year_asc";
}

export interface CarsListResponse {
  data: CarItem[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

export interface CarColorWithImage {
  hex: string;
  name: string;
  image?: string | null;
  images?: string[];
}

export interface FeatureItem {
  id: number;
  name: string;
  icon: string;
}

export interface CarDetails {
  id: number;
  name: string;
  slug: string;
  main_image: string;
  thumbnail: string;
  images: string[];
  exterior_images?: string[];
  interior_images?: string[];
  exterior_colors?: CarColorWithImage[];
  interior_colors?: CarColorWithImage[];
  cash_price: number;
  min_installment: number;
  current_price: number;
  year: string;
  is_current_year: boolean;
  type: string;
  colors: CarColorWithImage[];
  specs: Record<string, string | null>;
  description: string;
  features: string;
  is_featured: boolean;
  availability_status: string;
  highlight?: string;
  views: number;
  brand: { id: number; name: string; slug: string; logo: string };
  category: { id: number; name: string; slug: string } | null;
  active_offers: any[];
  offers: any[];
  specifications: FeatureItem[];
  features_list: FeatureItem[];
  safety_features?: FeatureItem[];
  related_cars: CarItem[];
}

export interface CarsSidebarFilterData {
  brands: BrandInfo[];
  minPrice: number;
  maxPrice: number;
  engines: string[];
  transmissions: string[];
  fuelTypes: string[];
}

export interface FilterValues {
  brandId: number | null;
  type: string;
  categoryId: number | null;
  year: string;
  priceMin: number;
  priceMax: number;
  engine: string;
  transmission: string;
  fuelType: string;
  search: string;
}

export const DEFAULT_FILTER_VALUES: FilterValues = {
  brandId: null,
  type: "all",
  categoryId: null,
  year: "",
  priceMin: 0,
  priceMax: 200000,
  engine: "all",
  transmission: "all",
  fuelType: "all",
  search: "",
};

export interface HeroSlide {
  link: string;
  image: string | null;
  car_id: number | null;
  link_2: string | null;
  title_ar: string;
  title_en: string;
  is_active: boolean;
  button_text_ar: string;
  button_text_en: string;
  button_2_text_ar: string;
  button_2_text_en: string;
}

export interface HeroAd {
  image: string | null;
  link: string;
}

export interface FeaturedOfferCar {
  id: number;
  name: string;
  slug: string;
  main_image: string;
  thumbnail: string | null;
  cash_price: number;
  current_price: number;
  savings: number;
  min_installment: number;
  min_down_payment: number;
  type: string;
  year: string;
  specs: CarSpec[];
  colors: CarColor[];
  is_featured: boolean;
  availability_status: string;
  highlight: string | null;
  is_current_year: boolean;
  brand: { id: number; name: string };
}

export interface FeaturedOffer {
  id: number;
  title: string;
  description: string;
  image: string | null;
  installment_starts_from: number;
  time_remaining: string;
  is_expired: boolean;
  car: FeaturedOfferCar;
}

export interface FilterHighlight {
  value: string;
  label: string;
  count: number;
}

export interface FilterHorsepower {
  min: number;
  max: number | null;
  count: number;
}

export interface CarsMetaData {
  featured_offer: FeaturedOffer | null;
  total_cars: number;
  total_brands: number;
  hero: {
    title: string;
    subtitle: string;
    image: string | null;
  } | null;
  filter_brands: BrandInfo[];
  filter_types: FilterCategory[];
  filter_categories: FilterCategory[];
  filter_brand_types: any[];
  filter_years: string[];
  filter_prices: FilterPrice[];
  filter_fuels: FilterCategory[];
  filter_horsepowers: FilterHorsepower[];
  filter_highlights: FilterHighlight[];
  homepage_stats: HomepageStat[];
  hero_slides: HeroSlide[];
  hero_ads: HeroAd[];
}
