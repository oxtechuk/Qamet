import type { ITableRow } from "./ITableRow";
export interface ITableSection {
  title: string;
  color: string;
  bgColor: string;
  rows: ITableRow[];
}
