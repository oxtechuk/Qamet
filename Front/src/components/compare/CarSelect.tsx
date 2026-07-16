import { useState, useRef, useEffect } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { Search, ChevronDown, Check } from "lucide-react";
import { APP_IMAGES, getImageUrl } from "../../constants/app-images";
import api from "../../services/api/http";
import type { CarItem } from "../../types/home.types";
import type { ApiResponse } from "../../types/home.types";
import type { ICarSelectProps } from "../../interfaces/ICarSelectProps";

export default function CarSelect({
  selectedSlug,
  onSelect,
  onCancel,
  dir,
}: ICarSelectProps) {
  const { t } = useTranslation();
  const [open, setOpen] = useState(false);
  const [query, setQuery] = useState("");
  const containerRef = useRef<HTMLDivElement>(null);
  const inputRef = useRef<HTMLInputElement>(null);

  const { data: cars, isLoading: isLoadingCars } = useQuery({
    queryKey: ["car-select", query],
    queryFn: () => {
      const params: Record<string, string> = {};
      if (query) params.q = query;
      return api
        .get<ApiResponse<CarItem[]>>("store/cars/search", { params })
        .then((r) => r.data.data);
    },
  });

  useEffect(() => {
    if (open) {
      setQuery("");
      setTimeout(() => inputRef.current?.focus(), 0);
    }
  }, [open]);

  useEffect(() => {
    if (!open) return;
    const handler = (e: MouseEvent) => {
      if (
        containerRef.current &&
        !containerRef.current.contains(e.target as Node)
      ) {
        setOpen(false);
      }
    };
    document.addEventListener("mousedown", handler);
    return () => document.removeEventListener("mousedown", handler);
  }, [open]);

  const carList = Array.isArray(cars) ? cars : [];
  const selectedCar = carList.find((c) => c.slug === selectedSlug);

  return (
    <div className="w-full">
      <div ref={containerRef} className="relative mb-2">
        <button
          type="button"
          onClick={() => setOpen((p) => !p)}
          className={`flex w-full items-center gap-3 rounded-xl border bg-white px-4 py-3 text-right outline-none transition ${
            open ? "border-[#35aee8]" : "border-gray-300"
          }`}
          dir={dir}
        >
          {selectedCar ? (
            <>
              <img
                src={
                  getImageUrl(selectedCar.main_image) ||
                  APP_IMAGES.CAR_PLACEHOLDER
                }
                alt={selectedCar.name}
                className="h-10 w-10 rounded-lg object-cover"
                loading="lazy"
              />
              <div className="flex-1">
                <p className="text-sm font-bold text-[#111827]">
                  {selectedCar.name}
                </p>
                <p className="text-xs text-gray-500">
                  {selectedCar.brand?.name} - {selectedCar.year}
                </p>
              </div>
            </>
          ) : (
            <span className="text-sm text-gray-400">{t("comparePage.selectCar")}</span>
          )}
          <ChevronDown
            size={18}
            className={`shrink-0 text-gray-400 transition ${open ? "rotate-180" : ""}`}
          />
        </button>

        {open && (
          <div className="absolute left-0 right-0 top-full z-20 mt-1 max-h-60 overflow-auto rounded-xl border border-gray-200 bg-white shadow-lg">
            <div className="relative border-b border-gray-100">
              <Search
                size={15}
                className="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"
              />
              <input
                ref={inputRef}
                type="text"
                value={query}
                onChange={(e) => setQuery(e.target.value)}
                placeholder={t("comparePage.searchCar")}
                className="w-full bg-transparent px-4 py-2.5 pr-9 text-sm text-[#111827] outline-none placeholder:text-gray-400"
                dir={dir}
              />
            </div>

            {isLoadingCars ? (
              <div className="flex items-center justify-center px-4 py-8">
                <div className="h-5 w-5 animate-spin rounded-full border-2 border-gray-300 border-t-[#35aee8]" />
              </div>
            ) : carList.length === 0 ? (
              <div className="px-4 py-8 text-center text-sm text-gray-400">
                {t("comparePage.noResults")}
              </div>
            ) : (
              carList.map((car) => (
                <button
                  key={car.id}
                  type="button"
                  onClick={() => {
                    onSelect(car.slug);
                    setOpen(false);
                  }}
                  className={`flex w-full items-center gap-3 px-4 py-3 text-right transition hover:bg-[#F0F4FF] ${
                    car.slug === selectedSlug ? "bg-[#F0F4FF]" : ""
                  }`}
                  dir={dir}
                >
                  <img
                    src={
                      getImageUrl(car.main_image) || APP_IMAGES.CAR_PLACEHOLDER
                    }
                    alt={car.name}
                    className="h-12 w-12 rounded-lg object-cover"
                    loading="lazy"
                  />
                  <div className="flex-1">
                    <p className="text-sm font-bold text-[#111827]">
                      {car.name}
                    </p>
                    <p className="text-xs text-gray-500">
                      {car.brand?.name} - {car.year}
                    </p>
                  </div>
                  {car.slug === selectedSlug && (
                    <Check size={16} className="shrink-0 text-[#35aee8]" />
                  )}
                </button>
              ))
            )}
          </div>
        )}
      </div>

      <button
        type="button"
        onClick={onCancel}
        className="text-sm text-gray-500 hover:text-gray-700"
      >
        {t("comparePage.cancel")}
      </button>
    </div>
  );
}
