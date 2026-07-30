import { useTranslation } from "react-i18next";
import { CalendarDays, Clock } from "lucide-react";
import type { IBlogDetailsHeroProps } from "../../interfaces/IBlogDetailsHeroProps";
import LazyImg from "../LazyImg";

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
        <section dir={i18n.dir()} className="w-full pt-12 pb-8">
            <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div className="mx-auto max-w-3xl text-start">
                    <span
                        className="
    inline-flex
    min-h-[44px]
    items-center
    rounded-full
    bg-[var(--brand-secondary-color)]
    px-7
    text-[18px]
    text-[var(--brand-primary-color)]
    whitespace-nowrap
  "
                    >
                        {category}
                    </span>

                    <h1 className="mt-5 text-[30px] font-bold leading-[1.6] text-[#07111F] md:text-[42px]">
                        {title}
                    </h1>

                    <div className="mt-7 flex flex-wrap items-center justify-start gap-5 text-[13px] text-[#8A8F99]">
                        <div className="flex items-center justify-end gap-4">
                            <LazyImg
                                src={authorImage}
                                alt={authorName}
                                className="
      h-[40px]
      w-[40px]
      rounded-full
      object-cover
      ring-2
      ring-[#DCCEFF]
      shrink-0
    "
                            />

                            <div className="flex items-center gap-2 text-right">
                                <h4 className="text-[17px] font-extrabold text-[var(--brand-primary-color)] sm:text-[18px]">
                                    {authorName}
                                </h4>

                                <span className="text-[#9CA3AF]">·</span>

                                <p className="text-[17px] font-medium text-[var(--brand-primary-color)]/90 sm:text-[18px]">
                                    {authorRole}
                                </p>
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
            </div>
        </section>
    );
}
