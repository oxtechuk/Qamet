export interface ISocialMediaItem {
  icon: string;
  link: string;
  color: string;
}

export interface IContactInfo {
  email: string;
  phone: string;
  whatsapp: string;
  address: string;
}

export interface ISettingsData {
  logo: string;
  favicon: string;
  site_name: string;
  footer_text: string;
  contact: IContactInfo; 
  social_media: ISocialMediaItem[];
}
