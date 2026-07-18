import { useState, useMemo } from "react";
import type { ReactNode } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import {
  SlidersHorizontal,
  X,
  Search,
  Pencil,
} from "lucide-react";
import Select from "./Select";
import { getBrands } from "../services/api/cars.service";
import { getImageUrl } from "../constants/app-images";
import { formatPrice } from "../utils/format";
import type { BrandInfo } from "../types/home.types";
import type { FilterValues } from "../types/cars.types";
import type { ICarsSidebarFilterProps, BrandWithLogo } from "../interfaces/ICarsSidebarFilterProps";

export default function CarsSidebarFilter({
  brands: brandsProp,
  transmissions,
  fuelTypes,
  filters,
  onFilterChange,
}: ICarsSidebarFilterProps) {
  const { t, i18n } = useTranslation();
  const isRTL = i18n.dir() === "rtl";
  const [sidebarTab, setSidebarTab] = useState<"brands" | "other">("brands");
  const [mobileOpen, setMobileOpen] = useState(false);

  const activeFilterCount = useMemo(() => {
    let count = 0;
    if (filters.brandId !== null) count++;
    if (filters.transmission !== "all") count++;
    if (filters.fuelType !== "all") count++;
    if (filters.priceMin > 0 || filters.priceMax < 200000) count++;
    return count;
  }, [filters]);

  const { data: fetchedBrands } = useQuery({
    queryKey: ["brands"],
    queryFn: getBrands,
  });

  const brands = brandsProp ?? fetchedBrands ?? [];

  const setFilter = <K extends keyof FilterValues>(
    key: K,
    value: FilterValues[K],
  ) => {
    onFilterChange({ ...filters, [key]: value });
  };

  const totalCarsCount = brands.reduce((sum, brand) => {
    return sum + (brand.cars_count ?? 0);
  }, 0);

  return (
    <>
      {/* Mobile filter toggle */}
      <div className="lg:hidden">
        <button
          type="button"
          onClick={() => setMobileOpen(true)}
          className="flex w-full items-center justify-center gap-2 rounded-[14px] border border-[#D7DCE3] bg-white px-4 py-3.5 text-[15px] font-bold text-[#111827] shadow-sm transition hover:border-[var(--brand-primary-color)]"
        >
          <SlidersHorizontal
            size={18}
            className="text-[var(--brand-primary-color)]"
          />
          <span>{t("carsSidebarFilter.mobileToggle")}</span>
          {activeFilterCount > 0 && (
            <span className="flex h-[22px] min-w-[22px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] px-1.5 text-[12px] font-bold text-white">
              {activeFilterCount}
            </span>
          )}
        </button>
      </div>

      {/* Mobile overlay */}
      {mobileOpen && (
        <div
          className="fixed inset-0 z-40 bg-black/40 lg:hidden"
          onClick={() => setMobileOpen(false)}
        />
      )}

      {/* Mobile drawer */}
      <div
        className={`fixed top-0 bottom-0 z-50 w-[88vw] max-w-[420px] bg-white shadow-2xl transition-transform duration-300 lg:hidden ${
          isRTL ? "right-0" : "left-0"
        } ${
          mobileOpen
            ? "translate-x-0"
            : isRTL
              ? "translate-x-full"
              : "-translate-x-full"
        }`}
      >
        <div className="flex h-full flex-col">
          <div className="shrink-0 p-5 pb-0">
            <div className="mb-5 flex items-center justify-between">
              <button
                type="button"
                onClick={() => setMobileOpen(false)}
                className="text-gray-400"
              >
                <X size={22} />
              </button>

              <span className="text-lg font-extrabold text-gray-800">
                {t("carsSidebarFilter.mobileToggle")}
              </span>
            </div>
          </div>

          {/* Scrollable content */}
          <div className="flex-1 overflow-y-auto px-5 pb-6">
            <SidebarContent
              brands={brands}
              totalCarsCount={totalCarsCount}
              transmissions={transmissions}
              fuelTypes={fuelTypes}
              filters={filters}
              sidebarTab={sidebarTab}
              setSidebarTab={setSidebarTab}
              setFilter={setFilter}
            />
          </div>

          <div className="shrink-0 border-t border-[#D7DCE3] px-5 py-5">
            <button
              type="button"
              onClick={() => setMobileOpen(false)}
              className="h-[54px] w-full rounded-[16px] bg-[var(--brand-primary-color)] text-sm font-bold text-white transition hover:opacity-90"
            >
              {t("carsSidebarFilter.apply")}
            </button>
          </div>
        </div>
      </div>

      {/* Desktop sidebar */}
      <aside className="hidden w-[320px] shrink-0 lg:block">
        <SidebarContent
          brands={brands}
          totalCarsCount={totalCarsCount}
          transmissions={transmissions}
          fuelTypes={fuelTypes}
          filters={filters}
          sidebarTab={sidebarTab}
          setSidebarTab={setSidebarTab}
          setFilter={setFilter}
        />
      </aside>
    </>
  );
}

