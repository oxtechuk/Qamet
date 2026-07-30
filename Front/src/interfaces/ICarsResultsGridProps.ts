import type { CarCardProps } from "../components/CarCard";

export interface ICarsResultsGridProps {
  cars: CarCardProps[];
  currentPage: number;
  totalPages: number;
  onPageChange: (page: number) => void;
}
