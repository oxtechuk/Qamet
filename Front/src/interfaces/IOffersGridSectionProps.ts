import type { IOfferListCardProps } from "./IOfferListCardProps";

export interface IOfferCategory {
  label: string;
  value: string;
}

export interface IOffersGridSectionProps {
  offers: IOfferListCardProps[];
  categories?: IOfferCategory[];
  activeCategory?: string;
  onCategoryChange?: (value: string) => void;
  // pagination
  currentPage?: number;
  totalPages?: number;
  onPageChange?: (page: number) => void;
  // legacy load-more (kept for compat)
  loadMoreText?: string;
  hasMore?: boolean;
  onLoadMore?: () => void;
}
