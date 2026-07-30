import type { ReactNode } from "react";

export interface IContactInfoCard {
    id: string;
    label: string;
    value: string;
    description: string;
    icon: ReactNode;
    iconClassName: string;
    href?: string;
}
