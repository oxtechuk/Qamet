import type { IBrandCardProps } from "./IBrandCardProps";

export interface IBrandCategory {
  label: string;
  value: string;
}

export interface IBrandsSectionProps {
  titleBlue: string;
  titleOrange: string;
  description: string;
  buttonText: string;
  buttonTo: string;
  brands: IBrandCardProps[];
  categories?: IBrandCategory[];
  activeCategory?: string;
  searchPlaceholder?: string;
  onCategoryChange?: (value: string) => void;
  onSearchChange?: (value: string) => void;
}
