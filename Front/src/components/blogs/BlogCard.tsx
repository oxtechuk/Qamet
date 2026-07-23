import { Clock } from "lucide-react";
import { NavLink } from "react-router-dom";
import type { IBlogCardProps } from "../../interfaces/IBlogCardProps";
import { useLanguageStore } from "../../store/language.store";
import LazyImg from "../LazyImg";

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
  const direction = useLanguageStore((s) => s.direction);

  return (
    <NavLink
      to={readMoreTo}
      className="block w-full overflow-hidden rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md"
    >
      {/* Image */}
      <div className="relative h-[220px] w-full overflow-hidden">
        <LazyImg
          src={image}
          alt={title}
          className="h-full w-full object-cover transition duration-500 hover:scale-[1.03]"
        />
        {/* Category badge — top start */}
        {category && (
          <div className="absolute start-3 top-3 rounded-full bg-[var(--brand-secondary-color)] px-4 py-1.5 text-[12px] font-semibold text-[var(--brand-primary-color)]">
            {category}
          </div>
        )}
      </div>

      {/* Body */}
      <div className="px-4 pb-5 pt-4" dir={direction}>
        {/* Meta row */}
        <div className="flex items-center justify-start gap-3 text-[12px] text-[#9CA3AF]">
          <span>{date}</span>
          <span className="h-1 w-1 rounded-full bg-[#D1D5DB]" />
          <span className="flex items-center gap-1">
            <Clock size={12} />
            {readTime}
          </span>
        </div>

        {/* Title */}
        <h3 className="mt-2 text-[18px] font-extrabold leading-snug text-[#111827] line-clamp-1">
          {title}
        </h3>

        {/* Description */}
        <p className="mt-2 text-[13px] leading-7 text-[#6B7280] line-clamp-2">
          {description}
        </p>

        {/* Author */}
        <div className="mt-4 flex items-center justify-start gap-3 border-t border-[#F3F4F6] pt-4">
            <LazyImg
            src={authorImage}
            alt={authorName}
            className="h-[40px] w-[40px] rounded-full object-cover"
          />
          <div className="text-end">
            <p className="text-[13px] font-bold text-[#111827]">{authorName}</p>
            <p className="text-[12px] text-[#9CA3AF]">{authorRole}</p>
          </div>
        
        </div>
      </div>
    </NavLink>
  );
}
