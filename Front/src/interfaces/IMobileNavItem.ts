import type { LucideIcon } from "lucide-react";

export interface IMobileNavItem {
  labelKey: string;
  to: string;
  icon: LucideIcon;
  isCenter?: boolean;
  isMenu?: boolean;
}
