import { ChevronLeft, ChevronRight } from "lucide-react";
import { useTranslation } from "react-i18next";
import OfferListCard from "./OfferListCard";
import type { IOffersGridSectionProps } from "../../interfaces/IOffersGridSectionProps";

function PaginationButton({
  children,
  active,
  disabled,
  onClick,
}: {
  children: React.ReactNode;
  active?: boolean;
  disabled?: boolean;
  onClick?: () => void;
}) {
  return (
    <button
      type="button"
      onClick={onClick}
      disabled={disabled}
      className={[
        "flex h-[46px] w-[46px] items-center justify-center rounded-[12px] border text-[15px] font-semibold transition",
        active
          ? "border-[var(--brand-primary-color)] bg-[var(--brand-primary-color)] text-white"
          : disabled
          ? "border-[#E5E7EB] bg-white text-[#D1D5DB] cursor-default"
          : "border-[#E5E7EB] bg-white text-[#374151] hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)]",
      ].join(" ")}
    >
      {children}
    </button>
  );
}

function buildPages(current: number, total: number): (number | "...")[] {
  if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
  const pages: (number | "...")[] = [1];
  if (current > 3) pages.push("...");
  for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
    pages.push(i);
  }
  if (current < total - 2) pages.push("...");
  pages.push(total);
  return pages;
}

export default function OffersGridSection({
  offers,
  currentPage = 1,
  totalPages = 1,
  onPageChange,
}: IOffersGridSectionProps) {
  const { i18n } = useTranslation();
  const pages = buildPages(currentPage, totalPages);

  return (
    <section dir={i18n.dir()} className="w-full py-10">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Grid */}
        <div className="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-2 lg:grid-cols-3">
          {offers.map((offer) => (
            <OfferListCard key={offer.id} {...offer}  />
          ))}
        </div>

        {/* Pagination */}
        {totalPages > 1 && (
          <div dir="ltr" className="mt-12 flex items-center justify-center gap-2">
            <PaginationButton
              disabled={currentPage === 1}
              onClick={() => onPageChange?.(currentPage - 1)}
            >
              <ChevronLeft size={18} />
            </PaginationButton>

            {pages.map((page, i) =>
              page === "..." ? (
                <PaginationButton key={`dots-${i}`} disabled>···</PaginationButton>
              ) : (
                <PaginationButton
                  key={page}
                  active={page === currentPage}
                  onClick={() => onPageChange?.(page as number)}
                >
                  {page}
                </PaginationButton>
              )
            )}

            <PaginationButton
              disabled={currentPage === totalPages}
              onClick={() => onPageChange?.(currentPage + 1)}
            >
              <ChevronRight size={18} />
            </PaginationButton>
          </div>
        )}
      </div>
    </section>
  );
}
