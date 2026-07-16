import type { IAboutTestimonial } from "./IAboutTestimonial";
import type { IAboutPartner } from "./IAboutPartner";
import type { IAboutStat } from "./IAboutStat";
import type { IAboutBranch } from "./IAboutBranch";
import type { IAboutPageSections } from "./IAboutPageSections";

export interface IAboutData {
  testimonials: IAboutTestimonial[];
  partners: IAboutPartner[];
  main_gallery: string[];
  about_stats: IAboutStat[];
  about_branches: IAboutBranch[];
  page_sections: IAboutPageSections;
}
