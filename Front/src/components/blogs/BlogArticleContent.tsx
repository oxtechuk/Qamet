import { useTranslation } from "react-i18next";
import type { IBlogArticleContentProps } from "../../interfaces/IBlogArticleContentProps";

export default function BlogArticleContent({
  sections,
}: IBlogArticleContentProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full bg-[#F0F2F5] py-8">
      <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div className="space-y-8">
          {sections.map((section, index) => (
            <article
              key={index}
              className="rounded-[16px] border border-[#D9DEE7] bg-white px-6 py-7 shadow-sm md:px-10"
            >
              {section.title && (
                <h2
                  className={`mb-5 text-[20px] font-extrabold leading-8 ${
                    section.highlight
                      ? "text-[var(--brand-secondary-color)]"
                      : "text-[#07111F]"
                  }`}
                >
                  {section.title}
                </h2>
              )}

              <div className="space-y-4 text-[17px] leading-9 text-[#111827]">
                {section.paragraphs.map((paragraph, paragraphIndex) => (
                  <p key={paragraphIndex}>{paragraph}</p>
                ))}

                {section.list && (
                  <ul className="space-y-3 pr-5">
                    {section.list.map((item, itemIndex) => (
                      <li key={itemIndex} className="list-disc">
                        {item}
                      </li>
                    ))}
                  </ul>
                )}
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
