import type { ReactNode } from "react";

export interface ICarCardProps {
  id: string | number;
  image: string;
  brand: string;
  name: string;
  year: string | number;
  type?: string;
  fuelType?: string;
  transmission?: string;
  seats?: string;
  oldPrice?: ReactNode;
  price: ReactNode;
  monthlyPrice: ReactNode;
  detailsTo: string;
  slug?: string;
  compareText?: string;
  reserveText?: string;
  badgeText?: string;
}