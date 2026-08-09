import { ChevronDown } from "lucide-react";
import type { IFaqAccordionProps } from "../../interfaces/IFaqAccordionProps";

export default function FaqAccordion({ faq, isOpen, onToggle }: IFaqAccordionProps) {
  return (
    <div
      className={`overflow-hidden rounded-[14px] border bg-white transition ${
        isOpen
          ? "border-[var(--brand-secondary-color)]/35"
          : "border-[var(--brand-secondary-color)]/25"
      }`}
    >
      <button
        type="button"
        onClick={() => onToggle(faq.id)}
        className="flex w-full items-center justify-between gap-5 px-7 py-7 text-end"
      >
        <span className="text-[16px] leading-8 text-[#07111F] font-bold">
          {faq.question}
        </span>

        <span
          className={`flex h-[32px] w-[32px] shrink-0 items-center justify-center rounded-full transition ${
            isOpen
              ? "bg-[var(--brand-secondary-color)] text-white"
              : "bg-[#EEF0F2] text-[#6B7280]"
          }`}
        >
          <ChevronDown
            size={18}
            className={`transition-transform duration-200 ${isOpen ? "rotate-180" : ""}`}
          />
        </span>
      </button>

      {isOpen && (
        <div className="px-7 pb-7">
          <div className="mb-5 h-px w-full bg-[#E5E7EB]" />
          <div
            className="text-[16px] leading-9 text-[#5F6672] [&_p]:m-0 [&_p]:mb-2 last:[&_p]:mb-0"
            dangerouslySetInnerHTML={{ __html: faq.answer }}
          />
        </div>
      )}
    </div>
  );
}
