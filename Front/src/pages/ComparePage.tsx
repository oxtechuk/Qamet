import { useState } from "react";
import { useSearchParams } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import { useTranslation } from "react-i18next";
import CompareCarCard from "../components/compare/CompareCarCard";
import CompareTable from "../components/compare/CompareTable";
import CompareSummary from "../components/compare/CompareSummary";
import CarSelect from "../components/compare/CarSelect";
import LoadingSlot from "../components/compare/LoadingSlot";
import EmptySlot from "../components/compare/EmptySlot";
import { useSEO } from "../utils/useSEO";
import { getCarBySlug, compareCars } from "../services/api/cars.service";
import type { CarDetails } from "../types/cars.types";

/* ---------------- Slot sub-component ---------------- */

interface ICompareCarSlotProps {
  slug: string;
  car: CarDetails | undefined;
  isLoading: boolean;
  showSearch: boolean;
  label: string;
  dir: string;
  onSelect: (slug: string) => void;
  onRemove: () => void;
  onShowSearch: () => void;
  onHideSearch: () => void;
}

function CompareCarSlot({
  slug,
  car,
  isLoading,
  showSearch,
  label,
  dir,
  onSelect,
  onRemove,
  onShowSearch,
  onHideSearch,
}: ICompareCarSlotProps) {
  if (slug && car) {
    return <CompareCarCard car={car} label={label} onRemove={onRemove} />;
  }
  if (slug && isLoading) {
    return <LoadingSlot />;
  }
  if (showSearch) {
    return (
      <CarSelect
        selectedSlug={slug}
        onSelect={onSelect}
        onCancel={onHideSearch}
        dir={dir}
      />
    );
  }
  return <EmptySlot onClick={onShowSearch} />;
}

/* ---------------- Main page ---------------- */

export default function ComparePage() {
  const { t, i18n } = useTranslation();
  useSEO(t("pageTitles.compare"), t("comparePage.compareDescription"));
  const [searchParams] = useSearchParams();
  const initialSlug = searchParams.get("slug") || "";

  const [car1Slug, setCar1Slug] = useState(initialSlug);
  const [car2Slug, setCar2Slug] = useState("");

  const [showSearch1, setShowSearch1] = useState(!initialSlug);
  const [showSearch2, setShowSearch2] = useState(false);

  const { data: car1, isLoading: isLoading1 } = useQuery({
    queryKey: ["compare-car1", car1Slug],
    queryFn: () => getCarBySlug(car1Slug),
    enabled: !!car1Slug,
  });

  const { data: car2, isLoading: isLoading2 } = useQuery({
    queryKey: ["compare-car2", car2Slug],
    queryFn: () => getCarBySlug(car2Slug),
    enabled: !!car2Slug,
  });

  const { data: compareData } = useQuery({
    queryKey: ["compare-result", car1Slug, car2Slug],
    queryFn: () => compareCars([car1Slug, car2Slug]),
    enabled: !!car1Slug && !!car2Slug,
  });

  const dir = i18n.dir();

  return (
    <div dir={dir} className="min-h-screen overflow-x-hidden bg-[#f3f6fa]">
      <div className="relative z-20 mt-[80px] px-6 pb-20">
        <div className="mx-auto max-w-[1200px]">
          <div className="grid grid-cols-[minmax(280px,380px)_1fr_minmax(280px,380px)] items-start gap-12 max-lg:grid-cols-1 max-lg:max-w-[460px] max-lg:mx-auto max-lg:gap-7">
            {/* Car 1 slot */}
            <div className="max-lg:order-1">
              <CompareCarSlot
                slug={car1Slug}
                car={car1}
                isLoading={isLoading1}
                showSearch={showSearch1}
                label={t("comparePage.carOne")}
                dir={dir}
                onSelect={(slug) => { setCar1Slug(slug); setShowSearch1(false); }}
                onRemove={() => { setCar1Slug(""); setShowSearch1(true); }}
                onShowSearch={() => setShowSearch1(true)}
                onHideSearch={() => setShowSearch1(false)}
              />
            </div>

            {/* VS divider */}
            <div className="relative flex min-h-[320px] flex-col items-center max-lg:order-2 max-lg:min-h-auto">
              <div
                className="absolute left-1/2 -translate-x-1/2"
                style={{
                  top: 0,
                  bottom: "calc(50% + 36px)",
                  width: "1px",
                  background: "linear-gradient(to bottom, transparent 0%, rgba(2,31,56,0.38) 100%)",
                }}
              />
              <div
                className="absolute left-1/2 -translate-x-1/2"
                style={{
                  top: "calc(50% + 36px)",
                  bottom: 0,
                  width: "1px",
                  background: "linear-gradient(to bottom, rgba(2,31,56,0.38) 0%, transparent 100%)",
                }}
              />
              <div className="relative z-10 mt-auto mb-auto flex h-[64px] w-[64px] items-center justify-center rounded-full border-2 border-[var(--brand-primary-color)] bg-white text-[18px] font-black text-[var(--brand-primary-color)]">
                {t("comparePage.vs")}
              </div>
            </div>

            {/* Car 2 slot */}
            <div className="max-lg:order-3">
              <CompareCarSlot
                slug={car2Slug}
                car={car2}
                isLoading={isLoading2}
                showSearch={showSearch2}
                label={t("comparePage.carTwo")}
                dir={dir}
                onSelect={(slug) => { setCar2Slug(slug); setShowSearch2(false); }}
                onRemove={() => { setCar2Slug(""); setShowSearch2(true); }}
                onShowSearch={() => setShowSearch2(true)}
                onHideSearch={() => setShowSearch2(false)}
              />
            </div>
          </div>
        </div>
      </div>

      {car1Slug &&
        car2Slug &&
        compareData &&
        compareData.length > 0 &&
        car1 &&
        car2 && (
          <>
            <div className="mx-auto max-w-7xl px-6 pb-16">
              <CompareTable
                sections={compareData}
                car1Name={`${car1.brand?.name} ${car1.name}`}
                car2Name={`${car2.brand?.name} ${car2.name}`}
              />
            </div>
            <CompareSummary
              sections={compareData}
              car1Name={`${car1.brand?.name} ${car1.name}`}
              car2Name={`${car2.brand?.name} ${car2.name}`}
              car1Slug={car1Slug}
              car2Slug={car2Slug}
            />
          </>
        )}
    </div>
  );
}
