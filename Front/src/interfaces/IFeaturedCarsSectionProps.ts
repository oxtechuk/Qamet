import type { CarCardProps } from "../components/CarCard";

export interface IFeaturedCarsSectionProps {
  titleBlue: string;
  buttonText: string;
  buttonTo: string;
  cars: CarCardProps[];
  backgroundImage?: string;
  className?: string;
  itemsPerPage?: number;
  emptyMessage?: string;
}
