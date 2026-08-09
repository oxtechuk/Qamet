import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../../store/language.store";
import WhyChooseUsCard, { type IWhyChooseUsCardProps } from "./WhyChooseUsCard";
import { resolveHeroicon } from "../../utils/heroicon-map";

interface IWhyChooseUsSectionProps {
  titleStart?: string;
  titleHighlight?: string;
  description?: string;
  items?: { icon: string; title: string; description: string | null }[];
}

export default function WhyChooseUsSection({
  titleStart,
  titleHighlight,
  description,
  items,
}: IWhyChooseUsSectionProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);

  const resolvedTitleStart = titleStart || t("aboutPage.whyChooseUs.title");
  const resolvedTitleHighlight = titleHighlight || t("aboutPage.whyChooseUs.title1");
  const resolvedDescription = description || t("aboutPage.whyChooseUs.description");

  const fallbackItems: IWhyChooseUsCardProps[] = [
    { title: "أسعار شفافة", description: "لا رسوم خفية ولا مفاجآت، ما تراه هو ما تدفعه مع شفافية كاملة في كل خطوة.", icon: null, variant: "gold" },
    { title: "توصيل مجاني", description: "نوصل سيارتك لأي مكان في المملكة مجانًا خلال 24–48 ساعة من إتمام الصفقة.", icon: null, variant: "gold" },
    { title: "فريق متخصص", description: "مستشارون متخصصون بخبرة لا تقل عن 10 سنوات في قطاع السيارات الفاخرة.", icon: null, variant: "gold" },
    { title: "ضمان الجودة", description: "فحص شامل من 150 نقطة لكل سيارة قبل العرض، مع ضمان مكتوب على كل سيارة مستعملة.", icon: null, variant: "primary" },
    { title: "تمويل ميسر", description: "تمويل فوري من كبرى البنوك بأقل دفعة أولى وأطول فترة سداد حتى 7 سنوات.", icon: null, variant: "primary" },
    { title: "إجراءات سريعة", description: "تتم إجراءات شراء سيارتك في غضون ساعات لا أيام مع فريقنا المتخصص.", icon: null, variant: "primary" },
  ];

  const resolvedItems: IWhyChooseUsCardProps[] =
    items && items.length
      ? items.map((item, index) => ({
          title: item.title,
          description: item.description || fallbackItems[index]?.description || "",
          icon: (() => { const Icon = resolveHeroicon(item.icon); return <Icon size={25} strokeWidth={1.8} />; })(),
          variant: (index < 3 ? "gold" : "primary") as "gold" | "primary",
        }))
      : fallbackItems;

  return (
    <section
      dir={direction}
      className="w-full bg-[#FAFAF8] py-14 sm:py-16 lg:py-20"
    >
      <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-[620px] text-center">
          <h2 className="text-[30px] leading-tight text-[var(--brand-primary-color)] sm:text-[38px]">
            <span>{resolvedTitleStart}</span>{" "}
            <span className="text-[var(--brand-secondary-color)]">
              {resolvedTitleHighlight}
            </span>
          </h2>

          <p className="mx-auto mt-4 max-w-[530px] text-[14px] leading-7 text-[#727985] sm:text-[15px]">
            {resolvedDescription}
          </p>
        </div>

        <div className="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:mt-14 lg:grid-cols-3 lg:gap-6">
          {resolvedItems.map((item, index) => (
            <WhyChooseUsCard
              key={`${item.title}-${index}`}
              {...item}
            />
          ))}
        </div>
      </div>
    </section>
  );
}
