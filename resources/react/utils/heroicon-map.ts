import {
  BadgeCheck,
  Bolt,
  Calculator,
  DollarSign,
  Hand,
  Lock,
  MapPin,
  ShieldCheck,
  Truck,
  UsersRound,
  Zap,
  Banknote,
  type LucideIcon,
} from "lucide-react";

export const HEROICON_MAP: Record<string, LucideIcon> = {
  "heroicon-o-hand-raised": Hand,
  "heroicon-o-bolt": Bolt,
  "heroicon-o-shield-check": ShieldCheck,
  "heroicon-o-lock-closed": Lock,
  "heroicon-o-badge-check": BadgeCheck,
  "heroicon-o-user-group": UsersRound,
  "heroicon-o-truck": Truck,
  "heroicon-o-currency-dollar": DollarSign,
  "heroicon-o-banknotes": Banknote,
  "heroicon-o-calculator": Calculator,
  "heroicon-o-map-pin": MapPin,
  "heroicon-o-zap": Zap,
};

export function resolveHeroicon(
  iconName: string,
  FallbackIcon: LucideIcon = BadgeCheck,
): LucideIcon {
  return HEROICON_MAP[iconName] ?? FallbackIcon;
}
