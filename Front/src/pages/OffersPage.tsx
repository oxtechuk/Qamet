import { useMemo, useState } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
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
  useSEO(t("pageTitles.offers"), t("offersPage.hero.description"));
  const language = useLanguageStore((s) => s.language);
  const [page, setPage] = useState(1);

  const { data: offersResponse } = useQuery({
    queryKey: ["offers", language, page],
    queryFn: () => getOffers(page, 12),
  });

  const hero = offersResponse?.meta.hero;
  const heroOffer = offersResponse?.meta.hero_offer;

  const offers = useMemo(() => {
    if (!offersResponse?.data) return [];
    return offersResponse.data.map((offer) => offerToCardProps(offer, t));
  }, [offersResponse, t]);

  const currentPage = offersResponse?.meta.current_page ?? page;
  const totalPages = offersResponse?.meta.last_page ?? 1;

  const heroCarLabel = heroOffer?.car
    ? heroOffer.car.brand
      ? `${heroOffer.car.brand} ${heroOffer.car.name}`
      : heroOffer.car.name
    : undefined;

  return (
    <>
      <OffersPageHero
        image={
          getImageUrl(heroOffer?.image ?? null) ||
          getImageUrl(hero?.image ?? null) ||
          APP_IMAGES.OFFER_PLACEHOLDER
        }
        badgeText={heroOffer?.discount_percent ? `${heroOffer.discount_percent}% ${t("offersPage.hero.badge")}` : hero?.badge || t("offersPage.hero.badge")}
        title={heroOffer?.title || hero?.title || t("offersPage.hero.title")}
        description={heroOffer?.description ? heroOffer.description.replace(/<[^>]+>/g, "") : hero?.subtitle || t("offersPage.hero.description")}
        carLabel={heroCarLabel}
        endsAt={heroOffer?.ends_at}
        discountPercent={heroOffer?.discount_percent}
        specialPrice={heroOffer?.special_price}
        primaryButtonText={t("offersPage.hero.primaryButton")}
        primaryButtonTo={heroOffer?.car?.slug ? `/cars/${heroOffer.car.slug}` : "/cars"}
      />

      <OffersGridSection
        offers={offers}
        currentPage={currentPage}
        totalPages={totalPages}
        onPageChange={setPage}
      />

      <ContactCtaSection
        badgeText={t("contactCta.badge")}
        titleWhite={t("contactCta.title")}
        titleOrange=""
        description={t("contactCta.description")}
        phoneText={t("contactCta.phoneText")}
        phoneHref="tel:+966500000000"
        whatsappText={t("allCarsPage.contactWhatsapp")}
      />
    </>
  );
}
