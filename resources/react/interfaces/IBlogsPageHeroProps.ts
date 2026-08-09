import type { IBlogCategory } from "./IBlogCategory";
import type { IBlogFeaturedCardProps } from "./IBlogFeaturedCardProps";

export interface IBlogsPageHeroProps {
  badgeText: string;
  title: string;
  description: string;
  categories: IBlogCategory[];
  activeCategory: string;
  onCategoryChange?: (value: string) => void;
  featuredPost?: IBlogFeaturedCardProps;
}