/* ---------------- Sidebar content ---------------- */

function SidebarContent({
  brands,
  totalCarsCount,
  transmissions,
  fuelTypes,
  filters,
  sidebarTab,
  setSidebarTab,
  setFilter,
}: {
  brands: BrandInfo[];
  totalCarsCount: number;
  transmissions: string[];
  fuelTypes: string[];
  filters: FilterValues;
  sidebarTab: "brands" | "other";
  setSidebarTab: (tab: "brands" | "other") => void;
  setFilter: <K extends keyof FilterValues>(
    key: K,
    value: FilterValues[K],
  ) => void;
}) {
  const { t } = useTranslation();

  return (
    <div className="overflow-visible rounded-t-[22px] bg-white shadow-[0_20px_60px_rgba(15,23,42,0.12)]">
      <div className="flex h-[62px] items-center justify-start gap-4 rounded-t-[22px] bg-[#B1BAC1] px-6 text-white">
        <Search size={38} strokeWidth={2.2} color="var(--brand-primary-color)" />
        <h2 className="text-[25px] font-extrabold text-[var(--brand-primary-color)]">
          {t("carsSidebarFilter.search")}
        </h2>
      </div>

      {/* Tabs */}
      <div className="px-6 pt-6">
        <div className="mb-9 grid grid-cols-2 border-b border-transparent text-center">
          <button
            type="button"
            onClick={() => setSidebarTab("brands")}
            className={`pb-3 text-[20px] font-bold transition ${
              sidebarTab === "brands"
                ? "border-b-[3px] border-[var(--brand-primary-color)] text-[var(--brand-primary-color)]"
                : "text-[var(--brand-primary-color)]/80"
            }`}
          >
            {t("carsSidebarFilter.brands")}
          </button>

          <button
            type="button"
            onClick={() => setSidebarTab("other")}
            className={`pb-3 text-[20px] font-bold transition ${
              sidebarTab === "other"
                ? "border-b-[3px] border-[var(--brand-primary-color)] text-[var(--brand-primary-color)]"
                : "text-[var(--brand-primary-color)]/80"
            }`}
          >
            {t("carsSidebarFilter.otherFilters")}
          </button>
        </div>

        {/* Brands tab */}
        {sidebarTab === "brands" && (
          <div className="flex flex-col gap-5 pb-8">
            <BrandButton
              label={t("carsSidebarFilter.all")}
              count={totalCarsCount}
              active={filters.brandId === null}
              onClick={() => setFilter("brandId", null)}
            />

            {brands.map((brand) => {
              const brandWithLogo = brand as BrandWithLogo;

              return (
                <BrandButton
                  key={brand.id}
                  label={brand.name}
                  count={brand.cars_count ?? 0}
                  active={filters.brandId === brand.id}
                  logo={
                    (() => {
                      const raw = brandWithLogo.logo_url || brandWithLogo.logo || brandWithLogo.image || "";
                      return raw ? getImageUrl(raw) : "/images/brands/volkswagen.png";
                    })()
                  }
                  onClick={() => setFilter("brandId", brand.id)}
                />
              );
            })}
          </div>
        )}

        {/* Other filters tab */}
        {sidebarTab === "other" && (
          <div className="flex flex-col gap-10 pb-10">
            <PriceFilterSection
              min={filters.priceMin}
              max={filters.priceMax}
              onMinChange={(value) => setFilter("priceMin", value)}
              onMaxChange={(value) => setFilter("priceMax", value)}
            />

            <FilterSelect
              label={t("carsSidebarFilter.engineSystem")}
              value={filters.transmission}
              onChange={(value) => setFilter("transmission", value)}
              options={[
                { label: t("carsSidebarFilter.all"), value: "all" },
                ...transmissions.map((item) => ({
                  label: item,
                  value: item,
                })),
              ]}
            />

            <FilterSelect
              label={t("carsSidebarFilter.transmission")}
              value={filters.transmission}
              onChange={(value) => setFilter("transmission", value)}
              options={[
                { label: t("carsSidebarFilter.all"), value: "all" },
                ...transmissions.map((item) => ({
                  label: item,
                  value: item,
                })),
              ]}
            />

            <FilterSelect
              label={t("carsSidebarFilter.fuelType")}
              value={filters.fuelType}
              onChange={(value) => setFilter("fuelType", value)}
              options={[
                { label: t("carsSidebarFilter.all"), value: "all" },
                ...fuelTypes.map((item) => ({
                  label: item,
                  value: item,
                })),
              ]}
            />
          </div>
        )}
      </div>
    </div>
  );
}

