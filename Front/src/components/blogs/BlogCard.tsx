import { useTranslation } from "react-i18next";
import { ArrowLeft } from "lucide-react";
import { NavLink } from "react-router-dom";
import type { IBlogCardProps } from "../../interfaces/IBlogCardProps";

export default function BlogCard({
  image,
  category,
  date,
  readTime,
  title,
  description,
  authorName,
  authorRole,
  authorImage,
  readMoreTo,
}: IBlogCardProps) {
  const { t, i18n } = useTranslation();
  return (
    <article dir={i18n.dir()} className="w-full">
      <div className="overflow-hidden rounded-t-[10px]">
        <img
          src={image}
          alt={title}
          className="h-[190px] w-full object-cover"
          loading="lazy"
        />
      </div>

      <div className="pt-4">
        <div className="mb-3 flex items-center gap-2 text-[12px]">
          <span className="font-bold text-[var(--brand-secondary-color)]">
            {category}
          </span>

          <span className="h-1 w-1 rounded-full bg-[#CBD5E1]" />

          <span className="text-[#8A8F99]">{date}</span>

          <span className="h-1 w-1 rounded-full bg-[#CBD5E1]" />

          <span className="text-[#8A8F99]">{readTime}</span>
        </div>

        <h3 className="text-[21px] font-extrabold leading-[1.55] text-[#07111F]">
          {title}
        </h3>

        <p className="mt-3 text-[14px] leading-7 text-[#6B7280]">
          {description}
        </p>

        <div className="mt-5 flex items-center justify-between gap-4">
          <div className="flex items-center gap-3">
            <img
              src={authorImage}
              alt={authorName}
              className="h-[42px] w-[42px] rounded-full object-cover"
              loading="lazy"
            />

            <div>
              <p className="text-[13px] font-bold text-[#07111F]">
                {authorName}
              </p>
              <p className="mt-1 text-[12px] text-[#6B7280]">{authorRole}</p>
            </div>
          </div>

          <NavLink
            to={readMoreTo}
            className="inline-flex h-[36px] items-center justify-center gap-2 rounded-full bg-white px-4 text-[13px] font-bold text-[#07111F] transition hover:bg-[var(--brand-primary-color)] hover:text-white!"
          >
            {t("blogPage.readMore")}
            <ArrowLeft size={15} />
          </NavLink>
        </div>
      </div>
    </article>
  );
}
