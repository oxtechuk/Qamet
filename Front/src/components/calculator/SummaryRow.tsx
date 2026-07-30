import type { ReactNode } from "react";

interface ISummaryRowProps {
  label: string;
  value: string | ReactNode;
}

export default function SummaryRow({ label, value }: ISummaryRowProps) {
  return (
    <div className="flex items-center justify-between border-b border-[#E5E7EB] py-3 last:border-b-0">
      <span className="text-[14px] text-[#5F6672]">{label}</span>
      <strong className="text-[14px] text-[#07111F]">{value}</strong>
    </div>
  );
}
