import { useCallback, useEffect, useState } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../../store/language.store";
import LazyImg from "../LazyImg";

export interface ITestimonialItem {
  id: string | number;
  quote: string;
  name: string;
  role?: string;
  avatar?: string;
}

interface ITestimonialsSectionProps {
  title?: string;
  testimonials: ITestimonialItem[];
  autoPlay?: boolean;
  interval?: number;
}

const MOCK_TESTIMONIALS: ITestimonialItem[] = [
  { id: 1, quote: "تجربة ممتازة في شراء السيارة، والخدمة كانت احترافية من البداية للنهاية. أنصح الجميع بالتعامل معهم.", name: "محمد العتيبي", role: "عميل دائم" },
  { id: 2, quote: "فريق عمل متعاون ومحترف، ساعدوني في اختيار السيارة المناسبة بميزانيتي بكل شفافية.", name: "فهد الشمري", role: "عميل جديد" },
  { id: 3, quote: "الأسعار منافسة جداً مقارنة بالسوق، والتقسيط كان مريح وبدون تعقيدات.", name: "سلطان الدوسري", role: "رجل أعمال" },
  { id: 4, quote: "خدمة ما بعد البيع رائعة، وهم دائماً جاهزين للمساعدة. شكراً لكم على هذا المستوى.", name: "عبدالله القحطاني", role: "مهندس" },
  { id: 5, quote: "اشتريت سيارتي الأولى من هنا وكانت تجربة لا تُنسى. السرعة في الإنجاز كانت مذهلة.", name: "أحمد الحربي", role: "موظف حكومي" },
  { id: 6, quote: "الفريق المتخصص فهم احتياجاتي بالضبط وقدّم لي عدة خيارات ممتازة.", name: "ناصر المطيري", role: "طبيب" },
  { id: 7, quote: "أفضل تجربة شراء سيارة مررت بها. الشفافية والثقة هي ما يميز قمة نجد عن غيرهم.", name: "خالد العتيبي", role: "مدير شركة" },
];

