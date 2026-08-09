import type { TFunction } from "i18next";
import type { OfferData } from "../types/offers.types";
import type { IOfferListCardProps } from "../interfaces/IOfferListCardProps";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";

function resolveOfferHighlight(
  value: OfferData["car"]["highlight"],
  locale: string,
): { text: string; color?: string } | undefined {
  if (!value) return undefined;
  if (typeof value === "string") return value ? { text: value } : undefined;
  const key = locale.startsWith("ar") ? "text_ar" : "text";
  const text = (value[key] ?? value.text_ar ?? value.text ?? "") as string;
  if (!text) return undefined;
  return { text, color: value.color };
}

export function offerToCardProps(
  offer: OfferData,
  t: TFunction,
  locale: string,
): IOfferListCardProps {
  const car = offer.car;
  const brandName = car?.brand?.name ?? "";
  const carFullName = brandName ? `${brandName} ${car.name}` : car?.name ?? "";

  const highlight = resolveOfferHighlight(car?.highlight ?? null, locale);

  return {
    id: offer.id,
    image: getImageUrl(offer.image) || getImageUrl(car?.main_image) || getImageUrl(car?.thumbnail) || APP_IMAGES.OFFER_PLACEHOLDER,
    badge: highlight?.text || (offer.discount_percent
      ? t("offersPage.grid.card.badgeDiscount", { percent: offer.discount_percent })
      : t("offersPage.grid.card.badgeSeasonal")),
    badgeColor: highlight?.color,
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
    buttonTo: `/cars?offerId=${offer.id}`,
  };
}

const future = (days: number) =>
  new Date(Date.now() + days * 24 * 60 * 60 * 1000).toISOString();

export const STATIC_DEMO_OFFERS: IOfferListCardProps[] = [
  {
    id: "d1",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "عرض موسمي",
    title: "خصم ١٠٪ على السيارات المستعملة",
    description: "عروض الصيف على تشكيلة واسعة من أفضل السيارات",
    carName: "مرسيدس GLE 450 2024",
    priceLabel: "خصم يصل إلى",
    price: 42000,
    expiresAt: future(32),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d2",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "تمويل مجاني",
    title: "تمويل بدون دفعة أولى",
    description: "على مجموعة مختارة من السيارات الجديدة لعام 2024",
    carName: "تويوتا لاند كروزر 2024",
    priceLabel: "خصم يصل إلى",
    price: 65000,
    expiresAt: future(17),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d3",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "عرض محدود",
    title: "أقساط شهرية تبدأ من ١٥٠٠ ريال",
    description: "عروض حصرية على السيارات الكهربائية والهجينة",
    carName: "هيونداي أيونيك 6 2024",
    priceLabel: "خصم يصل إلى",
    price: 28000,
    expiresAt: future(10),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d4",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "عرض خاص",
    title: "صفقة نهاية الشهر على الـ SUV",
    description: "وفر أكثر مع عروض نهاية الشهر على أفضل سيارات الـ SUV",
    carName: "كيا سبورتاج 2024",
    priceLabel: "خصم يصل إلى",
    price: 18000,
    expiresAt: future(5),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d5",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "الأفضل قيمة",
    title: "السيدان الاقتصادية بسعر لا يُصدق",
    description: "احصل على سيارة عائلية مريحة بأقل الأسعار في السوق",
    carName: "تويوتا كامري 2024",
    priceLabel: "خصم يصل إلى",
    price: 15000,
    expiresAt: future(20),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d6",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "تمويل ميسر",
    title: "صفر فوائد لمدة ١٢ شهراً",
    description: "أمتلك سيارتك الآن بدون أي فوائد بنكية للسنة الأولى",
    carName: "نيسان باترول 2024",
    priceLabel: "خصم يصل إلى",
    price: 55000,
    expiresAt: future(45),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d7",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "عرض موسمي",
    title: "خصم ١٥٪ على الفئة الفاخرة",
    description: "استمتع بتجربة قيادة فاخرة بأسعار استثنائية هذا الموسم",
    carName: "BMW 740i 2024",
    priceLabel: "خصم يصل إلى",
    price: 95000,
    expiresAt: future(14),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d8",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "حصري",
    title: "الجيب الأقوى بعرض حصري",
    description: "لا تفوّت فرصة امتلاك أقوى الجيبات بسعر منافس",
    carName: "مرسيدس G63 AMG 2024",
    priceLabel: "خصم يصل إلى",
    price: 120000,
    expiresAt: future(7),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
  {
    id: "d9",
    image: APP_IMAGES.CAR_PLACEHOLDER,
    badge: "عرض خاص",
    title: "السيارة العائلية المثالية",
    description: "مساحة واسعة وأمان عالي لعائلتك بسعر يناسب ميزانيتك",
    carName: "تويوتا هايلاندر 2024",
    priceLabel: "خصم يصل إلى",
    price: 35000,
    expiresAt: future(25),
    buttonText: "التفاصيل",
    buttonTo: "/cars",
  },
];

