export interface ICarColor {
  name: string;
  value: string;
  hex?: string;
  image?: string | null;
  images?: string[];
}

export interface ICarVariantItem {
  id: number;
  name: string;
  image?: string | null;
  cash_price?: number | null;
  min_installment?: number | null;
  min_down_payment?: number | null;
  specs?: Array<{ key: string; value?: string }> | Record<string, string>;
}

export interface ICarDetailsHeroProps {
  title: string;
  description: string;
  images: string[];
  exteriorImages?: string[];
  interiorImages?: string[];
  exteriorColors?: ICarColor[];
  interiorColors?: ICarColor[];
  price: number;
  oldPrice?: number;
  monthlyInstallment: number;
  savingAmount?: number;
  colors: ICarColor[];
  orderTo: string;
  financeTo: string;
  variants?: ICarVariantItem[];
}
