import type { IFaqItem } from "./IFaqItem";

export interface IFaqAccordionProps {
  faq: IFaqItem;
  isOpen: boolean;
  onToggle: (id: string | number) => void;
}
