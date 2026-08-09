import type { BrandInfo, FilterCategory } from "../types/home.types";

export interface CarFinderValues {
  brandId: string;
  typeId: string;
  categoryId: string;
  year: string;
  search: string;
}

export interface ICarFinderProps {
  onSearch?: (values: CarFinderValues) => void;
  onReset?: () => void;
  brands?: BrandInfo[];
  types?: FilterCategory[];
  categories?: FilterCategory[];
  years?: (string | { year: string })[];
  filterTitle?: string;
}
