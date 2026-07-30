import type { ReactNode } from "react";
import type { BrandInfo, FilterCategory } from "../types/home.types";
import type { CarFinderValues } from "./ICarFinderProps";

export interface HeroSlide {
  id: number;
  image?: string;
  video?: string;
  title?: string;
  subtitle?: ReactNode;
  description?: string;
  price?: string;
  thumbnail?: string;
  buttonText?: string;
  buttonLink?: string | null;
  button2Text?: string;
  button2Link?: string | null;
}

export interface IHomeHeroProps {
  slides: HeroSlide[];
  heroVideoUrl?: string;
  filterBrands?: BrandInfo[];
  filterTypes?: FilterCategory[];
  filterCategories?: FilterCategory[];
  filterYears?: (string | { year: string })[];
  onCarFinderSearch?: (values: CarFinderValues) => void;
  onCarFinderReset?: () => void;
  carouselBrands?: { id: string | number; name: string; logo: string; url?: string }[];
}
