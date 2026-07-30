import type { ReactNode } from "react";

export interface IWhyChooseUsCardProps {
  title: string;
  description: string;
  icon: ReactNode;
  variant?: "gold" | "primary";
}

export default function WhyChooseUsCard({
  title,
  description,
  icon,
  variant = "gold",
}: IWhyChooseUsCardProps) {
  const isGold = variant === "gold";

  return (
    <article
      className={[
        "group min-h-[205px] rounded-[16px]",
        "border border-[#E4E4DF] bg-white",
        "px-6 py-6 text-start",
        "shadow-[0_4px_14px_rgba(15,23,42,0.04)]",
        "transition duration-300",
        "hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(15,23,42,0.09)]",
      ].join(" ")}
    >
      <div className="flex justify-start">
        <div
          className={[
            "flex h-[48px] w-[48px] items-center justify-center",
            "rounded-[14px]",
            "transition duration-300 group-hover:scale-105",
            isGold
              ? "bg-gradient-to-br from-[#8D6E13] to-[var(--brand-secondary-color)] text-white"
              : "bg-[var(--brand-primary-color)] text-white",
          ].join(" ")}
        >
          {icon}
        </div>
      </div>

      <h3 className="mt-6 text-[18px] font-extrabold text-[var(--brand-primary-color)] sm:text-[19px]">
        {title}
      </h3>

      <p className="mt-3 text-[13px] leading-7 text-[#6F7680] sm:text-[14px]">
        {description}
      </p>
    </article>
  );
}
