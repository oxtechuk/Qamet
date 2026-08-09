import { useTranslation } from "react-i18next";
import { useLanguageStore } from "../../store/language.store";

interface IAboutIntroSectionProps {
  titleStart?: string;
  titleHighlight?: string;
  description?: string;
}

export default function AboutIntroSection({
  titleStart,
  titleHighlight,
  description,
}: IAboutIntroSectionProps) {
  const { t } = useTranslation();
  const direction = useLanguageStore((s) => s.direction);

  const resolvedTitleStart = titleStart || t("aboutPage.intro.titleStart");
  const resolvedTitleHighlight = titleHighlight || t("aboutPage.intro.titleHighlight");
  const resolvedDescription = description || t("aboutPage.intro.description");

  return (
    <section
      dir={direction}
      className="w-full bg-[#FAFAF8] py-14 sm:py-16"
    >
      <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-[620px] text-center">
          <h2 className="text-[30px] leading-tight text-[var(--brand-primary-color)] sm:text-[38px]">
            <span>{resolvedTitleStart}</span>{" "}
            <span className="text-[var(--brand-secondary-color)]">
              {resolvedTitleHighlight}
            </span>
          </h2>

          <p className="mx-auto mt-4 max-w-[560px] text-[14px] font-medium leading-7 text-[var(--brand-primary-color)] sm:text-[15px]">
            {resolvedDescription}
          </p>
        </div>
      </div>
    </section>
  );
}
