export interface IAboutGalleryItem {
  type: "image" | "video";
  file: string;
  thumbnail: string | null;
  caption: string;
  alt_text: string | null;
}
