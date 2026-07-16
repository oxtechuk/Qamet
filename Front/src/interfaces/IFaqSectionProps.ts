import type { IFaqItem } from "./IFaqItem";

export interface IFaqSectionProps {
  eyebrow: string;
  titleBlack: string;
  titleOrange: string;
  description: string;
  buttonText: string;
  buttonHref?: string;
  faqs: IFaqItem[];
}
