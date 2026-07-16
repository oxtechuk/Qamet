import type { IAboutHeroSection } from "./IAboutHeroSection";
import type { IAboutStorySection } from "./IAboutStorySection";
import type { IAboutPartnersSection } from "./IAboutPartnersSection";
import type { IAboutDealerSection } from "./IAboutDealerSection";
import type { IAboutLocationsSection } from "./IAboutLocationsSection";
import type { IAboutTestimonialsSection } from "./IAboutTestimonialsSection";

export interface IAboutPageSections {
  hero: IAboutHeroSection;
  story: IAboutStorySection;
  partners: IAboutPartnersSection;
  dealer: IAboutDealerSection;
  locations: IAboutLocationsSection;
  testimonials: IAboutTestimonialsSection;
}
