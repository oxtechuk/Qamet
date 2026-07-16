export interface ICarSelectProps {
  selectedSlug: string;
  onSelect: (slug: string) => void;
  onCancel: () => void;
  dir: string;
}
