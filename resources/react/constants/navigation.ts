import {
  Home,
  CarFront,
  HandCoins,
  Tags,
  MoreHorizontal,
} from "lucide-react";
import type { IMobileNavItem } from "../interfaces/IMobileNavItem";

export const mobileNavItems: IMobileNavItem[] = [
  {
    labelKey: "mobileNav.newCars",
    to: "/cars",
    icon: CarFront,
  },
  {
    labelKey: "mobileNav.offers",
    to: "/offers",
    icon: Tags,
  },
  {
    labelKey: "mobileNav.home",
    to: "/",
    icon: Home,
    isCenter: true,
  },
  {
    labelKey: "mobileNav.finance",
    to: "/finance-calculator",
    icon: HandCoins,
  },
  {
    labelKey: "mobileNav.more",
    to: "#",
    icon: MoreHorizontal,
    isMenu: true,
  },
];
