import type { IOfferListCardProps } from "./IOfferListCardProps";

export interface IOfferCategory {
  label: string;
  value: string;
}

export interface IOffersGridSectionProps {
  title: string;
  offers: IOfferListCardProps[];
  categories?: IOfferCategory[];
  activeCategory?: string;
  onCategoryChange?: (value: string) => void;
  loadMoreText?: string;
  hasMore?: boolean;
  onLoadMore?: () => void;
}
