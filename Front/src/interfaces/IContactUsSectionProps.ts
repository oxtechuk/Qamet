import type { IContactBranch } from "../types/contact.types";

export interface IContactUsSectionProps {
  title: string;
  description: string;
  branches?: IContactBranch[];
}
