import { useNavigate, NavLink } from "react-router-dom";
import Badge from "./Badge";
import LazyImg from "./LazyImg";
import type { IHeroCardProps } from "../interfaces/IHeroCardProps";

export default function HeroCard({
  image,
  title,
  description,
  buttonText,
  buttonTo,
  badge,
}: IHeroCardProps) {
  const navigate = useNavigate();

  return (
    <div
      onClick={() => navigate(buttonTo)}
      className="relative cursor-pointer bg-white rounded-[8px] border border-[#D9E1EA] p-[7px] shadow-sm overflow-hidden"
    >
      {badge && (
        <Badge size="sm" className="top-0 right-0 rotate-12">
          {badge}
        </Badge>
      )}

      <LazyImg
        src={image}
        alt={title}
          className="w-full h-[165px] object-cover rounded-[6px]"
        />

      <div className="px-2 pt-[18px] pb-[1px] text-center">
        <h3 className="text-[#111111] text-[19px] leading-[1.4] font-bold">
          {title}
        </h3>

        <p className="text-[#9A9A9A] text-[13px] mt-[10px] leading-[1.5]">
          {description}
        </p>

        <NavLink
          to={buttonTo}
          onClick={(e: React.MouseEvent) => e.stopPropagation()}
          className="mt-[18px] w-full h-[52px] bg-[var(--brand-primary-color)] text-white! rounded-[8px] flex items-center justify-center text-[18px] font-medium hover:opacity-90 transition"
        >
          {buttonText}
        </NavLink>
      </div>
    </div>
  );
}
