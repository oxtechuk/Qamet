export interface IContactDepartment {
  label: string;
  phone: string;
  hours: string;
}

export interface IContactBranch {
  id: number;
  city: string;
  name: string;
  address: string;
  map_link: string;
  departments: IContactDepartment[];
  sort_order: number;
}

export interface IContactPageHero {
  title: string;
  subtitle: string;
  image: string | null;
}

export interface IContactPageData {
  hero: IContactPageHero;
  branches: IContactBranch[];
}

export interface IContactPageApiResponse {
  success: boolean;
  message: string;
  data: IContactPageData;
  errors: null;
  meta: null;
}
