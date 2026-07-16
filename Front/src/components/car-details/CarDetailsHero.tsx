import { useState, useCallback } from "react";
import { useTranslation } from "react-i18next";
import {
  ArrowLeft,
  ArrowRight,
  CreditCard,
  DollarSign,
  ShieldCheck,
} from "lucide-react";
import Button from ".././button";
import { getImageUrl } from "../../constants/app-images";
import { formatPrice } from "../../utils/format";
import type { ICarColor, ICarDetailsHeroProps } from "../../interfaces/ICarDetailsHeroProps";

export default function CarDetailsHero({
  title,
  description,
  images,
  exteriorImages,
  interiorImages,
  price,
  oldPrice,
  monthlyInstallment,
  savingAmount,
  colors,
  orderTo,
  financeTo,
}: ICarDetailsHeroProps) {
  const { t, i18n } = useTranslation();
  const isRTL = i18n.dir() === "rtl";
  const [activeImage, setActiveImage] = useState(0);
  const [viewType, setViewType] = useState<"inside" | "outside">("inside");
  const [selectedColor, setSelectedColor] = useState<ICarColor | null>(null);

  const currentImages =
    viewType === "inside"
      ? interiorImages?.length
        ? interiorImages.map(getImageUrl)
        : images.map(getImageUrl)
      : exteriorImages?.length
        ? exteriorImages.map(getImageUrl)
        : images.map(getImageUrl);

  const colorImage = selectedColor?.image ? getImageUrl(selectedColor.image) : null;
  const currentImage = colorImage ?? currentImages[activeImage];
  const totalImages = currentImages.length;
  const isShowingColorImage = !!colorImage;

  const handleViewChange = useCallback((type: "inside" | "outside") => {
    setViewType(type);
    setActiveImage(0);
    setSelectedColor(null);
  }, []);

  const handleNext = () => {
    setActiveImage((prev) => (prev === totalImages - 1 ? 0 : prev + 1));
  };

  const handlePrev = () => {
    setActiveImage((prev) => (prev === 0 ? totalImages - 1 : prev - 1));
  };

  const sliderControls = !isShowingColorImage ? (
    <div className="absolute bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-4 rounded-full border border-white/70 bg-white/25 px-4 py-2 backdrop-blur-md">
      <button
        type="button"
        onClick={isRTL ? handleNext : handlePrev}
        className="flex h-[40px] w-[40px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white"
      >
        {isRTL ? <ArrowRight size={21} /> : <ArrowLeft size={21} />}
      </button>

      <div className="flex items-center gap-2" dir="ltr">
        {currentImages.map((_, index) => (
          <button
            key={index}
            type="button"
            onClick={() => setActiveImage(index)}
            className={`h-[9px] rounded-full transition ${
              activeImage === index
                ? "w-[38px] bg-[var(--brand-primary-color)]"
                : "w-[20px] bg-white/80"
            }`}
          />
        ))}
      </div>

      <button
        type="button"
        onClick={isRTL ? handlePrev : handleNext}
        className="flex h-[40px] w-[40px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white"
      >
        {isRTL ? <ArrowLeft size={21} /> : <ArrowRight size={21} />}
      </button>
    </div>
  ) : null;

  const thumbnails = !isShowingColorImage ? (
    <div className="mt-5 grid grid-cols-4 gap-4" dir="ltr">
      {currentImages.slice(0, 4).map((image, index) => (
        <button
          key={index}
          type="button"
          onClick={() => setActiveImage(index)}
          className={`overflow-hidden rounded-[14px] bg-white p-1 transition ${
            activeImage === index
              ? "ring-2 ring-[var(--brand-primary-color)]"
              : ""
          }`}
        >
          <img
            src={image}
            alt={`${title} ${index + 1}`}
            className="h-[95px] w-full rounded-[12px] object-cover"
            loading="lazy"
          />
        </button>
      ))}
    </div>
  ) : null;

  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-10">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 items-start gap-12 lg:grid-cols-2">
          {/* Content */}
          <div className="order-2 lg:order-1">
            <h1 className="text-[34px] font-extrabold leading-tight text-[#020817] md:text-[46px]">
              {title}
            </h1>

            <p className="mt-4 max-w-2xl text-[18px] leading-9 text-[#5F6672]">
              {description}
            </p>

            {/* Price Card */}
            <div className="mt-9 rounded-[18px] bg-white px-6 py-5 shadow-sm">
              <div className="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                  <p className="mb-2 text-[18px] font-medium text-[#8A8F99]">
                    {t("carDetails.hero.price")}
                  </p>

                  <p className="text-[42px] font-extrabold leading-none text-[var(--brand-secondary-color)] md:text-[52px]">
                    {formatPrice(price, "var(--brand-secondary-color)")}
                  </p>
                </div>

                {oldPrice && (
                  <div>
                    <p className="mb-2 text-[18px] font-medium text-[#8A8F99]">
                      {t("carDetails.hero.originalPrice")}
                    </p>

                    <p className="text-[28px] font-bold text-[#5F6672] line-through">
                      {formatPrice(oldPrice, "#5F6672")}
                    </p>
                  </div>
                )}
              </div>

              <div className="mt-7 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div className="flex h-[46px] items-center justify-center rounded-[9px] bg-[#EAF1FA] text-[17px] font-bold text-[#034EA2]">
                  {t("carDetails.hero.installmentFrom")} {formatPrice(monthlyInstallment, "#034EA2")}
                </div>

                {savingAmount && (
                  <div className="flex h-[46px] items-center justify-center rounded-[9px] bg-[#FFF0EB] text-[17px] font-bold text-[var(--brand-secondary-color)]">
                    {t("carDetails.hero.saving")} {formatPrice(savingAmount, "var(--brand-secondary-color)")}
                  </div>
                )}
              </div>
            </div>

            {/* Colors */}
            <div className="mt-7 flex flex-wrap items-center justify-between gap-5 rounded-[18px] border border-[#DDE8F6] bg-white px-6 py-5">
              <h3 className="text-[20px] font-bold text-[#111827]">
                {t("carDetails.hero.availableColors")}
              </h3>

              <div className="flex items-center gap-5">
                {colors.map((color) => (
                  <button
                    key={color.name}
                    type="button"
                    onClick={() => setSelectedColor(selectedColor?.name === color.name ? null : color)}
                    aria-label={color.name}
                    className={`h-[54px] w-[54px] rounded-full border-2 p-[3px] ${
                      selectedColor?.name === color.name
                        ? "border-[var(--brand-primary-color)]"
                        : "border-[#D1D5DB]"
                    }`}
                  >
                    <span
                      className="block h-full w-full rounded-full border border-black/10"
                      style={{ backgroundColor: color.value }}
                    />
                  </button>
                ))}
              </div>
            </div>

            {/* Actions */}
            <div className="mt-8 grid grid-cols-1 gap-5 md:grid-cols-2">
              <Button
                to={orderTo}
                className="h-[60px] px-6 py-0 text-[20px]"
              >
                {t("carDetails.hero.orderNow")}
              </Button>

              <Button
                to={financeTo}
                bgColor="bg-transparent"
                textColor="text-[var(--brand-primary-color)]"
                className="h-[60px] border border-[var(--brand-primary-color)] px-6 py-0 text-[20px] hover:bg-[var(--brand-primary-color)] hover:text-white"
              >
                {t("carDetails.hero.calculateFinance")}
              </Button>
            </div>

            {/* Benefits */}
            <div className="mt-8 grid grid-cols-3 gap-8 text-center">
              <Benefit
                icon={<ShieldCheck size={30} />}
                title={t("carDetails.hero.benefitQuality")}
                color="blue"
              />
              <Benefit
                icon={<DollarSign size={30} />}
                title={t("carDetails.hero.benefitInstallment")}
                color="orange"
              />
              <Benefit
                icon={<CreditCard size={30} />}
                title={t("carDetails.hero.benefitSecurePayment")}
                color="blue"
              />
            </div>
          </div>

          {/* Gallery */}
          <div className="order-1 lg:order-2">
            {/* Tabs */}
            <div className="mb-5 grid h-[68px] grid-cols-2 rounded-[8px] bg-white p-2">
              <button
                type="button"
                onClick={() => handleViewChange("inside")}
                className={`rounded-[8px] text-[20px] font-bold transition ${
                  viewType === "inside"
                    ? "bg-[#E5F0FC] text-[var(--brand-primary-color)]"
                    : "text-[#5F6672]"
                }`}
              >
                {t("carDetails.hero.insideView")}
              </button>

              <button
                type="button"
                onClick={() => handleViewChange("outside")}
                className={`rounded-[8px] text-[20px] font-bold transition ${
                  viewType === "outside"
                    ? "bg-[#E5F0FC] text-[var(--brand-primary-color)]"
                    : "text-[#5F6672]"
                }`}
              >
                {t("carDetails.hero.outsideView")}
              </button>
            </div>

            {/* Main Image */}
            <div className="relative overflow-hidden rounded-[18px] bg-white">
              <img
                src={currentImage}
                alt={title}
                className="h-[360px] w-full object-cover md:h-[480px]"
                loading="lazy"
              />

              {sliderControls}

              {isShowingColorImage && (
                <div className="absolute bottom-5 left-1/2 -translate-x-1/2 rounded-full bg-black/50 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm">
                  {selectedColor?.name}
                </div>
              )}

              {isShowingColorImage && (
                <button
                  type="button"
                  onClick={() => setSelectedColor(null)}
                  className="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-black/50 text-white transition hover:bg-black/70"
                  aria-label="Back to gallery"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                  </svg>
                </button>
              )}
            </div>

            {/* Thumbnails */}
            {thumbnails}
          </div>
        </div>
      </div>
    </section>
  );
}

function Benefit({
  icon,
  title,
  color,
}: {
  icon: React.ReactNode;
  title: string;
  color: "blue" | "orange";
}) {
  const isOrange = color === "orange";

  return (
    <div className="flex flex-col items-center">
      <div
        className={`flex h-[72px] w-[72px] items-center justify-center rounded-full ${
          isOrange
            ? "bg-[#FFF0EB] text-[var(--brand-secondary-color)]"
            : "bg-[#E0EBFA] text-[#034EA2]"
        }`}
      >
        {icon}
      </div>

      <p
        className={`mt-3 text-[18px] font-bold ${
          isOrange
            ? "text-[var(--brand-secondary-color)]"
            : "text-[#034EA2]"
        }`}
      >
        {title}
      </p>
    </div>
  );
}