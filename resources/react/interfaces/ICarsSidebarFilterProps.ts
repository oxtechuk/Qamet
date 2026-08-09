import type { BrandInfo } from "../types/home.types";
import type { FilterValues } from "../types/cars.types";

export type BrandWithLogo = BrandInfo & {
  logo?: string;
  logo_url?: string;
  image?: string;
};

export interface ICarsSidebarFilterProps {
  brands?: BrandInfo[];
  transmissions: string[];
  fuelTypes: string[];
  filters: FilterValues;
  onFilterChange: (filters: FilterValues) => void;
}
