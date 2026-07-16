export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  errors: null;
  meta: null;
}

export interface FilterCategory {
  id: number;
  name: string | Record<string, string>;
  slug: string;
  sort_order?: number;
  is_active?: boolean;
}

export interface BrandInfo {
  id: number;
  name: string;
  slug: string;
  logo: string | null;
  cars_count?: number;
}

export interface CarColor {
  hex: string;
  name: string;
}

export interface CarSpec {
  label: string;
  value: string;
}

export interface CarItem {
  id: number;
  name: string;
  slug: string;
  main_image: string | null;
  thumbnail: string | null;
  images: string[];
  cash_price: number;
  min_installment: number;
  current_price: number;
  year: number | string;
  type: string;
  transmission?: string;
  fuel_type?: string;
  seats?: string;
  colors: CarColor[];
  specs: CarSpec[] | Record<string, string | null>;
  description: string;
  features: string;
  is_featured: boolean;
  is_current_year?: boolean;
  availability_status: string;
  views: number;
  brand: BrandInfo;
  active_offers: any[];
}

export interface OfferItem {
  id: number;
  title: string;
  image: string | null;
  [key: string]: unknown;
}

export interface HeroData {
  title1: string | null;
  title2: string | null;
  subtitle: string | null;
  image: string | null;
}

export interface HomeStats {
  cars: number;
  brands: number;
}

export interface FeaturedSectionOffer {
  id: number;
  title: string;
  description: string;
  image: string | null;
  installment_starts_from: number;
}

export interface FeaturedSection {
  title: string;
  description: string;
  car: CarItem;
  offer: FeaturedSectionOffer;
}

export interface HomepageStat {
  label: string;
  value: string;
}

export interface FilterPrice {
  min: number;
  max: number | null;
  count: number;
}

export interface PageSectionContent {
  badge?: string;
  title?: string;
  subtitle?: string;
  button_text?: string;
  description?: string;
  features?: string[];
}

export interface PageSections {
  filter?: PageSectionContent;
  featured_cars?: PageSectionContent;
  offers?: PageSectionContent;
  highlighted_cars?: PageSectionContent;
  finance?: PageSectionContent;
  brands?: PageSectionContent;
  budget?: PageSectionContent;
}

export interface FinanceSettingsData {
  finance: PageSectionContent;
  stats: HomepageStat[];
}

export interface HomePageData {
  featured_cars: CarItem[];
  active_offers: any[];
  brands: BrandInfo[];
  latest_posts: any[];
  stats: HomeStats;
  testimonials: any[];
  partners: any[];
  hero: HeroData;
  featured_design: null;
  social_designs: any[];
  filter_brands: BrandInfo[];
  filter_categories: FilterCategory[];
  filter_types: FilterCategory[];
  filter_years: string[];
  filter_prices?: FilterPrice[];
  bento_cars: CarItem[];
  featured_offers: any[];
  highlighted_cars: CarItem[];
  hero_slides: any[];
  featured_section?: FeaturedSection;
  homepage_stats?: HomepageStat[];
  page_sections?: PageSections;
}
