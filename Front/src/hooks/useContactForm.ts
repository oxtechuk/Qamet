import { useState } from "react";
import { submitContactForm } from "../services/api/contact.service";
import { trackLead } from "../utils/analytics";
import type { IContactFormValues } from "../interfaces/IContactFormValues";

const EMPTY_FORM: IContactFormValues = {
    fullName: "",
    email: "",
    phone: "",
    country: "",
    subject: "",
    message: "",
};

export function useContactForm() {
    const [values, setValues] = useState<IContactFormValues>(EMPTY_FORM);
    const [submitStatus, setSubmitStatus] = useState<"idle" | "success" | "error">("idle");
    const [isSubmitting, setIsSubmitting] = useState(false);

    const set = <K extends keyof IContactFormValues>(
        k: K,
        v: IContactFormValues[K],
    ) => setValues((p: IContactFormValues) => ({ ...p, [k]: v }));

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setIsSubmitting(true);
        setSubmitStatus("idle");
        try {
            await submitContactForm({
                name: values.fullName,
                phone: values.phone,
                email: values.email,
                subject: values.subject,
                country: values.country,
                message: values.message,
            });

            trackLead({
                formName: "contact_form",
                name: values.fullName,
                phone: values.phone,
                email: values.email,
            });

            setSubmitStatus("success");
            setValues(EMPTY_FORM);
        } catch {
            setSubmitStatus("error");
        } finally {
            setIsSubmitting(false);
        }
    };

    return {
        values,
        set,
        submitStatus,
        isSubmitting,
        handleSubmit,
    };
}
