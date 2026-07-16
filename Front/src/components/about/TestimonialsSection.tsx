import { useState, useEffect, useCallback } from "react";
import { useTranslation } from "react-i18next";
import { Star } from "lucide-react";
import TestimonialCard from "./TestimonialCard";
import type { ITestimonialsSectionProps } from "../../interfaces/ITestimonialsSectionProps";

export default function TestimonialsSection({
  badge,
  titleBlack,
  titleBlue,
  ratingText,
  testimonials,
}: ITestimonialsSectionProps) {
  const { i18n, t } = useTranslation();
  const [activeIndex, setActiveIndex] = useState(0);
  const total = testimonials.length;

  const next = useCallback(() => {
    setActiveIndex((prev) => (prev + 1) % total);
  }, [total]);

  useEffect(() => {
    if (total < 2) return;
    const id = setInterval(next, 4000);
    return () => clearInterval(id);
  }, [next, total]);

  if (total === 0) return null;

  // Build a 3-card window: [prev, active, next]
  const visibleIndices = [
    (activeIndex - 1 + total) % total,
    activeIndex,
    (activeIndex + 1) % total,
  ];

  return (
    <section dir={i18n.dir()} className="bg-[#F3F6FA] px-6 py-20">
      <div className="mx-auto max-w-[1200px]">
        <div className="mb-16 flex items-start justify-between gap-8 max-md:flex-col-reverse max-md:items-start">
          <div className="text-start">
            <p className="mb-4 text-sm font-bold text-[#FF5B2E]">{badge}</p>
            <h2 className="text-4xl font-black text-[#111827] max-sm:text-3xl">
              {titleBlack} <span className="text-[#2FA3DC]">{titleBlue}</span>
            </h2>
          </div>
          <div className="pt-8 text-[#FF5B2E]">
            <div className="flex items-center gap-1 text-lg font-extrabold">
              <Star size={18} fill="#FF5B2E" strokeWidth={0} />
              <span>
                {ratingText || t("aboutPage.testimonials.ratingText")}
              </span>
            </div>
          </div>
        </div>

        <div className="grid items-center gap-8 lg:grid-cols-[1fr_1.22fr_1fr]">
          {visibleIndices.map((tIdx, col) => (
            <div key={tIdx} className={col === 1 ? "" : "hidden lg:block"}>
              <TestimonialCard
                testimonial={{ ...testimonials[tIdx], isActive: col === 1 }}
              />
            </div>
          ))}
        </div>

        <div className="mt-10 flex items-center justify-center gap-2">
          {testimonials.map((_, i) => (
            <button
              key={i}
              type="button"
              onClick={() => setActiveIndex(i)}
              className={`h-2.5 rounded-full transition-all ${
                i === activeIndex ? "w-7 bg-[#2FA3DC]" : "w-2.5 bg-[#C6CCD4]"
              }`}
              aria-label={t("aboutPage.testimonials.goToTestimonial", {
                number: i + 1,
              })}
            />
          ))}
        </div>
      </div>
    </section>
  );
}
