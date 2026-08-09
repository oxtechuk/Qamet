import type { ICompareSection } from "./ICompareSection";
export interface ICompareSummaryProps {
  sections: ICompareSection[];
  car1Name: string;
  car2Name: string;
  car1Slug?: string;
  car2Slug?: string;
}
