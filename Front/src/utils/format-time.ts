import type { TFunction } from "i18next";

export function formatTime12h(time24: string, t: TFunction): string {
    const [hStr] = time24.split(":");
    let hour = parseInt(hStr, 10);
    if (hour === 0) hour = 12;
    const period = hour >= 12
        ? t("contactPage.contactMethods.evening")
        : t("contactPage.contactMethods.morning");
    if (hour > 12) hour -= 12;
    return `${hour} ${period}`;
}

export function formatWorkingHours(
    from: string,
    to: string,
    t: TFunction,
): string {
    return `${t("contactPage.contactMethods.timeFrom")} ${formatTime12h(from, t)} ${t("contactPage.contactMethods.timeTo")} ${formatTime12h(to, t)}`;
}
