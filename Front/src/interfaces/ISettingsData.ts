export interface ISocialMediaItem {
  platform: string;
  url: string;
  color: string;
  // legacy aliases kept for compat
  icon?: string;
  link?: string;
}

export interface IWorkingHours {
  from: string;
  to: string;
  days: string[];
}

export interface IContactInfo {
  email: string;
  phone: string;
  whatsapp: string;
  address: string;
  sales_phone: string | null;
  finance_phone: string | null;
  aftersales_phone: string | null;
}

export interface ISettingsData {
  logo: string;
  favicon: string;
  site_name: string;
  footer_text: string | null;
  contact: IContactInfo;
  working_hours: IWorkingHours;
  social_media: ISocialMediaItem[];
}
