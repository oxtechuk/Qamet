import type { IInfoCard } from "./IInfoCard";

export interface IAboutStorySectionProps {
  title: string;
  paragraphs: string[];
  cards: IInfoCard[];
}
