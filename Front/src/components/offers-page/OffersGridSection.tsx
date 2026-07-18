import { useTranslation } from "react-i18next";
import { ArrowDown } from "lucide-react";
import OfferListCard from "./OfferListCard";
import type { IOffersGridSectionProps } from "../../interfaces/IOffersGridSectionProps";

export default function OffersGridSection({
  offers,
  loadMoreText,
  hasMore,
  onLoadMore,
}: IOffersGridSectionProps) {
  const { i18n, t } = useTranslation();


  return (
    <section dir={i18n.dir()} className="w-full py-1">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Offers Grid */}
        <div className="grid grid-cols-1 gap-x-10 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
          {offers.map((offer) => (
            <OfferListCard key={offer.id} {...offer} />
          ))}
        </div>

        {/* Load More */}
        {hasMore && (
          <div className="mt-12 flex justify-center">
            <button
              type="button"
              onClick={onLoadMore}
              className="inline-flex h-[42px] items-center justify-center gap-2 rounded-full bg-white px-6 text-[15px] font-bold text-[#07111F] transition hover:bg-[var(--brand-secondary-color)] hover:text-white"
            >
              {loadMoreText || t("offersPage.grid.loadMore")}
              <ArrowDown size={17} />
            </button>
          </div>
        )}
      </div>
    </section>
  );
}
