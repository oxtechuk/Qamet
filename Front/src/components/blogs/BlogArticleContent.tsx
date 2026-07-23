import { useTranslation } from "react-i18next";
import type { IBlogArticleContentProps } from "../../interfaces/IBlogArticleContentProps";

export default function BlogArticleContent({
  html,
}: IBlogArticleContentProps) {
  const { i18n } = useTranslation();
  return (
    <section dir={i18n.dir()} className="w-full py-8">
      <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div
          className="prose prose-lg max-w-none text-[17px] leading-9 text-[#111827] [&_h1]:mb-4 [&_h1]:text-[28px] [&_h1]:font-extrabold [&_h2]:mb-4 [&_h2]:text-[22px] [&_h2]:font-extrabold [&_h3]:mb-3 [&_h3]:text-[19px] [&_h3]:font-bold [&_img]:my-6 [&_img]:rounded-[12px] [&_img]:object-cover [&_li]:ml-5 [&_li]:list-disc [&_ol]:my-4 [&_ol]:list-decimal [&_p]:mb-4 [&_p]:leading-relaxed [&_strong]:font-bold [&_ul]:my-4 [&_ul]:list-disc"
          dangerouslySetInnerHTML={{ __html: html }}
        />
      </div>
    </section>
  );
}
