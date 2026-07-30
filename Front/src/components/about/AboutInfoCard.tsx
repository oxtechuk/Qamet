import type { IInfoCard } from "../../interfaces/IInfoCard";
import IconBox from "./IconBox";

export default function AboutInfoCard({ title, description, variant, icon }: IInfoCard) {
  const isDark = variant === "dark";

  return (
    <article
      className={`rounded-[18px] px-10 py-9 ${
        isDark ? "bg-[#111318] text-white" : "bg-white text-[#07111F]"
      }`}
    >
      <div className="mb-7 flex items-center gap-5">
        <IconBox icon={icon} />

        <h3
          className={`text-[28px] font-extrabold ${
            isDark ? "text-white" : "text-[#07111F]"
          }`}
        >
          {title}
        </h3>
      </div>

      <p
        className={`text-[17px] leading-9 ${
          isDark ? "text-white/75" : "text-[#4B5563]"
        }`}
      >
        {description}
      </p>
    </article>
  );
}
