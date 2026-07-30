import type { IHomeOfferSlide } from "./IHomeOfferSlide";

export interface IHomeOffersSectionProps {
  slides: IHomeOfferSlide[];
  autoPlay?: boolean;
  interval?: number;
  className?: string;
}
