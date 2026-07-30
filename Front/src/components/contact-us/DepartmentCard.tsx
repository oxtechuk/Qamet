import { Phone } from "lucide-react";
import type { IDepartmentCardProps } from "../../interfaces/IDepartmentCardProps";
import { getDepartmentIcon } from "./department-icons";

export default function DepartmentCard({ department }: IDepartmentCardProps) {
    const Icon = getDepartmentIcon(department.label);

    return (
        <div className="flex items-center justify-between rounded-[16px] border border-[#E5E7EB] bg-white px-5 py-4 shadow-sm">
            <div className="flex items-center gap-3">
                <div className="flex h-[40px] w-[40px] items-center justify-center rounded-full bg-[var(--brand-primary-color)] text-white">
                    <Icon size={18} />
                </div>
                <div className="text-start">
                    <p className="text-[14px] font-bold text-[#111827]">
                        {department.label}
                    </p>
                    <p className="text-[12px] text-[#9CA3AF]">
                        {department.hours}
                    </p>
                </div>
            </div>

            <div className="flex items-center gap-2 text-[#6B7280]">
                <Phone size={16} />
                <span className="text-[14px]" dir="ltr">
                    {department.phone}
                </span>
            </div>
        </div>
    );
}
