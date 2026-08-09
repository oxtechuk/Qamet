import { Calculator, Car, FileText, Shield } from "lucide-react";
import type { LucideIcon } from "lucide-react";

const DEPARTMENT_ICONS: Record<string, LucideIcon> = {
    المبيعات: Car,
    sales: Car,
    التمويل: Calculator,
    finance: Calculator,
    "ما بعد البيع": Shield,
    "after sales": Shield,
};

export function getDepartmentIcon(label: string): LucideIcon {
    for (const [key, icon] of Object.entries(DEPARTMENT_ICONS)) {
        if (label.includes(key)) return icon;
    }
    return FileText;
}
