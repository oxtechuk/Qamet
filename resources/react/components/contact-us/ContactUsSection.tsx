import { useState } from "react";
import { useTranslation } from "react-i18next";
import type { IContactUsSectionProps } from "../../interfaces/IContactUsSectionProps";
import { useContactForm } from "../../hooks/useContactForm";
import BranchMapCard from "./BranchMapCard";
import DepartmentCard from "./DepartmentCard";
import ContactForm from "./ContactForm";

export default function ContactUsSection({
    title,
    description,
    branches = [],
}: IContactUsSectionProps) {
    const { i18n } = useTranslation();
    const [activeBranchIdx, setActiveBranchIdx] = useState(0);
    const branch = branches[activeBranchIdx] ?? branches[0] ?? null;

    const {
        values,
        set,
        submitStatus,
        isSubmitting,
        handleSubmit,
    } = useContactForm();

    return (
        <section dir={i18n.dir()} className="w-full py-14">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:items-start">
                    {branch && (
                        <div className="space-y-4">
                            <BranchMapCard
                                branches={branches}
                                activeBranchIdx={activeBranchIdx}
                                onBranchChange={setActiveBranchIdx}
                            />

                            {branch.departments.map((dep) => (
                                <DepartmentCard key={dep.label} department={dep} />
                            ))}
                        </div>
                    )}

                    <ContactForm
                        title={title}
                        description={description}
                        values={values}
                        set={set}
                        submitStatus={submitStatus}
                        isSubmitting={isSubmitting}
                        onSubmit={handleSubmit}
                    />
                </div>
            </div>
        </section>
    );
}
