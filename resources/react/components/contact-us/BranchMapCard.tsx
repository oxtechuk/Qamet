import { MapPin } from "lucide-react";
import type { IBranchMapCardProps } from "../../interfaces/IBranchMapCardProps";

export default function BranchMapCard({
    branches,
    activeBranchIdx,
    onBranchChange,
}: IBranchMapCardProps) {
    const branch = branches[activeBranchIdx] ?? branches[0];

    return (
        <div className="space-y-4">
            <div className="overflow-hidden">
                {branches.length > 1 && (
                    <div className="flex items-center justify-start gap-2 px-4 pt-4">
                        {branches.map((b, idx) => (
                            <button
                                key={b.id}
                                type="button"
                                onClick={() => onBranchChange(idx)}
                                className={[
                                    "h-[36px] rounded-full px-5 text-[13px] font-semibold transition",
                                    idx === activeBranchIdx
                                        ? "bg-[var(--brand-primary-color)] text-white"
                                        : "bg-[#F3F4F6] text-[#374151] hover:bg-[#E5E7EB]",
                                ].join(" ")}
                            >
                                {b.city}
                            </button>
                        ))}
                    </div>
                )}

                <div className="relative mt-3 h-[300px] w-full overflow-hidden rounded-[20px]">
                    <iframe
                        src={`https://maps.google.com/maps?q=${encodeURIComponent(branch.address)}&t=&z=15&ie=UTF8&iwloc=&output=embed`}
                        width="100%"
                        height="100%"
                        style={{ border: 0 }}
                        allowFullScreen
                        loading="lazy"
                        referrerPolicy="no-referrer-when-downgrade"
                        title={branch.name}
                    />
                    <div className="absolute bottom-3 inset-x-3 flex items-center gap-3 rounded-[12px] border border-[#E5E7EB] bg-white/90 px-4 py-3 shadow-md backdrop-blur-sm">
                        <span className="text-[var(--brand-primary-color)]">
                            <MapPin size={18} />
                        </span>
                        <div>
                            <p className="text-[14px] font-bold text-[#111827]">
                                {branch.name}
                            </p>
                            <p className="text-[12px] text-[#6B7280]">
                                {branch.address}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
