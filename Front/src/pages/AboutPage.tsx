import { useMemo } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { useLanguageStore } from "../store/language.store";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { useSEO } from "../utils/useSEO";
import { getAboutPageData } from "../services/api";
import type { IAboutData } from "../interfaces/IAboutData";
import type { ITestimonialItem } from "../interfaces/ITestimonialItem";
import type { IShowroomGalleryItem } from "../components/about/ShowroomGallerySection";
import CoreValuesSection from "../components/about/CoreValuesSection";
import AboutIntroSection from "../components/about/AboutIntroSection";
import WhyChooseUsSection from "../components/about/WhyChooseUsSection";
import ShowroomGallerySection from "../components/about/ShowroomGallerySection";
import TestimonialsSection from "../components/about/TestimonialsSection";

const FALLBACK_GALLERY_ITEMS: IShowroomGalleryItem[] = [
  { id: 1, src: APP_IMAGES.GALLERY_G1, alt: "سيارة داخل المعرض", type: "video", poster: APP_IMAGES.GALLERY_G1 },
  { id: 2, src: APP_IMAGES.GALLERY_G2, alt: "سيارات داخل معرض قمة نجد", type: "image" },
  { id: 3, src: APP_IMAGES.GALLERY_G3, alt: "سيارة تويوتا داخل المعرض", type: "image" },
  { id: 4, src: APP_IMAGES.GALLERY_G4, alt: "سيارة كيا داخل المعرض", type: "image" },
];

export default function AboutPage() {
  const { t } = useTranslation();
  const language = useLanguageStore((s) => s.language);

  useSEO(t("nav.about"), t("aboutPage.hero.description"));

  const { data: aboutData } = useQuery<IAboutData>({
    queryKey: ["about", language],
    queryFn: getAboutPageData,
  });

  const coreValues = aboutData?.core_values;
  const companyStory = aboutData?.company_story;
  const whyChooseUs = aboutData?.why_choose_us;
  const gallery = aboutData?.gallery;

  const galleryItems: IShowroomGalleryItem[] = useMemo(() => {
    if (!gallery || !gallery.length) return FALLBACK_GALLERY_ITEMS;
    return gallery.map((item) => ({
      id: item.id,
      src: getImageUrl(item.url) || "",
      type: item.type,
    }));
  }, [gallery]);

  const testimonials: ITestimonialItem[] = useMemo(() => {
    const api = aboutData?.testimonials ?? [];
    if (!api.length) return [];
    return api.map((item) => ({
      id: item.id,
      name: item.name,
      role: item.job_title,
      quote: item.content,
      avatar: getImageUrl(item.avatar) || APP_IMAGES.AVATAR_PLACEHOLDER,
      rating: item.rating,
    }));
  }, [aboutData]);

  return (
    <>
      <CoreValuesSection
        eyebrow={coreValues?.section?.title?.trim() || undefined}
        subtitle={coreValues?.section?.subtitle?.trim() || undefined}
        items={coreValues?.items?.length ? coreValues.items : undefined}
      />

      <AboutIntroSection
        titleStart={companyStory?.title?.trim() || undefined}
        titleHighlight={companyStory?.title1?.trim() || undefined}
        description={companyStory?.description?.trim() || undefined}
      />

      <WhyChooseUsSection
        titleStart={whyChooseUs?.section?.title?.trim() || undefined}
        titleHighlight={whyChooseUs?.section?.title1?.trim() || undefined}
        description={whyChooseUs?.section?.subtitle?.trim() || undefined}
        items={whyChooseUs?.items?.length ? whyChooseUs.items : undefined}
      />

      <ShowroomGallerySection
        logoSrc={APP_IMAGES.LOGO}
        items={galleryItems}
      />

      <TestimonialsSection
        testimonials={testimonials}
        autoPlay
        interval={5000}
      />
    </>
  );
}
