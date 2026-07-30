import type { ReactNode } from "react";

interface IInfoBoxProps {
  icon: ReactNode;
  title: string;
  description: string;
}

export default function InfoBox({ icon, title, description }: IInfoBoxProps) {
  return (
    <div className="flex items-center gap-4 rounded-[14px] bg-white px-6 py-5 shadow-sm">
      <div className="text-[var(--brand-secondary-color)]">{icon}</div>
      <div>
        <h3 className="text-[16px] font-extrabold text-[#07111F]">{title}</h3>
        <p className="mt-1 text-[13px] text-[#8A8F99]">{description}</p>
      </div>
    </div>
  );
}