export default function TestimonialsSection({
  title,
  testimonials,
  autoPlay = true,
  interval = 5000,
}: ITestimonialsSectionProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);
  const isRTL = direction === "rtl";

  const resolvedTitle = title || t("aboutPage.testimonials.title");

  const [currentIndex, setCurrentIndex] = useState(0);
  const [isPaused, setIsPaused] = useState(false);

  const displayTestimonials =
    testimonials.length > 0 ? testimonials : MOCK_TESTIMONIALS;
  const totalItems = displayTestimonials.length;
  const activeTestimonial = displayTestimonials[currentIndex];

  const goToSlide = useCallback(
    (index: number) => {
      if (!totalItems) return;
      setCurrentIndex(((index % totalItems) + totalItems) % totalItems);
    },
    [totalItems],
  );

  const nextSlide = useCallback(() => {
    if (!totalItems) return;
    setCurrentIndex((previous) => (previous + 1) % totalItems);
  }, [totalItems]);

  const previousSlide = useCallback(() => {
    if (!totalItems) return;
    setCurrentIndex((previous) => (previous - 1 + totalItems) % totalItems);
  }, [totalItems]);

  useEffect(() => {
    if (!autoPlay || isPaused || totalItems <= 1) return;
    const intervalId = window.setInterval(nextSlide, interval);
    return () => { window.clearInterval(intervalId); };
  }, [autoPlay, interval, isPaused, nextSlide, totalItems]);

  if (!activeTestimonial) return null;

  const visiblePages = getVisiblePages(currentIndex, totalItems);

  return (
    <section
      dir={direction}
      className="w-full bg-[var(--brand-primary-color)] py-14 text-white sm:py-16 lg:py-20 mb-[140px]"
      onMouseEnter={() => setIsPaused(true)}
      onMouseLeave={() => setIsPaused(false)}
    >
      <div className="mx-auto max-w-[1120px] px-4 sm:px-6 lg:px-8">
        <h2 className="text-center text-[28px]  text-[var(--brand-secondary-color)] sm:text-[34px]">
          {resolvedTitle}
        </h2>

        <div className="mt-10 flex justify-center sm:mt-12">
          <article
            key={activeTestimonial.id}
            className={[
              "w-full max-w-[850px] rounded-[24px] bg-white",
              "px-6 py-8 text-[var(--brand-primary-color)]",
              "shadow-[0_18px_50px_rgba(0,0,0,0.16)]",
              "sm:px-10 sm:py-10 lg:px-14",
            ].join(" ")}
          >
            <blockquote className="text-start text-[23px] font-extrabold leading-[1.6] sm:text-[29px] lg:text-[29px]">
              {activeTestimonial.quote}
            </blockquote>

            <div className="mt-7 flex items-start justify-start gap-4">
              {activeTestimonial.avatar ? (
                <LazyImg
                  src={activeTestimonial.avatar}
                  alt={activeTestimonial.name}
                  className="h-[52px] w-[52px] shrink-0 rounded-full object-cover"
                />
              ) : (
                <div className="flex h-[52px] w-[52px] shrink-0 items-center justify-center rounded-full bg-[var(--brand-secondary-color)] text-lg font-extrabold text-[var(--brand-primary-color)]">
                  {activeTestimonial.name.trim().charAt(0)}
                </div>
              )}

              <div className="text-start">
                <h3 className="text-[16px] font-bold sm:text-[18px]">
                  {activeTestimonial.name}
                </h3>

                {activeTestimonial.role && (
                  <p className="mt-1 text-[12px] text-[#7C8794] sm:text-[13px]">
                    {activeTestimonial.role}
                  </p>
                )}
              </div>
            </div>
          </article>
        </div>

        {totalItems > 1 && (
          <div className="mt-9 flex flex-wrap items-center justify-center gap-4 sm:gap-6">
            <button
              type="button"
              onClick={nextSlide}
              aria-label={t("aboutPage.testimonials.goToTestimonial", { number: "next" })}
              className={[
                "flex h-[40px] w-[40px] items-center justify-center",
                "rounded-[13px] border border-white/45",
                "bg-transparent text-white/75",
                "transition hover:bg-white/10 hover:text-white",
              ].join(" ")}
            >
              {isRTL ? <ChevronRight size={21} /> : <ChevronLeft size={21} />}
            </button>

            <div dir="ltr" className="flex items-center gap-3">
              {visiblePages.map((page, idx) => {
                if (page === "ellipsis") {
                  return (
                    <span
                      key={`ellipsis-${idx}`}
                      className={[
                        "flex h-[40px] min-w-[40px] items-center justify-center",
                        "rounded-[13px] border border-white/30",
                        "px-3 text-[15px] font-bold text-white/65",
                      ].join(" ")}
                    >
                      ...
                    </span>
                  );
                }

                const pageIndex = page - 1;
                const isActive = pageIndex === currentIndex;

                return (
                  <button
                    key={page}
                    type="button"
                    onClick={() => goToSlide(pageIndex)}
                    aria-label={t("aboutPage.testimonials.goToTestimonial", { number: page })}
                    className={[
                      "flex h-[40px] min-w-[40px] items-center justify-center",
                      "rounded-[13px] border px-3",
                      "text-[15px] font-bold transition",
                      isActive
                        ? ["border-[var(--brand-secondary-color)]", "bg-[var(--brand-secondary-color)]", "text-white"].join(" ")
                        : ["border-white/35", "bg-transparent", "text-white/65", "hover:border-white/70", "hover:text-white"].join(" "),
                    ].join(" ")}
                  >
                    {page}
                  </button>
                );
              })}
            </div>

            <button
              type="button"
              onClick={previousSlide}
              aria-label={t("aboutPage.testimonials.goToTestimonial", { number: "prev" })}
              className={[
                "flex h-[40px] w-[40px] items-center justify-center",
                "rounded-[13px] border border-white/45",
                "bg-white/25 text-white",
                "backdrop-blur-md transition",
                "hover:bg-white/35",
              ].join(" ")}
            >
              {isRTL ? <ChevronLeft size={21} /> : <ChevronRight size={21} />}
            </button>
          </div>
        )}
      </div>
    </section>
  );
}

function getVisiblePages(
  currentIndex: number,
  totalItems: number,
): Array<number | "ellipsis"> {
  if (totalItems <= 5) {
    return Array.from({ length: totalItems }, (_, index) => index + 1);
  }

  const currentPage = currentIndex + 1;

  if (currentPage <= 3) {
    return [1, 2, 3, "ellipsis", totalItems];
  }

  if (currentPage >= totalItems - 2) {
    return [1, "ellipsis", totalItems - 2, totalItems - 1, totalItems];
  }

  return [1, "ellipsis", currentPage, "ellipsis", totalItems];
}
