export interface IAboutGalleryItem {
  id: number;
  type: "image" | "video";
  url: string;
  thumb: string | null;
}
