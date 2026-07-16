import type { CarCardProps } from "../components/CarCard";

export interface IBudgetRange {
  label: string;
  value: string;
}

export interface IBudgetCarsSectionProps {
  titleBlue: string;
  titleOrange: string;
  description: string;
  buttonText: string;
  buttonTo: string;
  cars: CarCardProps[];
  ranges?: IBudgetRange[];
  activeRange?: string;
  onRangeChange?: (value: string) => void;
}
