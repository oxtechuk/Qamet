import { useState, useEffect, useRef } from "react";
import { useTranslation } from "react-i18next";
import { useNavigate } from "react-router-dom";
import { searchCars } from "../services/api/cars.service";
import { getImageUrl } from "../constants/app-images";
import { formatPrice } from "../utils/format";
import type { CarItem } from "../types/home.types";
import { Search, Loader2 } from "lucide-react";

interface IAllCarsSearchBarProps {
  searchValue: string;
  onSearchChange: (value: string) => void;
  onSearchSubmit: () => void;
  resultCount: number;
}

export default function AllCarsSearchBar({
  searchValue,
  onSearchChange,
  onSearchSubmit,
  resultCount,
}: IAllCarsSearchBarProps) {
  const { t, i18n } = useTranslation();
  const navigate = useNavigate();
  const isRtl = i18n.dir() === "rtl";

  const [inputValue, setInputValue] = useState(searchValue);
  const [suggestions, setSuggestions] = useState<CarItem[]>([]);
  const [isLoadingSuggestions, setIsLoadingSuggestions] = useState(false);
  const [showDropdown, setShowDropdown] = useState(false);
  const containerRef = useRef<HTMLDivElement>(null);

  // Sync external search value changes
  useEffect(() => {
    setInputValue(searchValue);
  }, [searchValue]);

  // Debounced suggestions search
  useEffect(() => {
    const trimmed = inputValue.trim();
    if (!trimmed || trimmed.length < 1) {
      setSuggestions([]);
      setIsLoadingSuggestions(false);
      return;
    }

    setIsLoadingSuggestions(true);
    const timeoutId = setTimeout(async () => {
      try {
        const results = await searchCars(trimmed);
        setSuggestions(results ? results.slice(0, 6) : []);
      } catch {
        setSuggestions([]);
      } finally {
        setIsLoadingSuggestions(false);
      }
    }, 280);

    return () => clearTimeout(timeoutId);
  }, [inputValue]);

  // Click outside to close dropdown
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (containerRef.current && !containerRef.current.contains(event.target as Node)) {
        setShowDropdown(false);
      }
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const val = e.target.value;
    setInputValue(val);
    setShowDropdown(true);
  };

  const handleTriggerSearch = () => {
    setShowDropdown(false);
    onSearchChange(inputValue);
    onSearchSubmit();
  };

  const handleSelectCar = (car: CarItem) => {
    setShowDropdown(false);
    if (car.slug) {
      navigate(`/cars/${car.slug}`);
    } else {
      setInputValue(car.name ?? "");
      onSearchChange(car.name ?? "");
      onSearchSubmit();
    }
  };

  return (
    <div className="mb-5 relative" dir={i18n.dir()} ref={containerRef}>
      <div className="flex items-center gap-3">
        <div className="relative flex-1">
          <input
            type="text"
            value={inputValue}
            onChange={handleInputChange}
            onFocus={() => {
              if (inputValue.trim().length > 0) {
                setShowDropdown(true);
              }
            }}
            onKeyDown={(e) => {
              if (e.key === "Enter") {
                handleTriggerSearch();
              } else if (e.key === "Escape") {
                setShowDropdown(false);
              }
            }}
            placeholder={t("carFinder.searchPlaceholder")}
            className="h-[48px] w-full rounded-[12px] border border-[#E2E8F0] bg-white pe-12 ps-4 text-[14px] text-[#111827] outline-none placeholder:text-[#9CA3AF] focus:border-[var(--brand-primary-color)] transition-colors"
          />
          <span className="pointer-events-none absolute end-4 top-1/2 -translate-y-1/2 text-[#9CA3AF]">
            {isLoadingSuggestions ? (
              <Loader2 className="h-4 w-4 animate-spin text-[var(--brand-primary-color)]" />
            ) : (
              <Search className="h-4 w-4" />
            )}
          </span>

          {/* Autocomplete / Suggestions Dropdown */}
          {showDropdown && inputValue.trim().length > 0 && (
            <div className="absolute start-0 top-full z-50 mt-1.5 w-full rounded-2xl border border-gray-200 bg-white p-2 shadow-xl">
              {isLoadingSuggestions ? (
                <div className="flex items-center justify-center gap-2 py-4 text-xs font-semibold text-gray-400">
                  <Loader2 className="h-4 w-4 animate-spin text-[var(--brand-primary-color)]" />
                  <span>{isRtl ? "جاري البحث عن المقترحات..." : "Searching suggestions..."}</span>
                </div>
              ) : suggestions.length > 0 ? (
                <div className="flex flex-col gap-1">
                  <div className="px-2 py-1 text-[11px] font-bold text-gray-400">
                    {isRtl ? "السيارات المقترحة" : "Suggested Cars"}
                  </div>
                  {suggestions.map((car) => (
                    <div
                      key={car.id}
                      onClick={() => handleSelectCar(car)}
                      className="flex items-center justify-between gap-3 rounded-xl p-2 transition hover:bg-gray-50 cursor-pointer"
                    >
                      <div className="flex items-center gap-3">
                        {car.main_image ? (
                          <img
                            src={getImageUrl(car.main_image)}
                            alt={car.name}
                            className="h-10 w-14 rounded-lg object-cover border border-gray-100 shrink-0"
                          />
                        ) : (
                          <div className="flex h-10 w-14 items-center justify-center rounded-lg bg-gray-100 text-gray-400 shrink-0">
                            <Search size={16} />
                          </div>
                        )}
                        <div className="text-start">
                          <h4 className="text-[13px] font-bold text-[#111827] line-clamp-1">
                            {car.name}
                          </h4>
                          <span className="text-[11px] text-gray-400">
                            {car.brand?.name}{car.year ? ` · ${car.year}` : ""}
                          </span>
                        </div>
                      </div>

                      {(car.cash_price || car.current_price) && (
                        <div className="text-end shrink-0 ps-2">
                          <span className="text-[12px] font-extrabold text-[var(--brand-primary-color)]">
                            {formatPrice(car.current_price ?? car.cash_price ?? 0, "var(--brand-primary-color)")}
                          </span>
                        </div>
                      )}
                    </div>
                  ))}

                  <button
                    type="button"
                    onClick={handleTriggerSearch}
                    className="mt-1 flex w-full items-center justify-center gap-2 rounded-xl bg-gray-50 py-2 text-xs font-bold text-[var(--brand-primary-color)] transition hover:bg-gray-100"
                  >
                    <span>{isRtl ? `عرض جميع نتائج البحث عن "${inputValue}"` : `View all results for "${inputValue}"`}</span>
                  </button>
                </div>
              ) : (
                <div className="py-4 text-center text-xs font-semibold text-gray-400">
                  {isRtl ? "لا توجد نتائج مطابقة لبحثك" : "No matching cars found"}
                </div>
              )}
            </div>
          )}
        </div>

        <button
          type="button"
          onClick={handleTriggerSearch}
          className="h-[48px] shrink-0 rounded-[12px] bg-[var(--brand-secondary-color)] px-6 text-[14px] font-bold text-[var(--brand-primary-color)] transition hover:opacity-90"
        >
          {t("carFinder.searchButton")}
        </button>
      </div>

      <p className="mt-2 text-start text-[13px] font-semibold text-[#111827]">
        <span className="text-[var(--brand-secondary-color)]">{resultCount}</span>{" "}
        {t("allCarsPage.availableCars")}
      </p>
    </div>
  );
}
