export interface IStatItem {
  value: string;
  label: string;
}

export interface IFinanceSolutionsSectionProps {
  backgroundImage?: string;
  titleBlue: string;
  titleOrange: string;
  description: string;
  buttonText: string;
  buttonTo: string;
  stats: IStatItem[];
  features: string[];
  className?: string;
}
