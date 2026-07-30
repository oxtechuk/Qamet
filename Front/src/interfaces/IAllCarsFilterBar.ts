export interface IAllCarsFilterBarProps {
  activeFilter?: string;
  onFilterChange?: (value: string) => void;
  onSearchChange?: (value: string) => void;
}
