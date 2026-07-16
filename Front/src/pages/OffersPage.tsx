import { useMemo } from "react";
import { useTranslation } from "react-i18next";
import { useInfiniteQuery } from "@tanstack/react-query";
import ContactCtaSection from "../components/ContactCtaSection";
import OffersGridSection from "../components/offers-page/OffersGridSection";
import OffersPageHero from "../components/offers-page/OffersPageHero";
import { getOffers } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { offerToCardProps } from "../utils/offers";
import { useSEO } from "../utils/useSEO";

export default function OffersPage() {
  const { t } = useTranslation();
  useSEO(t("nav.offers"), t("offersPage.hero.description"));
  const language = useLanguageStore((s) => s.language);

  const {
    data: offersResponse,
    fetchNextPage,
    hasNextPage,
    isFetchingNextPage,
  } = useInfiniteQuery({
    queryKey: ["offers", language],
    queryFn: ({ pageParam }) => getOffers(pageParam as number, 12),
    initialPageParam: 1,
    getNextPageParam: (lastPage) =>
      lastPage.meta.current_page < lastPage.meta.last_page
        ? lastPage.meta.current_page + 1
        : undefined,
  });

  const hero = offersResponse?.pages?.[0]?.meta.hero;

  const offers = useMemo(() => {
    if (!offersResponse?.pages) return [];
    return offersResponse.pages.flatMap((page) =>
      page.data.map((offer) => offerToCardProps(offer, t))
    );
  }, [offersResponse, t]);

  return (
    <>
      <OffersPageHero
        image={getImageUrl(hero?.image ?? null) || APP_IMAGES.OFFER_PLACEHOLDER}
        badgeText={hero?.badge || t("offersPage.hero.badge")}
        title={hero?.title || t("offersPage.hero.title")}
        description={hero?.subtitle || t("offersPage.hero.description")}
        primaryButtonText={t("offersPage.hero.primaryButton")}
        primaryButtonTo="/cars"
        secondaryButtonText={t("offersPage.hero.secondaryButton")}
        secondaryButtonTo="/finance-calculator"
      />

      <OffersGridSection
        title={t("offersPage.grid.title")}
        offers={offers}
        loadMoreText={
          isFetchingNextPage
            ? t("blogPage.latestArticles.loading")
            : t("offersPage.grid.loadMore")
        }
        hasMore={!!hasNextPage}
        onLoadMore={() => fetchNextPage()}
      />

      <ContactCtaSection
        badgeText={t("allCarsPage.contactBadge")}
        titleWhite={t("allCarsPage.contactTitleWhite")}
        titleOrange={t("allCarsPage.contactTitleOrange")}
        description={t("allCarsPage.contactDescription")}
        phoneText={t("allCarsPage.contactPhone")}
        phoneHref="tel:+966500000000"
        whatsappText={t("allCarsPage.contactWhatsapp")}
        
        sectionBgColor="var(--brand-CTA-BG-color)"
      />
    </>
  );
}
