import { useTranslation } from "react-i18next";

interface BrandItem {
  id: string | number;
  name: string;
  logo: string;
  url?: string;
}

interface BrandsCarouselProps {
  brands: BrandItem[];
  speed?: number;
  showName?: boolean;
}

export default function BrandsCarousel({
  brands,
  speed = 28,
  showName = false,
}: BrandsCarouselProps) {
  const { i18n } = useTranslation();
  const direction = i18n.dir();

  if (!brands.length) {
    return null;
  }

  function renderBrand(brand: BrandItem, key: string | number) {
    const card = (
      <div
        className={[
          "flex shrink-0 items-center justify-center",
          "px-6",
          showName
            ? "h-auto w-[145px] flex-col gap-2 py-5 sm:w-[170px]"
            : "h-[86px] w-[145px] sm:h-[96px] sm:w-[170px]",
        ].join(" ")}
      >
        <img
          src={brand.logo}
          alt={brand.name}
          loading="lazy"
          className={[
            "max-h-[48px] max-w-[105px] object-contain",
            "transition duration-300",
            "hover:scale-105",
            "sm:max-h-[54px] sm:max-w-[120px]",
          ].join(" ")}
        />
        {showName && (
          <span className="text-[13px] font-semibold text-[#111827] sm:text-[14px]">
            {brand.name}
          </span>
        )}
      </div>
    );

    if (!brand.url) {
      return (
        <div key={key}>
          {card}
        </div>
      );
    }

    return (
      <a key={key} href={brand.url} aria-label={brand.name} className="block">
        {card}
      </a>
    );
  }

  const setA = brands.map((b, i) => renderBrand(b, `a-${i}`));
  const setB = brands.map((b, i) => renderBrand(b, `b-${i}`));

  return (
    <section
      dir={direction}
      className="w-full overflow-hidden"
    >
      <style>
        {`
          @keyframes brands-scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
          }

          .brands-carousel-track {
            display: flex;
            width: max-content;
            animation: brands-scroll ${speed}s linear infinite;
            will-change: transform;
          }

          .brands-carousel:hover .brands-carousel-track {
            animation-play-state: paused;
          }

          @media (prefers-reduced-motion: reduce) {
            .brands-carousel-track {
              animation: none !important;
            }
          }
        `}
      </style>

      <div className="brands-carousel relative overflow-hidden">
        <div className="brands-carousel-track">
          {setA}
          {setB}
        </div>
      </div>
    </section>
  );
}
