import type { CSSProperties } from "react";
import type { IBgImageMaskedSectionV2Props } from "../../interfaces/IBgImageMaskedSectionV2Props";
import "./BgImageMaskedSection.css";

export default function BgImageMaskedSectionV2({
  backgroundSrc,
  imageSrc,
  children,
  dir = "rtl",
  className = "",
  contentClassName = "",
}: IBgImageMaskedSectionV2Props) {
  return (
    <section
      dir={dir}
      className={`bg-image-masked-section ${className}`}
      style={
        {
          "--bg-image": `url(${backgroundSrc})`,
        } as CSSProperties
      }
    >
      <div className="bg-image-masked-section__overlay" />

      <div className={`bg-image-masked-section__content flex flex-col items-center gap-6 ${contentClassName}`}>
        <img
          src={imageSrc}
          alt="compare"
          className="max-h-[400px] w-full max-w-[600px] object-contain"
          loading="lazy"
        />
        {children}
      </div>
    </section>
  );
}
