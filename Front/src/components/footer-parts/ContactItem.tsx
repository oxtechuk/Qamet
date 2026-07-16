import type { IContactItemProps } from "../../interfaces/IContactItemProps";

export default function ContactItem({ label, value, icon }: IContactItemProps) {
  return (
    <div className="flex w-full flex-col items-center gap-2 text-center lg:flex-row lg:justify-center lg:text-start">
      <div className="flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-[10px] border border-[var(--brand-secondary-color)]/45 bg-[var(--brand-secondary-color)]/10 text-[var(--brand-secondary-color)]">
        {icon}
      </div>

      <div className="min-w-0 flex-1">
        <p className="text-[12px] text-white/55">{label}</p>
        <p className="text-[14px] leading-7 text-white/90">{value}</p>
      </div>
    </div>
  );
}
