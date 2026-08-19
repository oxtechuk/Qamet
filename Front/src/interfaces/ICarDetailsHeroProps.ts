export interface ICarColor {
  name: string;
  value: string;
  hex?: string;
  image?: string | null;
  images?: string[];
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
}
