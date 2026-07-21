import { useEffect, useRef } from "react";
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
  speed = 40,
  showName = false,
}: BrandsCarouselProps) {
  const { i18n } = useTranslation();
  const direction = i18n.dir();
  const trackRef = useRef<HTMLDivElement>(null);
  const offsetRef = useRef(0);
  const rafRef = useRef<number>(0);
  const pausedRef = useRef(false);

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
      return <div key={key}>{card}</div>;
    }

    return (
      <a key={key} href={brand.url} aria-label={brand.name} className="block">
        {card}
      </a>
    );
  }

  const itemWidth = 170 + 48;
  const viewWidth = typeof window !== "undefined" ? window.innerWidth : 1440;
  const repeats = Math.max(4, Math.ceil((viewWidth * 3) / (brands.length * itemWidth)));

  const setA: React.ReactNode[] = [];
  const setB: React.ReactNode[] = [];
  for (let i = 0; i < repeats; i++) {
    for (let j = 0; j < brands.length; j++) {
      setA.push(renderBrand(brands[j], `a${i}-${j}`));
      setB.push(renderBrand(brands[j], `b${i}-${j}`));
    }
  }

  useEffect(() => {
    const track = trackRef.current;
    if (!track) return;

    const children = track.children;
    const midpoint = Math.floor(children.length / 2);
    let halfWidth = 0;
    for (let i = 0; i < midpoint; i++) {
      halfWidth += (children[i] as HTMLElement).offsetWidth;
    }
    if (halfWidth <= 0) return;

    const tick = () => {
      if (!pausedRef.current) {
        const pxPerFrame = halfWidth / (speed * 60);
        offsetRef.current += pxPerFrame;

        if (offsetRef.current >= halfWidth) {
          offsetRef.current -= halfWidth;
        }

        track.style.transform = `translateX(-${offsetRef.current}px)`;
      }
      rafRef.current = requestAnimationFrame(tick);
    };

    rafRef.current = requestAnimationFrame(tick);

    return () => {
      cancelAnimationFrame(rafRef.current);
    };
  }, [brands, speed]);

  return (
    <section dir={direction} className="w-full overflow-hidden">
      <div
        className="relative overflow-hidden"
        onMouseEnter={() => {
          pausedRef.current = true;
        }}
        onMouseLeave={() => {
          pausedRef.current = false;
        }}
      >
        <div
          ref={trackRef}
          className="flex w-max will-change-transform"
        >
          {setA}
          {setB}
        </div>
      </div>
    </section>
  );
}
