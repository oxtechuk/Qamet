import { useTranslation } from "react-i18next";
import { ArrowDown } from "lucide-react";
import OfferListCard from "./OfferListCard";
import type { IOffersGridSectionProps } from "../../interfaces/IOffersGridSectionProps";

export default function OffersGridSection({
  title,
  offers,
  categories,
  activeCategory = "all",
  onCategoryChange,
  loadMoreText,
  hasMore,
  onLoadMore,
}: IOffersGridSectionProps) {
  const { i18n, t } = useTranslation();

  const defaultCategories = [
    { label: t("offersPage.grid.categories.all"), value: "all" },
    { label: t("offersPage.grid.categories.finance"), value: "finance" },
    { label: t("offersPage.grid.categories.discounts"), value: "discounts" },
    { label: t("offersPage.grid.categories.models2026"), value: "models-2026" },
  ];

  const resolvedCategories = categories ?? defaultCategories;

  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-14">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-12 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
          <h2 className="text-[26px] font-extrabold text-[#07111F]">{title}</h2>

          <div className="flex flex-wrap items-center gap-3">
            {resolvedCategories.map((category) => {
              const isActive = category.value === activeCategory;

              return (
                <button
                  key={category.value}
                  type="button"
                  onClick={() => onCategoryChange?.(category.value)}
                  className={`h-[38px] rounded-full px-6 text-[14px] font-bold transition ${
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
        </div>

        {/* Offers Grid */}
        <div className="grid grid-cols-1 gap-x-10 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
          {offers.map((offer) => (
            <OfferListCard key={offer.id} {...offer} />
          ))}
        </div>

        {/* Load More */}
        {hasMore && (
          <div className="mt-12 flex justify-center">
            <button
              type="button"
              onClick={onLoadMore}
              className="inline-flex h-[42px] items-center justify-center gap-2 rounded-full bg-white px-6 text-[15px] font-bold text-[#07111F] transition hover:bg-[var(--brand-secondary-color)] hover:text-white"
            >
              {loadMoreText || t("offersPage.grid.loadMore")}
              <ArrowDown size={17} />
            </button>
          </div>
        )}
      </div>
    </section>
  );
}