/* ---------------- Brand button ---------------- */

function BrandButton({
  label,
  count,
  active,
  logo,
  onClick,
}: {
  label: string;
  count: number;
  active: boolean;
  logo?: string;
  onClick: () => void;
}) {
  const { i18n } = useTranslation();

  return (
    <button
      type="button"
      dir={i18n.dir()}
      onClick={onClick}
      className={`flex h-[84px] w-full items-center justify-between rounded-[18px] border px-5 transition ${
        active
          ? "border-[var(--brand-primary-color)] bg-[#F8FBFF]"
          : "border-[#D7DCE3] bg-white hover:border-[var(--brand-primary-color)]"
      }`}
    >
      <div className="flex items-center gap-4">
        {logo && (
          <img
            src={logo}
            alt={label}
            className="h-[34px] w-[34px] rounded-full object-cover"
            loading="lazy"
          />
        )}

        <span className="max-w-[120px] truncate text-[22px] font-bold text-[#111827]">{label}</span>
      </div>

      <span className="flex h-[36px] min-w-[52px] items-center justify-center rounded-full bg-[#FFF0EC] px-4 text-[16px] font-extrabold text-[var(--brand-secondary-color)]">
        {count}
      </span>
    </button>
  );
}

/* ---------------- Price filter ---------------- */

function PriceFilterSection({
  min,
  max,
  onMinChange,
  onMaxChange,
}: {
  min: number;
  max: number;
  onMinChange: (value: number) => void;
  onMaxChange: (value: number) => void;
}) {
  const { t, i18n } = useTranslation();

  return (
    <div
      dir={i18n.dir()}
      className="rounded-[22px] border border-[#D7DCE3] bg-white px-8 py-7 shadow-[0_18px_40px_rgba(15,23,42,0.08)]"
    >
      <div className="mb-7 flex items-center justify-between">
        <SlidersHorizontal
          size={24}
          className="text-[var(--brand-primary-color)]"
        />

        <h3 className="text-[26px] font-extrabold text-[var(--brand-primary-color)]">
          {t("carsSidebarFilter.priceRange")}
        </h3>
      </div>

      <div className="space-y-8">
        <RangeControl
          label={t("carsSidebarFilter.from")}
          value={min}
          maxLimit={200000}
          displayValue={formatPrice(min, "var(--brand-primary-color)")}
          onChange={(value) => {
            const nextValue = Math.min(value, max - 5000);
            onMinChange(nextValue);
          }}
        />

        <RangeControl
          label={t("carsSidebarFilter.to")}
          value={max}
          maxLimit={200000}
          displayValue={formatPrice(max, "var(--brand-primary-color)")}
          onChange={(value) => {
            const nextValue = Math.max(value, min + 5000);
            onMaxChange(nextValue);
          }}
        />
      </div>
    </div>
  );
}

function RangeControl({
  label,
  value,
  displayValue,
  maxLimit,
  onChange,
}: {
  label: string;
  value: number;
  displayValue: string | ReactNode;
  maxLimit: number;
  onChange: (value: number) => void;
}) {
  return (
    <div>
      <div className="mb-3 flex items-center justify-between">
        <span className="text-[16px] font-bold text-[var(--brand-primary-color)]">
          {label}
        </span>

        <div className="flex items-center gap-2 text-[17px] font-extrabold text-[var(--brand-primary-color)]">
          <Pencil size={19} />
          <span>{displayValue}</span>
        </div>
      </div>

      <input
        type="range"
        min={0}
        max={maxLimit}
        step={5000}
        value={value}
        onChange={(event) => onChange(Number(event.target.value))}
        className="h-[6px] w-full cursor-pointer appearance-none rounded-full bg-[#E1E4E8] accent-[var(--brand-primary-color)]"
      />
    </div>
  );
}

/* ---------------- Select filter ---------------- */

function FilterSelect({
  label,
  value,
  options,
  onChange,
}: {
  label: string;
  value: string;
  options: { label: string; value: string }[];
  onChange: (value: string) => void;
}) {
  const { i18n } = useTranslation();
  const isRTL = i18n.dir() === "rtl";

  return (
    <div>
      <label className="mb-4 block text-start text-[24px] font-extrabold text-[var(--brand-primary-color)]">
        {label}
      </label>

      <Select
        searchable
        value={value}
        onChange={onChange}
        options={options}
        className="h-[72px] w-full rounded-[18px] border border-[#7FB2FF] bg-white px-7 text-[22px] font-medium text-[#5F8FD7] outline-none"
        chevronClassName={`${isRTL ? "left-7" : "right-7"}`}
      />
    </div>
  );
}
