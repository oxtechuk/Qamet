import { useRef, useState } from "react";
import { Pause, Play } from "lucide-react";
import { useTranslation } from "react-i18next";
import LazyImg from "../LazyImg";

export interface ShowroomGalleryItem {
    id: string | number;
    src: string;
    alt?: string;
    type?: "image" | "video";
    poster?: string;
}

interface ShowroomGallerySectionProps {
    title?: string;
    logoSrc: string;
    logoAlt?: string;
    items: ShowroomGalleryItem[];
    className?: string;
}

export default function ShowroomGallerySection({
    title,
    logoSrc,
    logoAlt = "Company logo",
    items,
    className = "",
}: ShowroomGallerySectionProps) {
    const { t, i18n } = useTranslation();
    const resolvedTitle = title ?? t("about.gallery.title");

    const galleryItems = items.slice(0, 4);

    if (!galleryItems.length) {
        return null;
    }

    return (
        <section
            dir={i18n.dir()}
            className={`w-full bg-[#FAFAF8] py-12 sm:py-16 lg:py-20 ${className}`}
        >
            <div className="mx-auto max-w-[1240px] px-4 sm:px-6 lg:px-8">
                {resolvedTitle && (
                    <h2 className="mb-8 text-center text-[23px] font-extrabold text-[var(--brand-primary-color)] sm:text-[28px]">
                        {resolvedTitle}
                    </h2>
                )}

                {/* Desktop and tablet */}
                <div className="relative hidden aspect-[1.322/1] w-full md:block">
                    {/* Top-left vertical item */}
                    {galleryItems[0] && (
                        <GalleryCell
                            item={galleryItems[0]}
                            className="
                absolute
                left-0
                top-0
                h-[57.3%]
                w-[39.5%]
                rounded-[16px]
              "
                        />
                    )}

                    {/* Top-right horizontal item */}
                    {galleryItems[1] && (
                        <GalleryCell
                            item={galleryItems[1]}
                            className="
                absolute
                right-0
                top-0
                h-[40.5%]
                w-[59%]
                rounded-[16px]
              "
                        />
                    )}

                    {/* Bottom-left horizontal item */}
                    {galleryItems[2] && (
                        <GalleryCell
                            item={galleryItems[2]}
                            className="
                absolute
                bottom-0
                left-0
                h-[40.6%]
                w-[59.2%]
                rounded-[16px]
              "
                        />
                    )}

                    {/* Bottom-right vertical item */}
                    {galleryItems[3] && (
                        <GalleryCell
                            item={galleryItems[3]}
                            className="
                absolute
                bottom-0
                right-0
                h-[57.8%]
                w-[39.5%]
                rounded-[16px]
              "
                        />
                    )}

                    {/* Large center logo */}
                    <div
                        className="
              pointer-events-none
              absolute
              left-1/2
              top-[51.5%]
              z-30
              flex
              h-[240px]
              w-[240px]
              -translate-x-1/2
              -translate-y-1/2
              items-center
              justify-center
              rounded-full
              bg-white
              shadow-[0_14px_40px_rgba(2,31,56,0.14)]
              lg:h-[280px]
              lg:w-[280px]
              xl:h-[310px]
              xl:w-[310px]
            "
                    >
                        <LazyImg
                            src={logoSrc}
                            alt={logoAlt}
                            className="max-h-[64%] max-w-[78%] object-contain"
                        />
                    </div>
                </div>

                {/* Mobile */}
                <div className="relative grid grid-cols-2 gap-2 sm:gap-3 md:hidden">
                    {galleryItems.map((item, index) => (
                        <GalleryCell
                            key={item.id}
                            item={item}
                            className={[
                                "relative overflow-hidden rounded-[10px] sm:rounded-[13px]",
                                index === 0 ? "h-[180px] sm:h-[220px] md:h-[260px]" : "",
                                index === 1 ? "h-[140px] sm:h-[170px] md:h-[190px]" : "",
                                index === 2 ? "-mt-[50px] sm:-mt-[60px] md:-mt-[70px] h-[140px] sm:h-[170px] md:h-[190px]" : "",
                                index === 3 ? "h-[180px] sm:h-[220px] md:h-[260px]" : "",
                            ].join(" ")}
                        />
                    ))}

                    {/* Large mobile center logo */}
                    <div
                        className="
              pointer-events-none
              absolute
              left-1/2
              top-1/2
              z-30
              flex
              h-[100px]
              w-[100px]
              -translate-x-1/2
              -translate-y-1/2
              items-center
              justify-center
              rounded-full
              bg-white
              shadow-[0_8px_24px_rgba(2,31,56,0.15)]
              sm:h-[120px]
              sm:w-[120px]
              md:h-[150px]
              md:w-[150px]
              md:shadow-[0_10px_30px_rgba(2,31,56,0.18)]
            "
                    >
                        <LazyImg
                            src={logoSrc}
                            alt={logoAlt}
                            className="max-h-[64%] max-w-[78%] object-contain"
                        />
                    </div>
                </div>
            </div>
        </section>
    );
}

interface GalleryCellProps {
    item: ShowroomGalleryItem;
    className?: string;
}

function GalleryCell({ item, className = "" }: GalleryCellProps) {
    return (
        <div
            className={[
                "group overflow-hidden bg-[#E8E8E5]",
                "shadow-[0_2px_8px_rgba(15,23,42,0.04)]",
                className,
            ].join(" ")}
        >
            {item.type === "video" ? (
                <GalleryVideo item={item} />
            ) : (
                <LazyImg
                    src={item.src}
                    alt={item.alt ?? ""}
                    className="
            h-full
            w-full
            object-cover
            transition-transform
            duration-700
            ease-out
            group-hover:scale-[1.035]
          "
                />
            )}
        </div>
    );
}

function GalleryVideo({ item }: { item: ShowroomGalleryItem }) {
    const videoRef = useRef<HTMLVideoElement>(null);
    const [isPlaying, setIsPlaying] = useState(false);

    const toggleVideo = async () => {
        const video = videoRef.current;

        if (!video) {
            return;
        }

        try {
            if (video.paused) {
                await video.play();
                setIsPlaying(true);
            } else {
                video.pause();
                setIsPlaying(false);
            }
        } catch {
            setIsPlaying(false);
        }
    };

    return (
        <div className="relative h-full w-full">
            <video
                ref={videoRef}
                src={item.src}
                poster={item.poster}
                muted
                playsInline
                preload="metadata"
                onPlay={() => setIsPlaying(true)}
                onPause={() => setIsPlaying(false)}
                onEnded={() => setIsPlaying(false)}
                className="
          h-full
          w-full
          object-cover
          transition-transform
          duration-700
          ease-out
          group-hover:scale-[1.035]
        "
            />

            <div className="pointer-events-none absolute inset-0 bg-black/10" />

            <button
                type="button"
                onClick={toggleVideo}
                aria-label={isPlaying ? "Pause video" : "Play video"}
                className="
          absolute
          left-1/2
          top-1/2
          z-10
          flex
          h-[52px]
          w-[52px]
          -translate-x-1/2
          -translate-y-1/2
          items-center
          justify-center
          rounded-full
          border
          border-white/60
          bg-white/85
          text-[var(--brand-primary-color)]
          shadow-[0_10px_28px_rgba(0,0,0,0.2)]
          backdrop-blur-md
          transition
          hover:scale-105
          hover:bg-white
        "
            >
                {isPlaying ? (
                    <Pause size={20} fill="currentColor" />
                ) : (
                    <Play size={20} fill="currentColor" className="ms-0.5" />
                )}
            </button>
        </div>
    );
}
