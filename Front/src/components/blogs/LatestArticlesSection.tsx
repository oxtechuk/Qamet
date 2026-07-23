import { useTranslation } from "react-i18next";
import { ArrowDown } from "lucide-react";
import BlogCard from "./BlogCard";
import type { ILatestArticlesSectionProps } from "../../interfaces/ILatestArticlesSectionProps";

export default function LatestArticlesSection({
  title,
  articles,
  loadMoreText = "عرض المزيد من المقالات",
  hasMore = false,
  onLoadMore,
}: ILatestArticlesSectionProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full py-14">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 gap-x-10 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
          {articles.map((article) => (
            <BlogCard key={article.id} {...article} />
          ))}
        </div>

        {hasMore && (
          <div className="mt-12 flex justify-center">
            <button
              type="button"
              onClick={onLoadMore}
              className="inline-flex h-[42px] items-center justify-center gap-2 rounded-full bg-white px-6 text-[14px] font-bold text-[#07111F] transition hover:bg-[var(--brand-secondary-color)] hover:text-white"
            >
              {loadMoreText}
              <ArrowDown size={16} />
            </button>
          </div>
        )}
      </div>
    </section>
  );
}
