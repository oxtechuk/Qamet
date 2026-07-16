import type { ITestimonialItem } from "./ITestimonialItem";

export interface ITestimonialsSectionProps {
  badge: string;
  titleBlack: string;
  titleBlue: string;
  ratingText?: string;
  testimonials: ITestimonialItem[];
}
