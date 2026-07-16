import { useTranslation } from "react-i18next";
import { useNavigate } from "react-router-dom";
import { Search } from "lucide-react";
import Button from "./button";
import BrandCard from "./BrandCard";
import type { IBrandsSectionProps, IBrandCategory } from "../interfaces/IBrandsSectionProps";

function useDefaultCategories(t: (key: string) => string): IBrandCategory[] {
  return [
    { label: t("brandsSection.categories.0"), value: "all" },
    { label: t("brandsSection.categories.1"), value: "luxury" },
    { label: t("brandsSection.categories.2"), value: "economic" },
    { label: t("brandsSection.categories.3"), value: "electric" },
    { label: t("brandsSection.categories.4"), value: "suv" },
    { label: t("brandsSection.categories.5"), value: "family" },
  ];
}

export default function BrandsSection({
  titleBlue,
  titleOrange,
  description,
  buttonText,
  buttonTo,
  brands,
  categories,
  activeCategory = "all",
  searchPlaceholder,
  onCategoryChange,
  onSearchChange,
}: IBrandsSectionProps) {
  const { t, i18n } = useTranslation();
  const navigate = useNavigate();
  const defaultCategories = useDefaultCategories(t);
  const resolvedCategories = categories ?? defaultCategories;
  const resolvedPlaceholder = searchPlaceholder ?? t("brandsSection.searchPlaceholder");

  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-16">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="mb-10 flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
          <div className="text-right">
            <h2 className="text-[26px] font-bold leading-tight md:text-[40px]">
              <span className="text-[var(--brand-primary-color)]">
                {titleBlue}
              </span>{" "}
              <span className="text-[var(--brand-secondary-color)]">
                {titleOrange}
              </span>
            </h2>

            <p className="mt-4 max-w-2xl text-[14px] leading-6 text-[#5F8FD7] md:text-[16px] md:leading-7">
              {description}
            </p>
          </div>

          <Button
            to={buttonTo}
            bgColor="bg-[var(--brand-primary-color)]"
            className="h-[44px] w-full px-6 py-0 text-[13px] md:h-[48px] md:w-auto md:px-8 md:text-[15px]"
          >
            {buttonText}
          </Button>
        </div>

        {/* Search + Categories */}
        <div className="mb-12 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
          <div className="relative w-full lg:max-w-[430px]">
            <input
              type="text"
              placeholder={resolvedPlaceholder}
              onChange={(event) => onSearchChange?.(event.target.value)}
              className="h-[54px] w-full rounded-full border border-[#8DB5EE] bg-transparent px-6 pr-14 text-[15px] text-[#111827] outline-none placeholder:text-[#7A97C7] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.18)]"
            />

            <Search
              size={22}
              className="absolute right-5 top-1/2 -translate-y-1/2 text-[#5F8FD7]"
            />
          </div>

          <div className="flex flex-wrap items-center justify-center gap-4 lg:justify-start">
            {resolvedCategories.map((category) => {
              const isActive = category.value === activeCategory;

              return (
                <button
                  key={category.value}
                  type="button"
                  onClick={() => onCategoryChange?.(category.value)}
                  className={`h-[44px] min-w-[82px] rounded-[8px] border px-5 text-[15px] font-medium transition ${
                    isActive
                      ? "border-[var(--brand-primary-color)] bg-[var(--brand-primary-color)] text-white"
                      : "border-[#C9CED6] bg-transparent text-[#4B5563] hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)]"
                  }`}
                >
                  {category.label}
                </button>
              );
            })}
          </div>
        </div>

        {/* Brands Grid */}
        <div className="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:grid-cols-5">
          {brands.map((brand) => (
            <BrandCard key={brand.id} {...brand} onClick={() => navigate(`/cars?search=${encodeURIComponent(brand.name)}`)} />
          ))}
        </div>
      </div>
    </section>
  );
}