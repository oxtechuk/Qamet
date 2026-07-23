import { useTranslation } from "react-i18next";
import { ArrowLeft } from "lucide-react";
import { NavLink } from "react-router-dom";
import type { IBlogFeaturedCardProps } from "../../interfaces/IBlogFeaturedCardProps";
import LazyImg from "../LazyImg";

export default function BlogFeaturedCard({
  image,
  category,
  date,
  title,
  description,
  authorName,
  authorRole,
  authorImage,
  readMoreTo,
}: IBlogFeaturedCardProps) {
  const { t, i18n } = useTranslation();
  return (
    <article
      dir={i18n.dir()}
      className="mx-auto flex max-w-5xl flex-col overflow-hidden rounded-[18px] bg-white md:flex-row"
    >
      <div className="relative min-h-[280px] md:w-1/2">
        <LazyImg src={image} alt={title} className="absolute inset-0 h-full w-full object-cover" />
      </div>

      <div className="flex flex-1 flex-col justify-center px-7 py-8 md:px-10">
        <div className="mb-5 flex items-center gap-3 text-[13px]">
          <span className="font-bold text-[var(--brand-secondary-color)]">
            {category}
          </span>
          <span className="h-1.5 w-1.5 rounded-full bg-[#CBD5E1]" />
          <span className="text-[#8A8F99]">{date}</span>
        </div>

        <h2 className="text-[26px] font-extrabold leading-[1.5] text-[#07111F] md:text-[32px]">
          {title}
        </h2>

        <p className="mt-5 text-[16px] leading-8 text-[#6B7280]">
          {description}
        </p>

        <div className="mt-8 flex items-center justify-between gap-5">
          <div className="flex items-center gap-3">
            <LazyImg
              src={authorImage}
              alt={authorName}
              className="h-[48px] w-[48px] rounded-full object-cover"
            />

            <div>
              <p className="text-[15px] font-bold text-[#07111F]">
                {authorName}
              </p>
              <p className="mt-1 text-[13px] text-[#6B7280]">{authorRole}</p>
            </div>
          </div>

          <NavLink
            to={readMoreTo}
            className="inline-flex items-center gap-2 text-[16px] font-bold text-[#07111F] transition hover:text-[var(--brand-primary-color)]"
          >
            {t("blogPage.readMore")}
            <ArrowLeft size={18} />
          </NavLink>
        </div>
      </div>
    </article>
  );
}
