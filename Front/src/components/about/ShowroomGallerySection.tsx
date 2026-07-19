import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../../store/language.store";
import { Play } from "lucide-react";

export interface IShowroomGalleryItem {
  id: string | number;
  src: string;
  alt?: string;
  type?: "image" | "video";
  poster?: string;
}

interface IShowroomGallerySectionProps {
  title?: string;
  logoSrc: string;
  logoAlt?: string;
  items: IShowroomGalleryItem[];
  className?: string;
}

export default function ShowroomGallerySection({
  title,
  logoSrc,
  logoAlt,
  items,
  className = "",
}: IShowroomGallerySectionProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);

  const resolvedTitle = title || t("aboutPage.gallery.title");
  const resolvedLogoAlt = logoAlt || t("aboutPage.gallery.logoAlt");

  const g = items.slice(0, 4);
  if (!g.length) return null;

  return (
    <section
      dir={direction}
      className={`w-full bg-[#FAFAF8] py-12 sm:py-16 lg:py-20 ${className}`}
    >
      <div className="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8">
        <h2 className="mb-8 text-center text-[23px] font-extrabold text-[var(--brand-primary-color)] sm:text-[28px]">
          {resolvedTitle}
        </h2>

        <div
          className="relative grid grid-cols-2 gap-3"
          style={{ gridTemplateRows: "auto auto", alignItems: "stretch" }}
        >
          <div className="overflow-hidden rounded-[14px]" style={{ aspectRatio: "445/502" }}>
            {g[0] && <GalleryItem item={g[0]} />}
          </div>

          <div className="overflow-hidden rounded-[14px]">
            {g[1] && <GalleryItem item={g[1]} />}
          </div>

          <div className="overflow-hidden rounded-[14px]" style={{ aspectRatio: "681/356" }}>
            {g[3] && <GalleryItem item={g[3]} />}
          </div>

          <div className="overflow-hidden rounded-[14px]">
            {g[2] && <GalleryItem item={g[2]} />}
          </div>

          <div className="pointer-events-none absolute inset-0 z-20 flex items-center justify-center">
            <div className="flex h-[12vw] w-[12vw] max-h-[170px] max-w-[170px] min-h-[90px] min-w-[90px] items-center justify-center rounded-full border-[5px] border-white bg-white shadow-[0_14px_40px_rgba(2,31,56,0.22)]">
              <img
                src={logoSrc}
                alt={resolvedLogoAlt}
                loading="lazy"
                className="max-h-[65%] max-w-[75%] object-contain"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

function GalleryItem({ item }: { item: IShowroomGalleryItem }) {
  const isVideo = item.type === "video";
  return (
    <div className="group relative h-full w-full bg-[#E8E8E5]">
      {isVideo ? (
        <>
          <video
            src={item.src}
            poster={item.poster}
            muted
            playsInline
            preload="metadata"
            className="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
          />
          <div className="pointer-events-none absolute inset-0 bg-black/15" />
          <button
            type="button"
            aria-label="Play video"
            onClick={(e) => {
              const v = e.currentTarget.parentElement?.querySelector("video");
              if (!v) return;
              v.paused ? v.play() : v.pause();
            }}
            className="absolute start-1/2 top-1/2 z-10 flex h-[48px] w-[48px] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-white/50 bg-white/85 text-[var(--brand-primary-color)] shadow-lg backdrop-blur-md transition hover:scale-105 hover:bg-white"
          >
            <Play size={20} fill="currentColor" className="ms-0.5" />
          </button>
        </>
      ) : (
        <img
          src={item.src}
          alt={item.alt ?? ""}
          loading="lazy"
          className="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
        />
      )}
    </div>
  );
}
