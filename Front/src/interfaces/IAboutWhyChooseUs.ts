export interface IAboutWhyChooseUsItem {
  icon: string;
  title: string;
  description: string | null;
}

export interface IAboutWhyChooseUs {
  section: {
    title: string;
    title1: string;
    subtitle: string;
  };
  items: IAboutWhyChooseUsItem[];
}
