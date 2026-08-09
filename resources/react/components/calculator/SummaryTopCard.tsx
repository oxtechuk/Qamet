import type { ReactNode } from "react";

interface ISummaryTopCardProps {
  title: string;
  value: string | ReactNode;
  variant: "blue" | "orange";
}

export default function SummaryTopCard({ title, value, variant }: ISummaryTopCardProps) {
  const isBlue = variant === "blue";

  return (
    <div
      className={`rounded-[12px] p-6 ${
        isBlue ? "bg-[var(--brand-primary-color)]" : "bg-[#FFF0EB]"
      }`}
    >
      <p className={`text-[14px] ${isBlue ? "text-white/80" : "text-[#E65B2A]"}`}>
        {title}
      </p>
      <strong
        className={`mt-3 block text-[28px] font-extrabold ${
          isBlue ? "text-white" : "text-[var(--brand-secondary-color)]"
        }`}
      >
        {value}
      </strong>
    </div>
  );
}
