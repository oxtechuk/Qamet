import type { IFooterTitleProps } from "../../interfaces/IFooterTitleProps";

export default function FooterTitle({ title, centered = false }: IFooterTitleProps) {
  return (
    <h3
      className={`flex items-center gap-3 text-[18px] font-bold text-white ${
        centered ? "justify-center" : "justify-start"
      }`}
    >
      <span>{title}</span>
      <span className="h-[24px] w-[3px] rounded-full bg-[var(--brand-secondary-color)]" />
    </h3>
  );
}
