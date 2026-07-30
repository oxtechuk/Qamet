export interface ICompareRow {
  label: string;
  val1: string;
  val2: string;
  type: "price" | "unit" | "text" | "check";
  winner: number;
}
