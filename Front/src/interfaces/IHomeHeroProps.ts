import type { BrandInfo, FilterCategory } from "../types/home.types";
import type { CarFinderValues } from "./ICarFinderProps";

export interface HeroSlide {
  id: number;
  image?: string;
  video?: string;
  title?: string;
  subtitle?: string;
  description?: string;
  price?: string;
  thumbnail?: string;
}

export interface IHomeHeroProps {
  slides: HeroSlide[];
  heroVideoUrl?: string;
  primaryButtonText: string;
  primaryButtonTo: string;
  secondaryButtonText: string;
  secondaryButtonTo: string;
  filterBrands?: BrandInfo[];
  filterTypes?: FilterCategory[];
  filterCategories?: FilterCategory[];
  filterYears?: (string | { year: string })[];
  onCarFinderSearch?: (values: CarFinderValues) => void;
  onCarFinderReset?: () => void;
  carouselBrands?: { id: string | number; name: string; logo: string; url?: string }[];
}
