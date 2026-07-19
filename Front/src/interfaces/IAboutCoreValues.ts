export interface IAboutCoreValuesItem {
  icon: string;
  title: string;
  description: string | null;
}

export interface IAboutCoreValues {
  section: {
    title: string;
    subtitle: string;
  };
  items: IAboutCoreValuesItem[];
}
