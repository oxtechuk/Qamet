import { useTranslation } from "react-i18next";
import BlogFeaturedCard from "./BlogFeaturedCard";
import type { IBlogsPageHeroProps } from "../../interfaces/IBlogsPageHeroProps";

export default function BlogsPageHero({
  badgeText,
  title,
  description,
  categories,
  activeCategory,
  onCategoryChange,
  featuredPost,
}: IBlogsPageHeroProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-16">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-3xl text-center">
          <span className="inline-flex rounded-full bg-white px-5 py-2 text-[14px] font-medium text-[#6B7280]">
            {badgeText}
          </span>

          <h1
            className="mt-7 text-[34px] font-extrabold leading-tight text-[#07111F] md:text-[44px]"
            dangerouslySetInnerHTML={{ __html: title }}
          />

          <p className="mx-auto mt-5 max-w-2xl text-[17px] leading-8 text-[#6B7280]">
            {description}
          </p>
        </div>

        <div className="mt-8 flex flex-wrap items-center justify-center gap-3">
          {categories.map((category) => {
            const isActive = category.value === activeCategory;

            return (
              <button
                key={category.value}
                type="button"
                onClick={() => onCategoryChange?.(category.value)}
                className={`h-[40px] rounded-full px-6 text-[14px] font-bold transition ${
                  isActive
                    ? "bg-[var(--brand-secondary-color)] text-white"
                    : "bg-white text-[#6B7280] hover:bg-[var(--brand-secondary-color)] hover:text-white"
                }`}
              >
                {category.label}
              </button>
            );
          })}
        </div>

        {featuredPost && (
          <div className="mt-16">
            <BlogFeaturedCard {...featuredPost} />
          </div>
        )}
      </div>
    </section>
  );
}
