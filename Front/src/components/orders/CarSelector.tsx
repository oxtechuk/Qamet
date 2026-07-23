import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../../store/language.store";
import { getImageUrl, APP_IMAGES } from "../../constants/app-images";
import type { CarItem } from "../../types/home.types";
import LazyImg from "../LazyImg";

interface ICarSelectorProps {
  searchQuery: string;
  setSearchQuery: (v: string) => void;
  searchResults: CarItem[];
  searching: boolean;
  selectedCar: CarItem | null;
  onSelectCar: (car: CarItem | null) => void;
}

export default function CarSelector({
  searchQuery,
  setSearchQuery,
  searchResults,
  searching,
  selectedCar,
  onSelectCar,
}: ICarSelectorProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);

  const inputCls =
    "h-[48px] w-full rounded-[10px] border border-[#E5E7EB] bg-white px-4 text-[14px] text-[#111827] outline-none placeholder:text-[#9CA3AF] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.12)] transition";

  return (
    <div>
      <h2 className="mb-4 text-[20px] font-extrabold text-[#111827]">
        {t("ordersPage.selectCarTitle")}
      </h2>

      <div className="relative mb-4">
        <input
          type="text"
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          placeholder={t("ordersPage.searchPlaceholder")}
          className={`${inputCls} pe-10`}
        />
        <svg
          className="absolute end-3 top-1/2 -translate-y-1/2 text-[#9CA3AF]"
          width="16"
          height="16"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth="2"
          strokeLinecap="round"
          strokeLinejoin="round"
        >
          <circle cx="11" cy="11" r="8" />
          <line x1="21" y1="21" x2="16.65" y2="16.65" />
        </svg>
      </div>

      <div className="space-y-2 max-h-[480px] overflow-y-auto pe-1">
        {searching && (
          <div className="flex justify-center py-6">
            <div className="h-6 w-6 animate-spin rounded-full border-2 border-[#D1D5DB] border-t-[var(--brand-secondary-color)]" />
          </div>
        )}
        {!searching &&
          searchResults.map((car) => {
            const isSelected = selectedCar?.id === car.id;
            const badge = car.is_featured
              ? t("ordersPage.bestSeller")
              : car.is_current_year
                ? t("ordersPage.exclusive")
                : null;
            return (
              <button
                key={car.id}
                type="button"
                onClick={() => onSelectCar(isSelected ? null : car)}
                className={[
                  "flex w-full items-center gap-4 rounded-[14px] border bg-white px-4 py-3 text-end transition",
                  isSelected
                    ? "border-[var(--brand-primary-color)] ring-2 ring-[var(--brand-primary-color)]/20"
                    : "border-[#E5E7EB] hover:border-[#D1D5DB]",
                ].join(" ")}
              >
                <LazyImg
                  src={getImageUrl(car.main_image) || APP_IMAGES.CAR_PLACEHOLDER}
                  alt={car.name}
                  className="h-[56px] w-[80px] shrink-0 rounded-[10px] object-cover"
                />
                <div className="flex flex-1 flex-col items-start">
                  <p className="text-[12px] text-[var(--brand-secondary-color)]">
                    {car.brand?.name}
                  </p>
                  <p className="text-[15px] font-extrabold text-[#111827]">
                    {car.name} {car.year}
                  </p>
                  <p className="text-[12px] text-[#9CA3AF]">
                    {car.current_price
                      ? `${car.current_price.toLocaleString()} ${t("financeCalculator.step2.riyal")}`
                      : "—"}
                  </p>
                </div>
                {badge && (
                  <span className="mb-1 self-center rounded-full bg-[var(--brand-secondary-color)] px-2.5 py-0.5 text-[11px] font-semibold text-[var(--brand-primary-color)]">
                    {badge}
                  </span>
                )}
                <div
                  className={[
                    "flex h-[20px] w-[20px] shrink-0 items-center justify-center rounded-full border-2",
                    isSelected
                      ? "border-[var(--brand-primary-color)]"
                      : "border-[#D1D5DB]",
                  ].join(" ")}
                >
                  {isSelected && (
                    <div className="h-[10px] w-[10px] rounded-full bg-[var(--brand-primary-color)]" />
                  )}
                </div>
              </button>
            );
          })}
      </div>
    </div>
  );
}
