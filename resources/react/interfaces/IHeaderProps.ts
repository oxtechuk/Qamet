import type { INavItem } from "./INavItem";

export interface IHeaderProps {
  logoSrc: string;
  logoAlt?: string;
  navItems: INavItem[];
  ctaText: string;
  ctaPath: string;
}
