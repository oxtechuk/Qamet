import { useTranslation } from "react-i18next";
import BrandCard from "../components/BrandCard";
import BrandSearchInput from "../components/BrandSearchInput";
import LoadingSpinner from "../components/LoadingSpinner";
import { useSEO } from "../utils/useSEO";
import { useBrands } from "../hooks/useBrands";

export default function BrandsPage() {
  const { t, i18n } = useTranslation();
  useSEO(t("pageTitles.brands"), t("brandsSection.description"));
  const { brandCards, search, setSearch, isLoading } = useBrands();

  if (isLoading) return <LoadingSpinner />;

  return (
    <section dir={i18n.dir()} className="w-full py-16">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mb-10">
          <h1 className="text-[34px] font-bold leading-tight md:text-[40px]">
            <span className="text-[var(--brand-primary-color)]">
              {t("brandsSection.titleBlue")}
            </span>{" "}
          </h1>
        </div>

        <div className="mb-12">
          <BrandSearchInput
            value={search}
            onChange={setSearch}
            placeholder={t("brandsSection.searchPlaceholder")}
            dir={i18n.dir()}
          />
        </div>

        {brandCards.length > 0 ? (
          <div className="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:grid-cols-5">
            {brandCards.map((brand) => (
              <BrandCard key={brand.id} {...brand} />
            ))}
          </div>
        ) : (
          <p className="py-20 text-center text-[16px] text-[#9A9A9A]">
            {t("brandsSection.noResults")}
          </p>
        )}
      </div>
    </section>
  );
}
