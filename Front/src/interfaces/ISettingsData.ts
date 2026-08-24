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

export interface IIntegrationsInfo {
  gtm_id?: string;
  google_analytics_id?: string;
  facebook_pixel_id?: string;
  facebook_capi_token?: string;
  snapchat_pixel_id?: string;
  snapchat_capi_token?: string;
  tiktok_pixel_id?: string;
  tiktok_capi_token?: string;
  twitter_pixel_id?: string;
  header_scripts?: string;
  body_scripts?: string;
}

export interface ISettingsData {
  logo: string;
  logo_color: string | null;
  favicon: string;
  site_name: string;
  footer_text: string | null;
  contact: IContactInfo;
  working_hours: IWorkingHours;
  social_media: ISocialMediaItem[];
  hero_video?: string | null;
  hero_video_youtube?: string | null;
  integrations?: IIntegrationsInfo;
}
