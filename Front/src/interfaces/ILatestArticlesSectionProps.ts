import type { IBlogCardProps } from "./IBlogCardProps";

export interface ILatestArticlesSectionProps {
  title: string;
  articles: IBlogCardProps[];
  loadMoreText?: string;
  hasMore?: boolean;
  onLoadMore?: () => void;
}
