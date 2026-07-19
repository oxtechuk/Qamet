import { useTranslation } from "react-i18next";
import {
  CalendarDays,
  Clock3,
  UserRound,
} from "lucide-react";

import type { IBlogsPageHeroProps } from "../../interfaces/IBlogsPageHeroProps";
import { useLanguageStore } from "../../store/language.store";

export default function BlogsPageHero({
  badgeText,
  title,
  description,
  categories,
  activeCategory,
  onCategoryChange,
  featuredPost,
}: IBlogsPageHeroProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);

  if (!featuredPost) {
    return null;
  }

  return (
    <section
      dir={direction}
      className="w-full bg-[#F4F5F7] py-5 sm:py-7 lg:py-8"
    >
      <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
        {/* Hero */}
        <article className="relative min-h-[285px] overflow-hidden rounded-[18px] bg-[#061525] sm:min-h-[360px] lg:min-h-[430px]">
          {/* Background image */}
          <img
            src={featuredPost.image}
            alt={featuredPost.title}
            className="absolute inset-0 h-full w-full object-cover"
            loading="lazy"
          />

          {/* Main dark overlay */}
          <div className="absolute inset-0 bg-black/30" />

          {/* Dark gradient for content readability */}
          <div className="absolute inset-0 bg-gradient-to-t from-[#00182D]/95 via-[#00182D]/40 to-black/10" />

          <div className="absolute inset-0 bg-gradient-to-l from-[#00182D]/55 via-transparent to-transparent rtl:bg-gradient-to-r" />

          {/* Content */}
          <div className="relative z-10 flex min-h-[285px] flex-col justify-between px-5 py-5 sm:min-h-[260px] sm:px-8 sm:py-7 lg:min-h-[330px] lg:px-12 lg:py-10">
            {/* Top badge */}
            <div className="flex justify-start">
              <span className="inline-flex min-h-[30px] items-center rounded-full bg-[var(--brand-secondary-color)] px-4 text-[11px] font-bold text-[var(--brand-primary-color)] shadow-lg sm:text-xs">
                {badgeText}
              </span>
            </div>

            {/* Main blog details */}
            <div className="max-w-[900px] self-start text-start">
              {featuredPost.category && (
                <p className="mb-3 text-[12px] font-bold text-[var(--brand-secondary-color)] sm:text-[13px]">
                  {featuredPost.category}
                </p>
              )}

              <h1
                className="max-w-[980px] text-[25px] font-extrabold leading-[1.45] text-white sm:text-[34px] md:text-[40px] lg:text-[44px]"
                dangerouslySetInnerHTML={{
                  __html: featuredPost.title || title,
                }}
              />

              <p className="mt-3 max-w-[860px] text-[12px] leading-6 text-white/75 sm:mt-4 sm:text-[14px] sm:leading-7 lg:text-[15px]">
                {featuredPost.description || description}
              </p>

              {/* Metadata */}
              <div className="mt-5 flex flex-wrap items-center gap-x-5 gap-y-3 text-[11px] font-medium text-white/80 sm:text-[12px]">
                <div className="flex items-center gap-2">
                    <UserRound
                      size={15}
                      className="text-white/80"
                    />
                    <span>{featuredPost.author || t("blogPage.hero.defaultAuthor")}</span>
                  </div>

                {featuredPost.readTime && (
                  <div className="flex items-center gap-2">
                    <Clock3
                      size={15}
                      className="text-white/80"
                    />
                    <span>{featuredPost.readTime}</span>
                  </div>
                )}

                {featuredPost.date && (
                  <div className="flex items-center gap-2">
                    <CalendarDays
                      size={15}
                      className="text-white/80"
                    />
                    <span>{featuredPost.date}</span>
                  </div>
                )}
              </div>
            </div>
          </div>
        </article>

        {/* Categories */}
        {categories.length > 0 && (
          <div className="mt-7 flex flex-wrap items-start justify-start gap-3">
            {categories.map((category) => {
              const isActive =
                category.value === activeCategory;

              return (
                <button
                  key={category.value}
                  type="button"
                  onClick={() =>
                    onCategoryChange?.(category.value)
                  }
                  className={[
                    "min-h-[40px] rounded-full px-6",
                    "text-[13px] font-bold transition duration-300",
                    isActive
                      ? "bg-[var(--brand-primary-color)] text-white shadow-md hover:bg-[var(--brand-primary-color)] hover:text-white"
                      : "bg-[#F5F5F3] text-[#5B6572] shadow-sm hover:bg-[var(--brand-primary-color)] hover:text-white",
                  ].join(" ")}
                >
                  {category.label}
                </button>
              );
            })}
          </div>
        )}
      </div>
    </section>
  );
}