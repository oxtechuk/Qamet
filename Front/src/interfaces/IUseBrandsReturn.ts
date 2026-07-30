import type { IBrandCardProps } from "./IBrandCardProps";

export interface IUseBrandsReturn {
  brandCards: IBrandCardProps[];
  search: string;
  setSearch: (value: string) => void;
  isLoading: boolean;
}
