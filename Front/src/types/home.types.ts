export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  errors: unknown;
  meta: unknown;
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
  highlight?: string;
  views: number;
  brand: BrandInfo;
  active_offers: any[];
}

export interface HomeCarItem {
  id: number;
  name: string;
  slug: string;
  main_image: string;
  cash_price: number;
  current_price: number;
  savings: number;
  min_installment: number;
  year: string;
  highlight: string | null;
  brand: {
    id: number;
    name: string;
  };
}

export interface HeroSlideData {
  image: string | null;
  title: string;
  car: {
    id: number;
    name: string;
    slug: string;
    current_price: number;
    min_installment: number;
  } | null;
  button_text: string;
  button_link: string | null;
  button_2_text: string;
  button_2_link: string | null;
}

export interface SectionMeta {
  badge: string;
  title: string;
  subtitle: string;
  description: string;
  button_text: string;
}

export interface HomeOfferItem {
  id: number;
  title: string;
  description: string;
  image: string;
  installment_starts_from: number;
  time_remaining: string;
  is_expired: boolean;
  car: {
    id: number;
    name: string;
    slug: string;
    main_image: string;
    cash_price: number;
    brand: { id: number; name: string };
  };
}

export interface BudgetBracket {
  label: string;
  min: number;
  max: number | null;
  count: number;
}

export interface CampaignBanner {
  image: string | null;
  mobile_image: string | null;
  title: string;
  button_text: string;
  url: string | null;
  is_active: boolean;
}

export interface OfferItem {
  id: number;
  title: string;
  image: string | null;
  [key: string]: unknown;
}

export interface HeroData {
  title: string | null;
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
  hero_slides: HeroSlideData[];
  brands: BrandInfo[];
  latest_cars: {
    section: SectionMeta;
    items: HomeCarItem[];
  };
  why_us: unknown[];
  campaign_banners: CampaignBanner[];
  offers: {
    section: SectionMeta;
    items: HomeOfferItem[];
  };
  cars_by_budget: {
    section: SectionMeta;
    brackets: BudgetBracket[];
    cars: HomeCarItem[];
  };
  filter_brands?: BrandInfo[];
  filter_types?: FilterCategory[];
  filter_categories?: FilterCategory[];
  filter_brand_types?: FilterCategory[];
  filter_years?: (string | { year: string })[];
}
