import type { ReactNode } from "react";

export interface IPurchaseFeature {
    id: string;
    title: string;
    description: string;
    icon: ReactNode;
}

export interface IPurchaseExperienceSectionProps {
    title?: string;
    description?: string;
}
