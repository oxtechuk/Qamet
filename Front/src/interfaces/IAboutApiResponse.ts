import type { IAboutData } from "./IAboutData";

export interface IAboutApiResponse {
  success: boolean;
  message: string;
  data: IAboutData;
  errors: null;
  meta: null;
}
