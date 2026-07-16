import type { IAboutStat } from "./IAboutStat";

export interface IAboutHeroProps {
  badgeText: string;
  titleWhite: string;
  titleBlue: string;
  subtitle: string;
  description: string;
  stats: IAboutStat[];
}
