import type { IHeroCard } from "./IHeroCard";

export interface IHomeHeroProps {
  bannerImage: string;
  titleBlue: string;
  titleOrange: string;
  description: string;
  primaryButtonText: string;
  primaryButtonTo: string;
  secondaryButtonText: string;
  secondaryButtonTo: string;
  cards: IHeroCard[];
}
