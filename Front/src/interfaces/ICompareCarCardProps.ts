import type { CarDetails } from "../types/cars.types";
export interface ICompareCarCardProps {
  car: CarDetails;
  onRemove?: () => void;
}
