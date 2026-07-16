import { useTranslation } from "react-i18next";
import { CalendarDays, Clock } from "lucide-react";
import type { IBlogDetailsHeroProps } from "../../interfaces/IBlogDetailsHeroProps";

export default function BlogDetailsHero({
  category,
  title,
  authorName,
  authorRole,
  authorImage,
  date,
  readTime,
  image,
}: IBlogDetailsHeroProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] pt-12 pb-8">
      <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-3xl text-start">
          <span className="inline-flex rounded-full bg-[#FFF0EB] px-4 py-2 text-[13px] font-bold text-[var(--brand-secondary-color)]">
            {category}
          </span>

          <h1 className="mt-5 text-[30px] font-extrabold leading-[1.6] text-[#07111F] md:text-[42px]">
            {title}
          </h1>

          <div className="mt-7 flex flex-wrap items-center justify-start gap-5 text-[13px] text-[#8A8F99]">
            <div className="flex items-center gap-3">
              <img
                src={authorImage}
                alt={authorName}
                className="h-[48px] w-[48px] rounded-full object-cover"
                loading="lazy"
              />

              <div className="text-start">
                <p className="font-bold text-[#07111F]">{authorName}</p>
                <p className="mt-1">{authorRole}</p>
              </div>
            </div>

            <span className="hidden h-1.5 w-1.5 rounded-full bg-[#CBD5E1] sm:block" />

            <div className="flex items-center gap-2">
              <CalendarDays size={15} />
              <span>{date}</span>
            </div>

            <span className="hidden h-1.5 w-1.5 rounded-full bg-[#CBD5E1] sm:block" />

            <div className="flex items-center gap-2">
              <Clock size={15} />
              <span>{readTime}</span>
            </div>
          </div>
        </div>

        <div className="mt-12 overflow-hidden rounded-[18px]">
          <img
            src={image}
            alt={title}
            className="h-[320px] w-full object-cover md:h-[560px]"
            loading="lazy"
          />
        </div>
      </div>
    </section>
  );
}
