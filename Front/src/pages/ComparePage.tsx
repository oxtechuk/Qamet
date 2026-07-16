import { useState } from "react";
import { useSearchParams } from "react-router-dom";
import { useQuery } from "@tanstack/react-query";
import { useTranslation } from "react-i18next";
import BgImageMaskedSection from "../components/BgImageMaskedSection/BgImageMaskedSection";
import CompareCarCard from "../components/compare/CompareCarCard";
import CompareTable from "../components/compare/CompareTable";
import CompareSummary from "../components/compare/CompareSummary";
import CarSelect from "../components/compare/CarSelect";
import LoadingSlot from "../components/compare/LoadingSlot";
import EmptySlot from "../components/compare/EmptySlot";
import CarBadge from "../components/compare/CarBadge";
import ContactCtaSection from "../components/ContactCtaSection";
import { APP_IMAGES } from "../constants/app-images";
import { useSEO } from "../utils/useSEO";
import { getCarBySlug, compareCars } from "../services/api/cars.service";

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

  const handleSelectCar1 = (slug: string) => {
    setCar1Slug(slug);
    setShowSearch1(false);
  };

  const handleRemoveCar1 = () => {
    setCar1Slug("");
    setShowSearch1(true);
  };

  const handleSelectCar2 = (slug: string) => {
    setCar2Slug(slug);
    setShowSearch2(false);
  };

  const handleRemoveCar2 = () => {
    setCar2Slug("");
    setShowSearch2(true);
  };

  return (
    <div dir={i18n.dir()} className="min-h-screen overflow-x-hidden bg-[#f3f6fa]">
      <BgImageMaskedSection imageSrc={APP_IMAGES.COMPARE_IMAGE} />

      <div className="relative z-20 -mt-[100px] px-6 pb-20">
        <div className="mx-auto max-w-[1200px]">
          <div className="grid grid-cols-[minmax(280px,380px)_1fr_minmax(280px,380px)] items-start gap-12 max-lg:grid-cols-1 max-lg:max-w-[460px] max-lg:mx-auto max-lg:gap-7">
            <div className="max-lg:order-1">
              {car1Slug && car1 ? (
                <CompareCarCard car={car1} onRemove={handleRemoveCar1} />
              ) : car1Slug && isLoading1 ? (
                <LoadingSlot />
              ) : showSearch1 ? (
                <CarSelect
                  selectedSlug={car1Slug}
                  onSelect={handleSelectCar1}
                  onCancel={() => setShowSearch1(false)}
                  dir={i18n.dir()}
                />
              ) : (
                <EmptySlot onClick={() => setShowSearch1(true)} />
              )}
            </div>

            <div className="relative flex min-h-[320px] flex-col items-center max-lg:order-2 max-lg:min-h-auto">
              <div className="mt-10 mb-5 flex h-[70px] w-[70px] items-center justify-center rounded-full bg-[#35aee8] text-[26px] font-black text-white shadow-lg max-lg:mt-0">
                {t("comparePage.vs")}
              </div>

              {car1Slug && car1 && (
                <>
                  <CarBadge
                    num={1}
                    name={`${car1.brand?.name} ${car1.name}`}
                    year={car1.year}
                  />
                  <div className="mt-5 h-[120px] w-px bg-[#cfd6df] max-lg:hidden" />
                </>
              )}

              {car2Slug && car2 && (
                <CarBadge
                  num={2}
                  name={`${car2.brand?.name} ${car2.name}`}
                  year={car2.year}
                />
              )}
            </div>

            <div className="max-lg:order-3">
              {car2Slug && car2 ? (
                <CompareCarCard car={car2} onRemove={handleRemoveCar2} />
              ) : car2Slug && isLoading2 ? (
                <LoadingSlot />
              ) : showSearch2 ? (
                <CarSelect
                  selectedSlug={car2Slug}
                  onSelect={handleSelectCar2}
                  onCancel={() => setShowSearch2(false)}
                  dir={i18n.dir()}
                />
              ) : (
                <EmptySlot onClick={() => setShowSearch2(true)} />
              )}
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
            />
          </>
        )}

      <ContactCtaSection
        badgeText={t("allCarsPage.contactBadge")}
        titleWhite={t("allCarsPage.contactTitleWhite")}
        titleOrange={t("allCarsPage.contactTitleOrange")}
        description={t("allCarsPage.contactDescription")}
        phoneText={t("allCarsPage.contactPhone")}
        phoneHref="tel:+966500000000"
        whatsappText={t("allCarsPage.contactWhatsapp")}
        
      />
    </div>
  );
}
