import type { CSSProperties } from "react";
import type { IBgImageMaskedSectionProps } from "../../interfaces/IBgImageMaskedSectionProps";
import "./BgImageMaskedSection.css";

export default function BgImageMaskedSection({
  imageSrc,
  children,
  dir = "rtl",
  className = "",
  contentClassName = "",
}: IBgImageMaskedSectionProps) {
  return (
    <section
      dir={dir}
      className={`bg-image-masked-section ${className}`}
      style={
        {
          "--bg-image": `url(${imageSrc})`,
        } as CSSProperties
      }
    >
      <div className="bg-image-masked-section__overlay" />

      <div className={`bg-image-masked-section__content ${contentClassName}`}>
        {children}
      </div>
    </section>
  );
}
