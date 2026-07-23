export interface ISpecItem {
  label: string;
  value: string;
}

export interface IFeatureItem {
  id: number;
  name: string;
  value?: string | null;
  icon: string;
}

export interface ITab {
  label: string;
  type: "specs" | "safety" | "other";
  items: ISpecItem[] | string[] | IFeatureItem[] | (string | IFeatureItem)[];
}

export interface ICarDetailsSpecsProps {
  tabs: ITab[];
}
