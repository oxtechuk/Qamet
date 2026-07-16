import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { Search } from "lucide-react";
import { getCarTypes } from "../services/api/cars.service";
import type { IAllCarsFilterBarProps } from "../interfaces/IAllCarsFilterBar";

export default function AllCarsFilterBar({
  activeFilter = "all",
  onFilterChange,
  onSearchChange,
}: IAllCarsFilterBarProps) {
  const { t, i18n } = useTranslation();

  const { data: carTypes } = useQuery({
    queryKey: ["car-types"],
    queryFn: getCarTypes,
  });

  const filters = [
    { label: t("allCarsFilterBar.all"), value: "all" },
    ...(carTypes?.map((ct) => ({ label: ct.name, value: String(ct.id) })) ?? []),
  ];

  return (
    <section dir={i18n.dir()} className="w-full border-b border-[#DDE3EA] bg-white py-6">
      <div className="mx-auto flex max-w-7xl flex-col gap-5 px-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        {/* Search */}
        <div className="relative w-full lg:max-w-[430px]">
          <input
            type="text"
            placeholder={t("allCarsFilterBar.searchPlaceholder")}
            onChange={(event) => onSearchChange?.(event.target.value)}
            className="h-[58px] w-full rounded-full border border-[#9AA3AD] bg-white px-6 pr-14 text-[15px] text-[#111827] outline-none placeholder:text-[#7A818C] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.18)]"
          />

          <Search
            size={22}
            className="absolute right-5 top-1/2 -translate-y-1/2 text-[#6B7280]"
          />
        </div>

        {/* Filters */}
        <div className="flex flex-wrap items-center justify-center gap-3 lg:justify-start">
          {filters.map((filter) => {
            const isActive = filter.value === activeFilter;

            return (
              <button
                key={filter.value}
                type="button"
                onClick={() => onFilterChange?.(filter.value)}
                className={`h-[38px] min-w-[62px] rounded-[9px] px-5 text-[14px] font-medium transition ${
                  isActive
                    ? "bg-[var(--brand-secondary-color)] text-white"
                    : "bg-[#F2F3F5] text-[#5B6470] hover:bg-[var(--brand-secondary-color)] hover:text-white"
                }`}
              >
                {filter.label}
              </button>
            );
          })}
        </div>
      </div>
    </section>
  );
}
