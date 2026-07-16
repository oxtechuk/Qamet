import type { OfferData } from "../types/offers.types";
import type { IOfferListCardProps } from "../interfaces/IOfferListCardProps";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";

export function offerToCardProps(
  offer: OfferData,
  t: (key: string) => string
): IOfferListCardProps {
  return {
    id: offer.id,
    image: getImageUrl(offer.image) || APP_IMAGES.OFFER_PLACEHOLDER,
    title: offer.title,
    description: offer.description,
    priceLabel: t("offersPage.grid.card.priceLabel"),
    price: offer.special_installment ?? offer.special_price ?? 0,
    priceUnit: t("offersPage.grid.card.priceUnit"),
    buttonText: t("offersPage.grid.card.buttonText"),
    buttonTo: `/cars?offerId=${offer.id}`,
  };
}
