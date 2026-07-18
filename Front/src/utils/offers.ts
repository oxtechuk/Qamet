import type { TFunction } from "i18next";
import type { OfferData } from "../types/offers.types";
import type { IOfferListCardProps } from "../interfaces/IOfferListCardProps";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";

export function offerToCardProps(
  offer: OfferData,
  t: TFunction
): IOfferListCardProps {
  const car = offer.car;
  const brandName = car?.brand?.name ?? "";
  const carFullName = brandName ? `${brandName} ${car.name}` : car?.name ?? "";

  return {
    id: offer.id,
    image: getImageUrl(offer.image) || getImageUrl(car?.main_image) || getImageUrl(car?.thumbnail) || APP_IMAGES.OFFER_PLACEHOLDER,
    badge: offer.discount_percent
      ? t("offersPage.grid.card.badgeDiscount", { percent: offer.discount_percent })
      : t("offersPage.grid.card.badgeSeasonal"),
    title: offer.title,
    description: offer.description,
    carName: carFullName || undefined,
    priceLabel: t("offersPage.grid.card.priceLabel"),
    price: offer.special_installment ?? offer.special_price ?? car?.current_price ?? 0,
    priceUnit: t("offersPage.grid.card.priceUnit"),
    expiresAt: offer.ends_at,
    isExpired: offer.is_expired,
    timeRemaining: offer.time_remaining,
    savings: car?.savings ?? 0,
    minInstallment: car?.min_installment ?? 0,
    buttonText: t("offersPage.grid.card.buttonText"),
    buttonTo: `/cars/${car?.slug ?? ""}`,
  };
}
