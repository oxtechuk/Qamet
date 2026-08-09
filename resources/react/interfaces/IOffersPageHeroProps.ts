export interface IOffersPageHeroProps {
  image: string;
  badgeText: string;
  title: string;
  description: string;
  carLabel?: string;
  endsAt?: string;
  discountPercent?: number | null;
  specialPrice?: number | null;
  primaryButtonText: string;
  primaryButtonTo: string;
}
