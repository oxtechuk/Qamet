export interface IAboutData {
  hero: IAboutHeroSection;
  core_values: IAboutCoreValues;
  company_story: IAboutCompanyStory;
  why_choose_us: IAboutWhyChooseUs;
  gallery: IAboutGalleryItem[];
  testimonials: IAboutTestimonial[];
}

import type { IAboutHeroSection } from "./IAboutHeroSection";
import type { IAboutCoreValues } from "./IAboutCoreValues";
import type { IAboutCompanyStory } from "./IAboutCompanyStory";
import type { IAboutWhyChooseUs } from "./IAboutWhyChooseUs";
import type { IAboutGalleryItem } from "./IAboutGalleryItem";
import type { IAboutTestimonial } from "./IAboutTestimonial";
