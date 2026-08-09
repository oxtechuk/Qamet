import type { CarCardProps } from "../components/CarCard";

export interface ICarsShowcaseSectionProps {
  titleBlue: string;
  titleOrange: string;
  description: string;
  buttonText: string;
  buttonTo: string;
  cars: CarCardProps[];
}